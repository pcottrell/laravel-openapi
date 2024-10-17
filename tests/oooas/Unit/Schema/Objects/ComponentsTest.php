<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableCallbackFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableParameterFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableRequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Callback;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Components;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Example;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Header;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Link;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OAuthFlow;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\RequestBody;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\Http;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

describe(class_basename(Components::class), function (): void {
    it('can be create with all parameters', function (): void {
        $schema = \Mockery::spy(ReusableSchemaFactory::class);
        $schema->allows('key')
            ->andReturn('ExampleSchema');
        $schema->expects('build')
            ->andReturn(Schema::object('ExampleSchema'));

        $response = \Mockery::spy(ReusableResponseFactory::class);
        $response->allows('key')
            ->andReturn('ReusableResponse');
        $response->expects('build')
            ->andReturn(Response::created());

        $parameter = \Mockery::spy(ReusableParameterFactory::class);
        $parameter->allows('key')
            ->andReturn('Page');
        $parameter->expects('build')
            ->andReturn(Parameter::query()->name('page'));

        $example = Example::create('Page')
            ->value(5);

        $requestBody = \Mockery::spy(ReusableRequestBodyFactory::class);
        $requestBody->allows('key')
            ->andReturn('CreateResource');
        $requestBody->expects('build')
            ->andReturn(RequestBody::create());

        $header = Header::create('HeaderExample');

        $oauthFlow = OAuthFlow::create()
            ->flow(OAuthFlow::FLOW_IMPLICIT)
            ->authorizationUrl('https://example.org/api/oauth/dialog');
        $securityScheme = \Mockery::spy(SecuritySchemeFactory::class);
        $securityScheme->allows('key')
            ->andReturn('basic');
        $securityScheme->expects('build')
            ->andReturn(
                Http::basic(),
            );

        $link = Link::create('LinkExample');

        $callback = \Mockery::spy(ReusableCallbackFactory::class);
        $callback->allows('key')
            ->andReturn('MyEvent');
        $callback->expects('build')
            ->andReturn(
                Callback::create(
                    'test',
                    '{$request.query.callbackUrl}',
                    PathItem::create()
                        ->operations(
                            Operation::post()->requestBody(
                                RequestBody::create()
                                    ->description('something happened'),
                            ),
                        ),
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
            ->callbacks($callback);

        expect($components->asArray())->toBe([
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
                'Page' => [
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
                'basic' => [
                    'type' => 'http',
                    'scheme' => 'basic',
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
        ]);
    });
})->covers(Components::class);
