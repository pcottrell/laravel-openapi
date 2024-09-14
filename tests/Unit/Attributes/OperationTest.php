<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Operation;
use Tests\Doubles\Stubs\Attributes\SecuritySchemeFactoryInvalidStub;
use Tests\Doubles\Stubs\Attributes\SecuritySchemeFactoryStub;

describe('Operation', function (): void {
    it('can be created with no parameters', function (): void {
        $operation = new Operation();

        expect($operation->id)->toBeNull()
            ->and($operation->tags)->toBeNull()
            ->and($operation->security)->toBeNull()
            ->and($operation->method)->toBeNull()
            ->and($operation->servers)->toBeNull()
            ->and($operation->summary)->toBeNull()
            ->and($operation->description)->toBeNull()
            ->and($operation->deprecated)->toBeNull();
    });

    it('can be created with all parameters', function (): void {
        $operation = new Operation(
            id: 'id',
            tags: 'tags',
            security: SecuritySchemeFactoryStub::class,
            method: 'method',
            servers: 'servers',
            summary: 'summary',
            description: 'description',
            deprecated: true,
        );

        expect($operation->id)->toBe('id')
            ->and($operation->tags)->toBe('tags')
            ->and($operation->security)->toBe(SecuritySchemeFactoryStub::class)
            ->and($operation->method)->toBe('method')
            ->and($operation->servers)->toBe('servers')
            ->and($operation->summary)->toBe('summary')
            ->and($operation->description)->toBe('description')
            ->and($operation->deprecated)->toBeTrue();
    });

    it('doesnt accept invalid security combinations', function (string|array $security): void {
        expect(function () use ($security): void {
            new Operation(security: $security);
        })->toThrow(InvalidArgumentException::class);
    })->with([
        [
            '',
        ],
        [
            [[]],
        ],
        [
            [''],
        ],
        [
            [['']],
        ],
        [
            ['', []],
        ],
        [
            ['', ['']],
        ],
        [
            ['invalid', 'input'],
        ],
        [
            ['nested', ['invalid']],
        ],
        [
            [null],
        ],
        [
            [null, []],
        ],
        [
            [null, '', []],
        ],
        [
            ['non-empty', [null, '']],
        ],
        [
            ['InvalidSecurity', SecuritySchemeFactoryStub::class],
        ],
    ]);

    it('can remove top level security', function (): void {
        $operation = new Operation(security: []);
        expect($operation->security)->toBe([]);
    });

    it('can use top level security', function (): void {
        $operation = new Operation(security: null);
        expect($operation->security)->toBeNull();
    });

    it('uses top level security by default', function (): void {
        $operation = new Operation();
        expect($operation->security)->toBeNull();
    });

    it('can be created with a class FQN security', function (): void {
        $operation = new Operation(security: SecuritySchemeFactoryStub::class);
        expect($operation->security)->toBe(SecuritySchemeFactoryStub::class);
    });

    it('can be created with an array of class FQN securities', function (): void {
        $operation = new Operation(security: [SecuritySchemeFactoryStub::class]);
        expect($operation->security)->toBe([SecuritySchemeFactoryStub::class]);
    });

    it('can be created with an array of arrays of class FQN securities', function (): void {
        $operation = new Operation(security: [[SecuritySchemeFactoryStub::class]]);
        expect($operation->security)->toBe([[SecuritySchemeFactoryStub::class]]);
    });

    it('can be created with a combination of class FQN and array of class FQN securities', function (): void {
        $operation = new Operation(security: [SecuritySchemeFactoryStub::class, [SecuritySchemeFactoryStub::class]]);
        expect($operation->security)->toBe([SecuritySchemeFactoryStub::class, [SecuritySchemeFactoryStub::class]]);
    });

    it('throws an exception when an invalid security is passed', function (): void {
        expect(function (): void {
            new Operation(security: 'InvalidSecurity');
        })->toThrow(InvalidArgumentException::class);
    });

    it('throws an exception when an invalid security is passed in an array', function (): void {
        expect(function (): void {
            new Operation(security: ['InvalidSecurity']);
        })->toThrow(InvalidArgumentException::class);
    });

    it('throws an exception when security is not an instance of SecuritySchemeFactory', function (): void {
        expect(function (): void {
            new Operation(security: SecuritySchemeFactoryInvalidStub::class);
        })->toThrow(InvalidArgumentException::class);
    });
})->covers(Operation::class);
