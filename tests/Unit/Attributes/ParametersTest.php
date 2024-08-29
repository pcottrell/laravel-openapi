<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Parameters;
use Tests\Unit\Attributes\Stubs\ParametersFactoryInvalidStub;
use Tests\Unit\Attributes\Stubs\ParametersFactoryStub;

describe('Parameters', function () {
    it('can set valid factory', function () {
        $parameters = new Parameters(factory: ParametersFactoryStub::class);
        expect($parameters->factory)->toBe(ParametersFactoryStub::class);
    });

    it('can handle invalid factory', function () {
        $this->expectException(InvalidArgumentException::class);
        new Parameters(factory: ParametersFactoryInvalidStub::class);
    });

    it('can handle none existing factory', function () {
        $this->expectException(InvalidArgumentException::class);
        new Parameters(factory: 'NonExistentFactory');
    });
})->covers(Parameters::class);