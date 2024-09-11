<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Callback;
use Tests\Unit\Attributes\Stubs\CallbackFactoryInvalidStub;
use Tests\Unit\Attributes\Stubs\CallbackFactoryStub;

describe('Callable', function (): void {
    it('can set valid factory', function (): void {
        $callback = new Callback(CallbackFactoryStub::class);
        expect($callback)->toBeInstanceOf(Callback::class);
    });

    it('can handle invalid factory', function (): void {
        $this->expectException(InvalidArgumentException::class);
        new Callback(CallbackFactoryInvalidStub::class);
    });

    it('can handle non existent factory', function (): void {
        $this->expectException(InvalidArgumentException::class);
        new Callback('NonExistentFactory');
    });
})->covers(Callback::class);
