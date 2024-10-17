<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;

describe(class_basename(ExternalDocs::class), function (): void {
    it('can be created with all parameters', function (): void {
        $externalDocs = ExternalDocs::create()
            ->description('GitHub Repo')
            ->url('https://example.com');

        expect($externalDocs->asArray())->toBe([
            'description' => 'GitHub Repo',
            'url' => 'https://example.com',
        ]);
    });
})->covers(ExternalDocs::class);
