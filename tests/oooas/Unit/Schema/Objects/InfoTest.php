<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Contact;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Info;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\License;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OpenApi;
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
