<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Parameter;
use Tests\Unit\Attributes\Stubs\ParameterFactoryStub;
use Tests\Unit\Attributes\Stubs\ParametersFactoryInvalidStub;

describe('Parameters', function (): void {
    it('can set valid factory', function (): void {
        $parameters = new Parameter(factory: ParameterFactoryStub::class);
        expect($parameters->factory)->toBe(ParameterFactoryStub::class);
    });

    it('can handle invalid factory', function (): void {
        expect(function (): void {
            new Parameter(factory: ParametersFactoryInvalidStub::class);
        })->toThrow(InvalidArgumentException::class);
    });

    it('can handle none existing factory', function (): void {
        expect(function (): void {
            new Parameter(factory: 'NonExistentFactory');
        })->toThrow(InvalidArgumentException::class);
    });
})->covers(Parameter::class);
