<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOAS\OpenApi;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(ExternalDocs::class)]
class ExternalDocsTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks()
    {
        $externalDocs = ExternalDocs::create()
            ->description('GitHub Repo')
            ->url('https://github.com/goldspecdigital/oooas');

        $openApi = OpenApi::create()
            ->externalDocs($externalDocs);

        $this->assertEquals([
            'externalDocs' => [
                'description' => 'GitHub Repo',
                'url' => 'https://github.com/goldspecdigital/oooas',
            ],
        ], $openApi->toArray());
    }
}
