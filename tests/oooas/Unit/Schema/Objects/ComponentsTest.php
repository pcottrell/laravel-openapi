<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Components;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Example;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Header;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Link;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OAuthFlow;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Parameter;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Doubles\Stubs\Collectors\Paths\Operations\TestReusableResponse;
use Tests\UnitTestCase;

#[CoversClass(Components::class)]
class ComponentsTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $schema = Schema::object('ExampleSchema');

        $response = new TestReusableResponse();

        $parameter = Parameter::query()
            ->name('page');

        $example = Example::create('Page')
            ->value(5);

        $requestBody = RequestBody::create();

        $header = Header::create('HeaderExample');

        $oauthFlow = OAuthFlow::create()
            ->flow(OAuthFlow::FLOW_IMPLICIT)
            ->authorizationUrl('https://example.org/api/oauth/dialog');

        $securityScheme = SecurityScheme::create('OAuth2')
            ->type(SecurityScheme::TYPE_OAUTH2)
            ->flows($oauthFlow);

        $link = Link::create('LinkExample');

        $pathItem = PathItem::create()
            ->path('{$request.query.callbackUrl}')
            ->operations(
                Operation::post()->requestBody(
                    RequestBody::create()
                        ->description('something happened'),
                ),
            );

        $components = Components::create()
            ->schemas($schema)
            ->responses($response)
            ->parameters($parameter)
            ->examples($example)
            ->requestBodies($requestBody)
            ->headers($header)
            ->securitySchemes($securityScheme)
            ->links($link)
            ->callbacks($pathItem);

        $this->assertSame([
            'schemas' => [
                'ExampleSchema' => [
                    'type' => 'object',
                ],
            ],
            'responses' => [
                'ReusableResponse' => [
                    'description' => 'Created',
                ],
            ],
            'parameters' => [
                'Page' => [
                    'name' => 'page',
                    'in' => 'query',
                ],
            ],
            'examples' => [
                'PageExample' => [
                    'value' => 5,
                ],
            ],
            'requestBodies' => [
                'CreateResource' => [],
            ],
            'headers' => [
                'HeaderExample' => [],
            ],
            'securitySchemes' => [
                'OAuth2' => [
                    'type' => 'oauth2',
                    'flows' => [
                        'implicit' => [
                            'authorizationUrl' => 'https://example.org/api/oauth/dialog',
                        ],
                    ],
                ],
            ],
            'links' => [
                'LinkExample' => [],
            ],
            'callbacks' => [
                'MyEvent' => [
                    '{$request.query.callbackUrl}' => [
                        'post' => [
                            'requestBody' => [
                                'description' => 'something happened',
                            ],
                        ],
                    ],
                ],
            ],
        ], $components->jsonSerialize());
    }
}
