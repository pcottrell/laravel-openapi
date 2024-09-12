<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

describe('Tag', function (): void {
    it('can be created with no parameters', function (): void {
        $tag = Tag::create();

        expect($tag->toArray())->toBeEmpty();
    });

    it('can be created with all parameters', function (): void {
        $tag = Tag::create()
            ->name('Users')
            ->description('All user endpoints')
            ->externalDocs(ExternalDocs::create());

        expect($tag->toArray())->toEqual([
            'name' => 'Users',
            'description' => 'All user endpoints',
            'externalDocs' => [],
        ]);
    });

    it('can be cast to string', function (): void {
        $tag = Tag::create()
            ->name('Users');

        expect((string) $tag)->toBe('Users');
    });
})->covers(Tag::class);
