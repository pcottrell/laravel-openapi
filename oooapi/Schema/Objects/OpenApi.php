<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Security;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

class OpenApi extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

    protected Info|null $info = null;
    protected Paths|null $paths = null;
    protected Components|null $components = null;
    protected Security|null $security = null;
    protected ExternalDocs|null $externalDocs = null;

    /** @var Server[]|null */
    protected array|null $servers = null;

    /** @var Tag[]|null */
    protected array|null $tags = null;

    private readonly OASVersion $openapi;

    public function openapi(OASVersion $openapi): static
    {
        $clone = clone $this;

        $clone->openapi = $openapi;

        return $clone;
    }

    // TODO: info cannot be null per the spec
    // It is required
    public function info(Info|null $info): static
    {
        $clone = clone $this;

        $clone->info = $info;

        return $clone;
    }

    public function servers(Server ...$server): static
    {
        $clone = clone $this;

        $clone->servers = [] !== $server ? $server : null;

        return $clone;
    }

    public function paths(Paths|null $paths): static
    {
        $clone = clone $this;

        $clone->paths = $paths;

        return $clone;
    }

    public function components(Components|null $components): static
    {
        $clone = clone $this;

        $clone->components = $components;

        return $clone;
    }

    public function nestedSecurity(array $security): static
    {
        return $this;
    }

    public function security(Security $security): static
    {
        $clone = clone $this;

        $clone->security = $security;

        return $clone;
    }

    public function tags(Tag ...$tag): static
    {
        $clone = clone $this;

        $clone->tags = [] !== $tag ? $tag : null;

        return $clone;
    }

    public function externalDocs(ExternalDocs|null $externalDocs): static
    {
        $clone = clone $this;

        $clone->externalDocs = $externalDocs;

        return $clone;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'openapi' => $this->openapi->value ?? OASVersion::V_3_1_0->value,
            'info' => $this->info,
            'servers' => $this->servers,
            'paths' => $this->toObjectIfEmpty($this->paths),
            'components' => $this->toObjectIfEmpty($this->components),
            'security' => $this->security,
            'tags' => $this->tags,
            'externalDocs' => $this->externalDocs,
        ]);
    }
}
