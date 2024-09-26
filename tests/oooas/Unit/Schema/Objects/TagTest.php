<?php

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\ExternalDocs;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Tag;

describe('Tag', function (): void {
    it('can be created with no parameters', function (): void {
        $tag = Tag::create();

        expect($tag->serialize())->toBeEmpty();
    });

    it('can be created with all parameters', function (): void {
        $tag = Tag::create()
            ->name('Users')
            ->description('All user endpoints')
            ->externalDocs(ExternalDocs::create());

        expect($tag->serialize())->toBe([
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
