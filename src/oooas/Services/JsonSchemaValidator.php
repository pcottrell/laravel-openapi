<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Services;

use JsonSchema\Constraints\BaseConstraint;
use JsonSchema\Validator;

final class JsonSchemaValidator
{
    private \stdClass $jsonSchema;

    private function __construct(
        private readonly Validator $validator,
        private readonly object $value,
    ) {
    }

    public static function againstOAS30x(array $value): self
    {
        return self::new($value, self::jsonFromFile(__DIR__ . '/../Schemas/v3.0.x.json'));
    }

    public static function new(array $value, \stdClass $jsonSchema): self
    {
        $clone = new self(new Validator(), BaseConstraint::arrayToObjectRecursive($value));

        return $clone->against($jsonSchema);
    }

    public function against(\stdClass $jsonSchema): self
    {
        $clone = clone $this;

        $clone->jsonSchema = $jsonSchema;

        return $clone;
    }

    public static function jsonFromFile(string $path): \stdClass
    {
        return json_decode(file_get_contents($path), false, 512, JSON_THROW_ON_ERROR);
    }

    public static function againstOAS31x(array $value): self
    {
        return self::new($value, self::jsonFromFile(__DIR__ . '/../Schemas/v3.1.x.json'));
    }

    public function validate(): self
    {
        $clone = clone $this;

        $clone->validator->validate($this->value, $this->jsonSchema);

        return $clone;
    }

    public function isValid(): bool
    {
        return $this->validator->isValid();
    }

    public function errors(): array
    {
        return $this->validator->getErrors();
    }
}
