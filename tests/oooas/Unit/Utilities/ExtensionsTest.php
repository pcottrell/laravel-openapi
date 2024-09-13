<?php

use MohammadAlavi\ObjectOrientedOAS\Utilities\Extensions;

describe('ExtensionsTest', function (): void {
    it('normalizes extension', function (string $key, string $expecNormalizedKey): void {
        $extensions = new Extensions();
        $extensions->offsetSet($key, 'value');

        expect($extensions->offsetGet($expecNormalizedKey))->toBe('value');
    })->with([
        ['testA', 'x-testA'],
        ['x-testB', 'x-testB'],
    ]);

    it('checks if extension exists', function (): void {
        $extensions = new Extensions();

        expect($extensions->offsetExists('test'))->toBeFalse();
    });

    it('checks if extension exists with x-', function (): void {
        $extensions = new Extensions();

        expect($extensions->offsetExists('x-test'))->toBeFalse();
    });

    it('gets extension', function (): void {
        $extensions = new Extensions();

        $extensions['test'] = 'test';

        expect($extensions->offsetGet('test'))->toBe('test');
    });

    it('gets extension with x-', function (): void {
        $extensions = new Extensions();

        $extensions['x-test'] = 'test';

        expect($extensions->offsetGet('x-test'))->toBe('test');
    });

    it('sets extension', function (): void {
        $extensions = new Extensions();

        $extensions['test'] = 'test';

        expect($extensions->offsetGet('test'))->toBe('test');
    });

    it('sets extension with x-', function (): void {
        $extensions = new Extensions();

        $extensions['x-test'] = 'test';

        expect($extensions->offsetGet('x-test'))->toBe('test');
    });

    it('throws exception if extension does not exist', function (): void {
        $extensions = new Extensions();

        expect(fn () => $extensions->offsetGet('test'))->toThrow(
            MohammadAlavi\ObjectOrientedOAS\Exceptions\ExtensionDoesNotExistException::class,
            '[test] is not a valid extension.',
        );
    });

    it('throws exception if extension does not exist with x-', function (): void {
        $extensions = new Extensions();

        expect(fn () => $extensions->offsetGet('x-test'))->toThrow(
            MohammadAlavi\ObjectOrientedOAS\Exceptions\ExtensionDoesNotExistException::class,
            '[x-test] is not a valid extension.',
        );
    });

    it('silently ignores non-existing offset when unsetting', function (): void {
        $extensions = new Extensions();

        expect(isset($extensions['nonexistent']))->toBeFalse();

        unset($extensions['nonexistent']);

        expect($extensions->offsetExists('test'))->toBeFalse();
    });

    it('can be converted to array', function (): void {
        $extensions = new Extensions();
        $extensions['test'] = 'test';

        expect($extensions->toArray())->toBe(['x-test' => 'test']);
    });

    it('can guess if a string is an extension', function (): void {
        expect(Extensions::isExtension('x-test'))->toBeTrue();
        expect(Extensions::isExtension('test'))->toBeFalse();
    });
})->covers(Extensions::class);
