<?php

namespace Tests\Doubles\Stubs\Objects;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation;
use MohammadAlavi\LaravelOpenApi\Attributes\PathItem;

#[PathItem]
#[Collection('example')]
class MultiActionController
{
    public function actionWithTypeHintedParams(int $id, string $unHinted, $unknown): void
    {
    }


    #[Operation]
    public function anotherExample(): void
    {
    }

    #[Operation]
    #[Collection('another-collection')]
    public function example()
    {
    }
}
