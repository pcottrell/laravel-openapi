<?php

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityRequirementOld;
use Tests\Doubles\Stubs\SecuritySchemes\ApiKeySecuritySchemeFactory;
use Tests\Doubles\Stubs\SecuritySchemes\BearerSecuritySchemeFactory;
use Tests\Doubles\Stubs\SecuritySchemes\JwtSecuritySchemeFactory;

describe('SecurityRequirement', function (): void {
    it('can set nested security schemes', function (): void {
        $securityRequirement = SecurityRequirementOld::create()
            ->nestedSecurityScheme(
                [
                    [
                        (new BearerSecuritySchemeFactory())->build(),
                        (new ApiKeySecuritySchemeFactory())->build(),
                    ],
                    (new JwtSecuritySchemeFactory())->build(),
                ],
            );

        expect($securityRequirement->jsonSerialize())->toBe([
            [
                'Bearer' => [],
                'ApiKey' => [],
            ],
            [
                'JWT' => [],
            ],
        ]);
    });
})->covers(SecurityRequirementOld::class)->skip();
