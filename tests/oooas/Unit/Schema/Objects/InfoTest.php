<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Contact;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Info;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\License;

describe(class_basename(Info::class), function (): void {
    it('should set all parameters', function (): void {
        $info = Info::create()
            ->title('Pretend API')
            ->description('A pretend API')
            ->termsOfService('https://example.com')
            ->contact(Contact::create())
            ->license(License::create())
            ->version('v1');

        expect($info->asArray())->toBe([
            'title' => 'Pretend API',
            'description' => 'A pretend API',
            'termsOfService' => 'https://example.com',
            'contact' => [],
            'license' => [],
            'version' => 'v1',
        ]);
    });
})->covers(Info::class);
