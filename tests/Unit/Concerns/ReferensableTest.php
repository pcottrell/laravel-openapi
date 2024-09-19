<?php

use MohammadAlavi\LaravelOpenApi\Concerns\Referencable;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;
use Tests\Doubles\Stubs\Concerns\NotReusableResponseFactory;
use Tests\Doubles\Stubs\Concerns\ReusableParameterFactory;

describe('Referensable', function (): void {
    it('throws exception if class does not implement Reusable', function (): void {
        $schema = NotReusableResponseFactory::ref();

        $schema::ref();
    })->throws(InvalidArgumentException::class);

    it('doesnt work with parameter factory', function (): void {
        expect(fn () => ReusableParameterFactory::ref())
            ->toThrow(ErrorException::class, 'Attempt to read property "objectId" on array');
    })->note('This might be a bug as I think this should also work wit Parameters as per OAS v3.1.
     It doesnt work because its build() method returns an array.');

    it('can be created for all factories', function ($factory, string $expected): void {
        $schema = $factory::ref();

        expect($schema)->toBeInstanceOf(MohammadAlavi\ObjectOrientedOAS\Objects\Schema::class)
            ->and($schema->toArray())->toBe([
                '$ref' => $expected,
            ]);
    })->with([
        [
            new class () extends CallbackFactory implements Reusable {
                use Referencable;

                public function build(): PathItem
                {
                    return PathItem::create('PathItemObjectId');
                }
            }, '#/components/callbacks/PathItemObjectId',
        ],
        [
            new class () extends CallbackFactory implements Reusable {
                use Referencable;

                public function build(): PathItem
                {
                    return PathItem::create();
                }
            }, '#/components/callbacks/',
        ],
        // TODO: These throw errors but shouldn't
        //        [
        //            new class () extends ParameterFactory implements Reusable {
        //                use Referencable;
        //
        //                public function build(): array
        //                {
        //                    return [Parameter::create('ParameterObjectId')];
        //                }
        //            }, '#/components/parameters/ParameterObjectId',
        //        ],
        //        [
        //            new class () extends ParameterFactory implements Reusable {
        //                use Referencable;
        //
        //                public function build(): array
        //                {
        //                    return [Parameter::create()];
        //                }
        //            }, '#/components/parameters/',
        //        ],
        [
            new class () extends RequestBodyFactory implements Reusable {
                use Referencable;

                public function build(): RequestBody
                {
                    return RequestBody::create('RequestBodyItemObjectId');
                }
            }, '#/components/requestBodies/RequestBodyItemObjectId',
        ],
        [
            new class () extends RequestBodyFactory implements Reusable {
                use Referencable;

                public function build(): RequestBody
                {
                    return RequestBody::create();
                }
            }, '#/components/requestBodies/',
        ],
        [
            new class () extends ResponseFactory implements Reusable {
                use Referencable;

                public function build(): MohammadAlavi\ObjectOrientedOAS\Objects\Response
                {
                    return MohammadAlavi\ObjectOrientedOAS\Objects\Response::create('ResponseItemObjectId');
                }
            }, '#/components/responses/ResponseItemObjectId',
        ],
        [
            new class () extends ResponseFactory implements Reusable {
                use Referencable;

                public function build(): MohammadAlavi\ObjectOrientedOAS\Objects\Response
                {
                    return MohammadAlavi\ObjectOrientedOAS\Objects\Response::create();
                }
            }, '#/components/responses/',
        ],
        [
            new class () extends SchemaFactory implements Reusable {
                use Referencable;

                public function build(): MohammadAlavi\ObjectOrientedOAS\Objects\Schema
                {
                    return MohammadAlavi\ObjectOrientedOAS\Objects\Schema::create('SchemaItemObjectId');
                }
            }, '#/components/schemas/SchemaItemObjectId',
        ],
        [
            new class () extends SchemaFactory implements Reusable {
                use Referencable;

                public function build(): MohammadAlavi\ObjectOrientedOAS\Objects\Schema
                {
                    return MohammadAlavi\ObjectOrientedOAS\Objects\Schema::create();
                }
            }, '#/components/schemas/',
        ],
        [
            new class () extends SecuritySchemeFactory implements Reusable {
                use Referencable;

                public function build(): SecurityScheme
                {
                    return SecurityScheme::create('SecuritySchemeItemObjectId');
                }
            }, '#/components/securitySchemes/SecuritySchemeItemObjectId',
        ],
        [
            new class () extends SecuritySchemeFactory implements Reusable {
                use Referencable;

                public function build(): SecurityScheme
                {
                    return SecurityScheme::create();
                }
            }, '#/components/securitySchemes/',
        ],
    ]);
})->coversTrait(Referencable::class);