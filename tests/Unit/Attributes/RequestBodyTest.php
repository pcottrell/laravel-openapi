<?php

use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody;
use Tests\Unit\Attributes\Stubs\RequestBodyFactoryInvalidStub;
use Tests\Unit\Attributes\Stubs\RequestBodyFactoryStub;

describe('RequestBody', function () {
    it('can set valid factory', function () {
        $RequestBody = new RequestBody(factory: RequestBodyFactoryStub::class);
        expect($RequestBody->factory)->toBe(RequestBodyFactoryStub::class);
    });

    it('can handle invalid factory', function () {
        $this->expectException(InvalidArgumentException::class);
        new RequestBody(factory: RequestBodyFactoryInvalidStub::class);
    });

    it('can handle none existing factory', function () {
        $this->expectException(InvalidArgumentException::class);
        new RequestBody(factory: 'NonExistentFactory');
    });
})->covers(RequestBody::class);
