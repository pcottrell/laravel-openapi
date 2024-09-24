<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Extensible;
use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Generatable;
use MohammadAlavi\LaravelOpenApi\oooas\Traits\Extension;

/** @property array|null $x */
abstract class BaseObject implements \JsonSerializable, Generatable, Extensible
{
    use Extension;

    protected string|null $ref = null;

    protected function __construct(
        protected readonly string|null $objectId = null,
    ) {
    }

    public static function create(string|null $objectId = null): static
    {
        return new static($objectId);
    }

    // TODO: It seems not all objects need the ref method.
    //  Only objects that can be Components and reusable needs this method.
    //  Maybe this can be moved to a trait + interface.
    //  https://swagger.io/specification/#components-object
    public static function ref(string $ref, string|null $objectId = null): static
    {
        $static = new static($objectId);

        $static->ref = $ref;

        return $static;
    }

    /** @throws \JsonException */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | $options);
    }

    public function toArray(): array
    {
        if (!is_null($this->ref)) {
            return ['$ref' => $this->ref];
        }

        return array_merge(
            $this->generate(),
            $this->extensions()->toArray(),
        );
    }

    /**
     * Specify data which should be serialized to JSON.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
