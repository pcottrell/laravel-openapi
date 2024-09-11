<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Extension;
use Tests\Unit\Attributes\Stubs\ExtensionFactoryInvalidStub;
use Tests\Unit\Attributes\Stubs\ExtensionFactoryStub;

describe('Extension', function (): void {
    it('can handle null factory', function (): void {
        $extension = new Extension();
        expect($extension->factory)->toBeNull();
    });

    it('can handle null key', function (): void {
        $extension = new Extension();
        expect($extension->key)->toBeNull();
    });

    it('can handle null value', function (): void {
        $extension = new Extension();
        expect($extension->value)->toBeNull();
    });

    it('can set valid factory', function (): void {
        $extension = new Extension(factory: ExtensionFactoryStub::class);
        expect($extension->factory)->toBe(ExtensionFactoryStub::class);
    });

    it('can handle invalid factory', function (): void {
        $this->expectException(InvalidArgumentException::class);
        new Extension(factory: ExtensionFactoryInvalidStub::class);
    });

    it('can handle none existing factory', function (): void {
        $this->expectException(InvalidArgumentException::class);
        new Extension(factory: 'NonExistentFactory');
    });
})->covers(Extension::class);
