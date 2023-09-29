<?php

namespace Vyuldashev\LaravelOpenApi\Attributes;

use Attribute;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

#[Attribute(Attribute::TARGET_METHOD)]
class Operation
{
    /**
     * @param class-string<Tag>|array<array-key, class-string<Tag>>|null $tags
     * @param class-string<SecuritySchemeFactory>|array<array-key, class-string<SecuritySchemeFactory>>|array<array-key, array<array-key, class-string<SecuritySchemeFactory>>|null $security
     */
    public function __construct(
        public string|null $id = null,
        public string|array|null $tags = null,
        public string|array|null $security = null,
        public string|null $method = null,
        public array|null $servers = null,
        public string|null $summary = null,
        public string|null $description = null,
        public bool|null $deprecated = null,
    ) {
        $this->tags = Arr::wrap($this->tags);
        $this->validateSecurity($this->security);
    }

    private function validateSecurity(string|array|null $security): void
    {
        if (empty($this->security)) {
            return;
        }

        if (is_string($security)) {
            $this->validateSecurityScheme($security);
        } else {
            foreach ($security as $securityItem) {
                if (is_array($securityItem)) {
                    foreach ($securityItem as $securityScheme) {
                        $this->validateSecurityScheme($securityScheme);
                    }
                    continue;
                }
                $this->validateSecurityScheme($securityItem);
            }
        }
    }

    private function validateSecurityScheme(string $securityScheme): void
    {
        if (!class_exists($securityScheme) || !is_a($securityScheme, SecuritySchemeFactory::class, true)) {
            throw new InvalidArgumentException(sprintf('Security class is either not declared or is not an instance of %s', SecuritySchemeFactory::class));
        }
    }
}
