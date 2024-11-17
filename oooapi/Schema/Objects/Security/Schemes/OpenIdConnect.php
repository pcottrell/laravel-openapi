<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums\SecuritySchemeType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class OpenIdConnect extends SecurityScheme
{
    public $type;
    private function __construct(
        private string $openIdConnectUrl,
        string|null $description,
    ) {
        parent::__construct(SecuritySchemeType::OPEN_ID_CONNECT, $description);
    }

    public static function create(string $openIdConnectUrl, string|null $description = null): self
    {
        return new self($openIdConnectUrl, $description);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'type' => $this->type,
            'description' => $this->description,
            'openIdConnectUrl' => $this->openIdConnectUrl,
        ]);
    }
}
