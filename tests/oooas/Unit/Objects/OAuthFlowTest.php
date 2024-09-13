<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\OAuthFlow;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(OAuthFlow::class)]
class OAuthFlowTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $oauthFlow = OAuthFlow::create()
            ->flow(OAuthFlow::FLOW_AUTHORIZATION_CODE)
            ->authorizationUrl('https://api.example.com/oauth/authorization')
            ->tokenUrl('https://api.example.com/oauth/token')
            ->refreshUrl('https://api.example.com/oauth/token')
            ->scopes(['read:user' => 'Read the user profile']);

        $securityScheme = SecurityScheme::create()
            ->flows($oauthFlow);

        $this->assertSame([
            'flows' => [
                'authorizationCode' => [
                    'authorizationUrl' => 'https://api.example.com/oauth/authorization',
                    'tokenUrl' => 'https://api.example.com/oauth/token',
                    'refreshUrl' => 'https://api.example.com/oauth/token',
                    'scopes' => [
                        'read:user' => 'Read the user profile',
                    ],
                ],
            ],
        ], $securityScheme->toArray());
    }
}
