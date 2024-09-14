<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Parameter;
use Tests\Doubles\Stubs\Attributes\ParameterFactory;
use Tests\Doubles\Stubs\Attributes\ParametersFactoryInvalid;

describe('Parameters', function (): void {
    it('can set valid factory', function (): void {
        $parameters = new Parameter(factory: ParameterFactory::class);
        expect($parameters->factory)->toBe(ParameterFactory::class);
    });

    it('can handle invalid factory', function (): void {
        expect(function (): void {
            new Parameter(factory: ParametersFactoryInvalid::class);
        })->toThrow(InvalidArgumentException::class);
    });

    it('can handle none existing factory', function (): void {
        expect(function (): void {
            new Parameter(factory: 'NonExistentFactory');
        })->toThrow(InvalidArgumentException::class);
    });
})->covers(Parameter::class);
