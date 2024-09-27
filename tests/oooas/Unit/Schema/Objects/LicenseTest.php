<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Info;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\License;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(License::class)]
class LicenseTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $license = License::create()
            ->name('MIT')
            ->url('https://example.com');

        $info = Info::create()
            ->license($license);

        $this->assertSame([
            'license' => [
                'name' => 'MIT',
                'url' => 'https://example.com',
            ],
        ], $info->jsonSerialize());
    }
}
