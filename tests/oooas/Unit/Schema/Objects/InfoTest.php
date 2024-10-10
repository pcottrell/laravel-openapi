<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Contact;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Info;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\License;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Info::class)]
class InfoTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $info = Info::create()
            ->title('Pretend API')
            ->description('A pretend API')
            ->termsOfService('https://example.com')
            ->contact(Contact::create())
            ->license(License::create())
            ->version('v1');

        $openApi = OpenApi::create()
            ->info($info);

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
            'info' => [
                'title' => 'Pretend API',
                'description' => 'A pretend API',
                'termsOfService' => 'https://example.com',
                'contact' => [],
                'license' => [],
                'version' => 'v1',
            ],
        ], $openApi->jsonSerialize());
    }
}
