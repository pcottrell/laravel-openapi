<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Callback;
use Tests\Stubs\Attributes\CallbackFactoryInvalidStub;
use Tests\Stubs\Attributes\CallbackFactoryStub;

describe('Callable', function (): void {
    it('can set valid factory', function (): void {
        $callback = new Callback(CallbackFactoryStub::class);
        expect($callback)->toBeInstanceOf(Callback::class);
    });

    it('can handle invalid factory', function (): void {
        expect(function (): void {
            new Callback(CallbackFactoryInvalidStub::class);
        })->toThrow(InvalidArgumentException::class);
    });

    it('can handle non existent factory', function (): void {
        expect(function (): void {
            new Callback('NonExistentFactory');
        })->toThrow(InvalidArgumentException::class);
    });
})->covers(Callback::class);
