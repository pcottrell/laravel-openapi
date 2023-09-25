<?php

namespace Vyuldashev\LaravelOpenApi\Attributes;

use Attribute;
use InvalidArgumentException;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\SkipGlobalSecurityScheme;

use function PHPUnit\Framework\assertNotEmpty;

#[Attribute(Attribute::TARGET_METHOD)]
class Operation
{
    /**
     * @param array<string>|null $tags
     * @param class-string<SecuritySchemeFactory>|array<array-key, SecuritySchemeFactory>|array<array-key, array<array-key, SecuritySchemeFactory>|null $security
     */
    public function __construct(
        public string|null $id = null,
        public array|null $tags = null,
        public string|array|null $security = null,
        public string|null $method = null,
        public array|null $servers = null,
        public string|null $summary = null,
        public string|null $description = null,
        public bool|null $deprecated = null,
    ) {
        if (is_null($this->security)) {
            $this->security = DefaultSecurityScheme::class;
        }

        $this->validateSecurity($this->security);
    }

    private function validateSecurity(string|array $security): void
    {
        assertNotEmpty($security, 'Security must not be empty. Use ' . SkipGlobalSecurityScheme::class . ' to skip security');

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
