<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

// TODO: there are 2 different objects OAuthFlow and OAuthFlows, but we only have one!
//  https://swagger.io/specification/#oauth-flows-object
class OAuthFlow extends BaseObject
{
    public const FLOW_IMPLICIT = 'implicit';
    public const FLOW_PASSWORD = 'password';
    public const FLOW_CLIENT_CREDENTIALS = 'clientCredentials';
    public const FLOW_AUTHORIZATION_CODE = 'authorizationCode';

    protected string|null $flow = null;
    protected string|null $authorizationUrl = null;
    protected string|null $tokenUrl = null;
    protected string|null $refreshUrl = null;
    protected array|null $scopes = null;

    public function flow(string|null $flow): static
    {
        $instance = clone $this;

        $instance->flow = $flow;

        return $instance;
    }

    public function authorizationUrl(string|null $authorizationUrl): static
    {
        $instance = clone $this;

        $instance->authorizationUrl = $authorizationUrl;

        return $instance;
    }

    public function tokenUrl(string|null $tokenUrl): static
    {
        $instance = clone $this;

        $instance->tokenUrl = $tokenUrl;

        return $instance;
    }

    public function refreshUrl(string|null $refreshUrl): static
    {
        $instance = clone $this;

        $instance->refreshUrl = $refreshUrl;

        return $instance;
    }

    /**
     * @param array<string, string>|null $scopes
     *
     * @throws InvalidArgumentException
     */
    public function scopes(array|null $scopes): static
    {
        if (is_array($scopes)) {
            foreach ($scopes as $key => $value) {
                if (!is_string($key) || !is_string($value)) {
                    throw new InvalidArgumentException('Each scope must have a string key and a string value.');
                }
            }
        }

        $instance = clone $this;

        $instance->scopes = $scopes;

        return $instance;
    }

    public function generate(): array
    {
        return Arr::filter([
            'authorizationUrl' => $this->authorizationUrl,
            'tokenUrl' => $this->tokenUrl,
            'refreshUrl' => $this->refreshUrl,
            'scopes' => $this->scopes,
        ]);
    }
}
