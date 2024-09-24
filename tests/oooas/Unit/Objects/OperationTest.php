<?php

use MohammadAlavi\LaravelOpenApi\oooas\Objects\SecurityRequirement;
use MohammadAlavi\ObjectOrientedOAS\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOAS\Objects\Operation;
use MohammadAlavi\ObjectOrientedOAS\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

describe('Operation', function (): void {
    it('can be created with no parameters', function (): void {
        $operation = Operation::create();

        expect($operation->toArray())->toBeEmpty();
    });

    it('can can be created with all parameters', function (string $actionMethod, string $operationName): void {
        $securityScheme = SecurityScheme::create('OAuth2')
            ->type(SecurityScheme::TYPE_OAUTH2);
        $callback = PathItem::create('MyEvent')
            ->route('{$request.query.callbackUrl}')
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
            ->callbacks($callback);

        expect($operation->toArray())->toBe([
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

        expect($operation->toArray())->toBe([
            'security' => [],
        ]);
    });

    it('can accepts tags in multiple ways', function (array $tag, $expectation): void {
        $operation = Operation::get()
            ->tags(...$tag);

        expect($operation->toArray())->toBe([
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
