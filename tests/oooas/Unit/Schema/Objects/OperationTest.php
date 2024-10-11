<?php

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Callback;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\RequestBody;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityRequirementOld;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Tag;

describe('Operation', function (): void {
    it('can be created with no parameters', function (): void {
        $operation = Operation::create();

        expect($operation->jsonSerialize())->toBeEmpty();
    });

    it('can can be created with all parameters', function (string $actionMethod, string $operationName): void {
        $securityScheme = SecurityScheme::create('OAuth2')
            ->type(SecurityScheme::TYPE_OAUTH2);
        $callback =
            Callback::create(
                'MyEvent',
                '{$request.query.callbackUrl}',
                PathItem::create()
                    ->operations(
                        Operation::$actionMethod()->requestBody(
                            RequestBody::create()
                                ->description('something happened'),
                        ),
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
            ->responses(Response::default())
            ->deprecated()
            ->security(SecurityRequirementOld::create()->securityScheme($securityScheme))
            ->servers(Server::create())
            ->callbacks($callback);

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
    })->skip('update the implementation to support no security');

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
