<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use MohammadAlavi\LaravelOpenApi\Builders\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;
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

    /** @var Server[]|null */
    protected array|null $servers = null;

    protected Paths|null $paths = null;
    protected Components|null $components = null;
    protected Security|null $security = null;

    /** @var Tag[]|null */
    protected array|null $tags = null;

    protected ExternalDocs|null $externalDocs = null;
    private readonly OASVersion $openapi;

    public function openapi(OASVersion $openapi): static
    {
        $clone = clone $this;

        $clone->openapi = $openapi;

        return $clone;
    }

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

    /**
     * @throws CircularDependencyException
     * @throws BindingResolutionException
     */
    public function nestedSecurity(array $security): static
    {
        $securityRequirements = app(SecurityRequirementBuilder::class)->build($security);

        return $this->security($securityRequirements);
    }

    // This is just a wrapper around parent class security()
    // to allow for multiple security requirements

    /**
     * You should only send one security requirement per operation.
     * If you send more than one, the first one will be used.
     */
    public function security(SecurityRequirementOld ...$securityRequirement): static
    {
        $clone = clone $this;

        $clone->security = Security::create(...$securityRequirement);

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
            'paths' => $this->paths,
            'components' => $this->components,
            'security' => $this->security,
            'tags' => $this->tags,
            'externalDocs' => $this->externalDocs,
        ]);
    }
}
