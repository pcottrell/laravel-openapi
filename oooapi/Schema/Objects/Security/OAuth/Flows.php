<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\AuthorizationCode;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\ClientCredentials;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\Implicit;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\Password;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

final readonly class Flows extends ReadonlyJsonSerializable
{
    private function __construct(
        private Implicit|null $implicit = null,
        private Password|null $password = null,
        private ClientCredentials|null $clientCredentials = null,
        private AuthorizationCode|null $authorizationCode = null,
    ) {
    }

    /**
     * Get all scopes of all flows combined in a collection.
     */
    public function scopeCollection(): ScopeCollection
    {
        /** @var Flow[] $flows */
        $flows = Arr::filter([
            $this->implicit,
            $this->password,
            $this->clientCredentials,
            $this->authorizationCode,
        ]);

        $scopeCollection = ScopeCollection::create();

        foreach ($flows as $flow) {
            $scopeCollection = $scopeCollection->merge($flow->scopeCollection());
        }

        return $scopeCollection;
    }

    public static function create(
        Implicit|null $implicit = null,
        Password|null $password = null,
        ClientCredentials|null $clientCredentials = null,
        AuthorizationCode|null $authorizationCode = null,
    ): self {
        return new self($implicit, $password, $clientCredentials, $authorizationCode);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'implicit' => $this->implicit,
            'password' => $this->password,
            'clientCredentials' => $this->clientCredentials,
            'authorizationCode' => $this->authorizationCode,
        ]);
    }
}
