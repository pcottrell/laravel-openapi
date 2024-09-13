<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOAS\OpenApi;
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
            'externalDocs' => [
                'description' => 'GitHub Repo',
                'url' => 'https://example.com',
            ],
        ], $openApi->toArray());
    }
}
