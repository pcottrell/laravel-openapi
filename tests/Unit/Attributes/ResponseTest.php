<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Response;
use Tests\Unit\Attributes\Stubs\ResponseFactoryInvalidStub;
use Tests\Unit\Attributes\Stubs\ResponseFactoryStub;

describe('Response', function () {
    it('can set valid factory', function () {
        $Response = new Response(factory: ResponseFactoryStub::class);
        expect($Response->factory)->toBe(ResponseFactoryStub::class);
    });

    it('can handle invalid factory', function () {
        $this->expectException(InvalidArgumentException::class);
        new Response(factory: ResponseFactoryInvalidStub::class);
    });

    it('can handle none existing factory', function () {
        $this->expectException(InvalidArgumentException::class);
        new Response(factory: 'NonExistentFactory');
    });

    it('can handle null status code', function () {
        $Response = new Response(factory: ResponseFactoryStub::class);
        expect($Response->statusCode)->toBeNull();
    });

    it('can handle null description', function () {
        $Response = new Response(factory: ResponseFactoryStub::class);
        expect($Response->description)->toBeNull();
    });
})->covers(Response::class);