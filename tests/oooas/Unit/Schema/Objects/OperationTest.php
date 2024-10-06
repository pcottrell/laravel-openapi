<?php

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\ExternalDocs;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Parameter;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityRequirement;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Server;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Tag;

describe('Operation', function (): void {
    it('can be created with no parameters', function (): void {
        $operation = Operation::create();

        expect($operation->jsonSerialize())->toBeEmpty();
    });

    it('can can be created with all parameters', function (string $actionMethod, string $operationName): void {
        $securityScheme = SecurityScheme::create()
            ->type(SecurityScheme::TYPE_OAUTH2);
        $pathItem = PathItem::create('MyEvent')
            ->path('{$request.query.callbackUrl}')
            ->operations(
                Operation::$actionMethod()->requestBody(
                    RequestBody::create()
                        ->description('something happened'),
                ),
            );
        $operation = Operation::create()
            ->action(Operation::ACTION_GET)
            ->tags(Tag::create()->name('Users'))
            ->summary('Lorem ipsum')
            ->description('Dolar sit amet')
            ->externalDocs(ExternalDocs::create())
            ->operationId('users.show')
            ->parameters(Parameter::create())
            ->requestBody(RequestBody::create())
            ->responses(Response::create())
            ->deprecated()
            ->security(SecurityRequirement::create()->securityScheme($securityScheme))
            ->servers(Server::create())
            ->callbacks($pathItem);

        expect($operation->jsonSerialize())->toBe([
            'tags' => ['Users'],
            'summary' => 'Lorem ipsum',
            'description' => 'Dolar sit amet',
            'externalDocs' => [],
            'operationId' => 'users.show',
            'parameters' => [[]],
            'requestBody' => [],
            'responses' => [
                'default' => [],
            ],
            'deprecated' => true,
            'security' => [
                ['OAuth2' => []],
            ],
            'servers' => [[]],
            'callbacks' => [
                'MyEvent' => [
                    '{$request.query.callbackUrl}' => [
                        $operationName => [
                            'requestBody' => [
                                'description' => 'something happened',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    })->with([
        'get action' => ['get', Operation::ACTION_GET],
        'put action' => ['put', Operation::ACTION_PUT],
        'post action' => ['post', Operation::ACTION_POST],
        'delete action' => ['delete', Operation::ACTION_DELETE],
        'options action' => ['options', Operation::ACTION_OPTIONS],
        'head action' => ['head', Operation::ACTION_HEAD],
        'patch action' => ['patch', Operation::ACTION_PATCH],
        'trace action' => ['trace', Operation::ACTION_TRACE],
    ]);

    it('can be created with now security', function (): void {
        $operation = Operation::get()
            ->noSecurity();

        expect($operation->jsonSerialize())->toBe([
            'security' => [],
        ]);
    });

    it('can accepts tags in multiple ways', function (array $tag, $expectation): void {
        $operation = Operation::get()
            ->tags(...$tag);

        expect($operation->jsonSerialize())->toBe([
            'tags' => $expectation,
        ]);
    })->with([
        'one string tag' => [['Users'], ['Users']],
        'multiple string tags' => [['Users', 'Admins'], ['Users', 'Admins']],
        'one object tag' => [[Tag::create()->name('Users')], ['Users']],
        'multiple object tags' => [[Tag::create()->name('Users'), Tag::create()->name('Admins')], ['Users', 'Admins']],
        'mixed tags' => [['Users', Tag::create()->name('Admins')], ['Users', 'Admins']],
    ]);
})->covers(Operation::class);
