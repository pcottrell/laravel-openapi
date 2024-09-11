<?php

use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody;
use Tests\Unit\Attributes\Stubs\RequestBodyFactoryInvalidStub;
use Tests\Unit\Attributes\Stubs\RequestBodyFactoryStub;

describe('RequestBody', function (): void {
    it('can set valid factory', function (): void {
        $RequestBody = new RequestBody(factory: RequestBodyFactoryStub::class);
        expect($RequestBody->factory)->toBe(RequestBodyFactoryStub::class);
    });

    it('can handle invalid factory', function (): void {
        $this->expectException(InvalidArgumentException::class);
        new RequestBody(factory: RequestBodyFactoryInvalidStub::class);
    });

    it('can handle none existing factory', function (): void {
        $this->expectException(InvalidArgumentException::class);
        new RequestBody(factory: 'NonExistentFactory');
    });
})->covers(RequestBody::class);
