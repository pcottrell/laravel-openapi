<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Attributes\Response as ResponseAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ResponseFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;

// TODO: implement it
// All codes below are just placeholders
class ResponsesBuilder
{
    /** @return array<array-key, Response|Reference> */
    public function build(ResponseAttribute ...$attributes): array
    {
        return collect($attributes)
            // TODO: can this be refactored to use when()?
            ->map(static function (ResponseAttribute $responseAttribute) {
                if (is_a($responseAttribute->factory, ReusableResponseFactory::class, true)) {
                    return $responseAttribute->factory::ref();
                }

                /** @var ResponseFactory $factory */
                $factory = app($responseAttribute->factory);

                return $factory->build();
            })
            ->values()
            ->toArray();
    }
}
