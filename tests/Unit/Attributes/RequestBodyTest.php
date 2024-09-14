<?php

use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody;
use Tests\Stubs\Attributes\RequestBodyFactoryInvalidStub;
use Tests\Stubs\Attributes\RequestBodyFactoryStub;

describe('RequestBody', function (): void {
    it('can set valid factory', function (): void {
        $RequestBody = new RequestBody(factory: RequestBodyFactoryStub::class);
        expect($RequestBody->factory)->toBe(RequestBodyFactoryStub::class);
    });

    it('can handle invalid factory', function (): void {
        expect(function (): void {
            new RequestBody(factory: RequestBodyFactoryInvalidStub::class);
        })->toThrow(InvalidArgumentException::class);
    });

    it('can handle none existing factory', function (): void {
        expect(function (): void {
            new RequestBody(factory: 'NonExistentFactory');
        })->toThrow(InvalidArgumentException::class);
    });
})->covers(RequestBody::class);
