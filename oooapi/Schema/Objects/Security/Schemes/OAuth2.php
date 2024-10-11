<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class OAuth2 extends SecurityScheme
{
    private function __construct(
        public Flows $flows,
        string|null $description = null,
    ) {
        parent::__construct('oauth2', $description);
    }

    public static function create(Flows $flows, string|null $description = null): self
    {
        return new self($flows, $description);
    }
    protected function toArray(): array
    {
        return Arr::filter([
            'type' => $this->type,
            'description' => $this->description,
            'flows' => $this->flows,
        ]);
    }
}
