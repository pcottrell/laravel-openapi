<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(ExternalDocs::class)]
class ExternalDocsTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $externalDocs = ExternalDocs::create()
            ->description('GitHub Repo')
            ->url('https://example.com');

        $openApi = OpenApi::create()
            ->externalDocs($externalDocs);

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
            'externalDocs' => [
                'description' => 'GitHub Repo',
                'url' => 'https://example.com',
            ],
        ], $openApi->jsonSerialize());
    }
}
