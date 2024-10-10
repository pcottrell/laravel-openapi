<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use MohammadAlavi\LaravelOpenApi\Builders\SecurityRequirementBuilder;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

class OpenApi extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

    protected Info|null $info = null;

    /** @var Server[]|null */
    protected array|null $servers = null;

    /** @var PathItem[]|null */
    protected array|null $paths = null;

    protected Components|null $components = null;

    /** @var SecurityRequirement|SecurityRequirement[]|null */
    protected SecurityRequirement|array|null $security = null;

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

    public function paths(PathItem ...$pathItem): static
    {
        $clone = clone $this;

        $clone->paths = [] !== $pathItem ? $pathItem : null;

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
    public function security(SecurityRequirement ...$securityRequirement): static
    {
        //        $clone = clone $this;
        //
        //        $clone->security = [] !== $securityRequirement ? $securityRequirement : null;
        //
        //        return $clone;

        $clone = clone $this;

        if ([] === $securityRequirement) {
            $clone->security = null;

            return $clone;
        }

        if ($this->hasNoGlobalSecurity($securityRequirement[0])) {
            $clone->security = null;

            return $clone;
        }

        $clone->security = $securityRequirement[0];

        return $clone;
    }

    private function hasNoGlobalSecurity(SecurityRequirement $securityRequirement): bool
    {
        return NoSecurityScheme::NAME === $securityRequirement->securityScheme;
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
        $paths = [];
        foreach ($this->paths ?? [] as $path) {
            $paths[$path->path] = $path;
        }

        return Arr::filter([
            'openapi' => $this->openapi->value ?? OASVersion::V_3_1_0->value,
            'info' => $this->info,
            'servers' => $this->servers,
            'paths' => [] !== $paths ? $paths : null,
            'components' => $this->components,
            'security' => $this->security,
            'tags' => $this->tags,
            'externalDocs' => $this->externalDocs,
        ]);
    }
}
