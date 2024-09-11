<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Parameter;
use Tests\Unit\Attributes\Stubs\ParameterFactoryStub;
use Tests\Unit\Attributes\Stubs\ParametersFactoryInvalidStub;

describe('Parameters', function () {
    it('can set valid factory', function () {
        $parameters = new Parameter(factory: ParameterFactoryStub::class);
        expect($parameters->factory)->toBe(ParameterFactoryStub::class);
    });

    it('can handle invalid factory', function () {
        $this->expectException(InvalidArgumentException::class);
        new Parameter(factory: ParametersFactoryInvalidStub::class);
    });

    it('can handle none existing factory', function () {
        $this->expectException(InvalidArgumentException::class);
        new Parameter(factory: 'NonExistentFactory');
    });
})->covers(Parameter::class);
