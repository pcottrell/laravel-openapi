<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\MediaType;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(RequestBody::class)]
class RequestBodyTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $requestBody = RequestBody::create()
            ->description('Standard request')
            ->content(MediaType::json())
            ->required();

        $operation = Operation::create()
            ->requestBody($requestBody);

        $this->assertEquals([
            'requestBody' => [
                'description' => 'Standard request',
                'content' => [
                    'application/json' => [],
                ],
                'required' => true,
            ],
        ], $operation->serialize());
    }
}
