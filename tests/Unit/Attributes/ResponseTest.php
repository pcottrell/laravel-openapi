<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Response;
use Tests\Unit\Attributes\Stubs\ResponseFactoryInvalidStub;
use Tests\Unit\Attributes\Stubs\ResponseFactoryStub;

describe('Response', function (): void {
    it('can set valid factory', function (): void {
        $Response = new Response(factory: ResponseFactoryStub::class);
        expect($Response->factory)->toBe(ResponseFactoryStub::class);
    });

    it('can handle invalid factory', function (): void {
        $this->expectException(InvalidArgumentException::class);
        new Response(factory: ResponseFactoryInvalidStub::class);
    });

    it('can handle none existing factory', function (): void {
        $this->expectException(InvalidArgumentException::class);
        new Response(factory: 'NonExistentFactory');
    });

    it('can handle null status code', function (): void {
        $Response = new Response(factory: ResponseFactoryStub::class);
        expect($Response->statusCode)->toBeNull();
    });

    it('can handle null description', function (): void {
        $Response = new Response(factory: ResponseFactoryStub::class);
        expect($Response->description)->toBeNull();
    });
})->covers(Response::class);
