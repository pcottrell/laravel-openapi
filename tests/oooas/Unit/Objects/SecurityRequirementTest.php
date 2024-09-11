<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\OAuthFlow;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityRequirement;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\OpenApi;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(SecurityRequirement::class)]
class SecurityRequirementTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks()
    {
        $oauthFlow = OAuthFlow::create()
            ->flow(OAuthFlow::FLOW_CLIENT_CREDENTIALS)
            ->scopes(['read:user' => 'Access all user info']);

        $securityScheme = SecurityScheme::create('OAuth2')
            ->type(SecurityScheme::TYPE_OAUTH2)
            ->flows($oauthFlow);

        $securityRequirement = SecurityRequirement::create()
            ->securityScheme($securityScheme)
            ->scopes('read:user');

        $openApi = OpenApi::create()
            ->security($securityRequirement);

        $this->assertSame([
            'security' => [
                ['OAuth2' => ['read:user']],
            ],
        ], $openApi->toArray());
    }

    public function testCreateWithNoScopesWorks()
    {
        $securityScheme = SecurityScheme::create('OAuth2');

        $securityRequirement = SecurityRequirement::create()
            ->securityScheme($securityScheme);

        $openApi = OpenApi::create()
            ->security($securityRequirement);

        $this->assertSame([
            'security' => [
                ['OAuth2' => []],
            ],
        ], $openApi->toArray());
    }
}
