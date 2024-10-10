<?php

namespace Tests\oooas\Unit\Utilities;

use MohammadAlavi\LaravelOpenApi\oooas\Extensions\Extension;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Components;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;
use Webmozart\Assert\InvalidArgumentException;

describe('Extensions', function (): void {
    dataset('extensibleObjectSet', [
        fn (): Components => Components::create(),
        fn (): Operation => Operation::create(),
        fn (): PathItem => PathItem::create(),
        fn (): Response => Response::ok(),
        fn (): Schema => Schema::create('test'),
    ]);

    it('can create objects with extension', function (ExtensibleObject $extensibleObject): void {
        $arraySchema = Schema::array('test')->items(Schema::string('test'));
        $extension1 = Extension::create('x-key', 'value');
        $extension2 = Extension::create('x-foo', 'bar');
        $extension3 = Extension::create('x-baz', null);
        $extension4 = Extension::create('x-array', $arraySchema);
        $object = $extensibleObject
            ->addExtension($extension1)
            ->addExtension($extension2)
            ->addExtension($extension3)
            ->addExtension($extension4);

        expect($object->jsonSerialize())->toBe([
            'x-key' => 'value',
            'x-foo' => 'bar',
            'x-baz' => null,
            'x-array' => $arraySchema,
        ]);
    })->with('extensibleObjectSet');

    it('can unset extensions', function (): void {
        $object = Schema::create('test')
            ->addExtension(Extension::create('x-key', 'value'))
            ->addExtension(Extension::create('x-foo', 'bar'))
            ->addExtension(Extension::create('x-baz', null));

        $object = $object->removeExtension('x-key');

        expect($object->jsonSerialize())->toBe([
            'x-foo' => 'bar',
            'x-baz' => null,
        ]);
    });

    it('gets single extension', function (ExtensibleObject $extensibleObject): void {
        $extension = Extension::create('x-foo', 'bar');
        $object = $extensibleObject->addExtension($extension);

        expect($object)->getExtension('x-foo')->equals($extension)->toBeTrue();
    })->with('extensibleObjectSet');

    it('throws exception when extension dont exist', function (ExtensibleObject $extensibleObject): void {
        expect(function () use ($extensibleObject): void {
            $extensibleObject->getExtension('x-key');
        })->toThrow(InvalidArgumentException::class);
    })->with('extensibleObjectSet');

    it('gets all extensions', function (ExtensibleObject $extensibleObject): void {
        expect($extensibleObject->extensions())->toBeArray()
        ->each(function ($extension): void {
            expect($extension)->toBeInstanceOf(Extension::class);
        });

        $extension1 = Extension::create('x-key', 'value');
        $extension2 = Extension::create('x-foo', 'bar');
        $object = $extensibleObject
            ->addExtension($extension1)
            ->addExtension($extension2);

        expect($object->extensions())->toBe([$extension1, $extension2]);
    })->with('extensibleObjectSet');

    it('throws exception when extension does not exist', function (ExtensibleObject $extensibleObject): void {
        expect(function () use ($extensibleObject): void {
            $extensibleObject->getExtension('x-key');
        })->toThrow(InvalidArgumentException::class, 'Extension not found: x-key');
    })->with('extensibleObjectSet');
})->coversNothing();
