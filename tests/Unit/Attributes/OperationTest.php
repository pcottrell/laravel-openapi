<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Operation;
use Tests\Unit\Attributes\Stubs\SecuritySchemeFactoryInvalidStub;
use Tests\Unit\Attributes\Stubs\SecuritySchemeFactoryStub;

describe('Operation', function () {
    it('can have no security', function () {
        $operation = new Operation();
        expect($operation->security)->toBeNull();
    });

    it('can be instantiated with a class FQN security', function () {
        $operation = new Operation(security: SecuritySchemeFactoryStub::class);
        expect($operation->security)->toBe(SecuritySchemeFactoryStub::class);
    });

    it('can be instantiated with an array of class FQN securities', function () {
        $operation = new Operation(security: [SecuritySchemeFactoryStub::class]);
        expect($operation->security)->toBe([SecuritySchemeFactoryStub::class]);
    });

    it('throws an exception when an invalid security is passed', function () {
        $this->expectException(InvalidArgumentException::class);
        new Operation(security: 'InvalidSecurity');
    });

    it('throws an exception when an invalid security is passed in an array', function () {
        $this->expectException(InvalidArgumentException::class);
        new Operation(security: ['InvalidSecurity']);
    });

    it('throws an exception when an invalid security is mixed with valid ones', function () {
        $this->expectException(InvalidArgumentException::class);
        new Operation(security: ['InvalidSecurity', SecuritySchemeFactoryStub::class]);
    });

    it('throws an exception when security is not an instance of SecuritySchemeFactory', function () {
        $this->expectException(InvalidArgumentException::class);
        new Operation(security: SecuritySchemeFactoryInvalidStub::class);
    });
})->covers(Operation::class);