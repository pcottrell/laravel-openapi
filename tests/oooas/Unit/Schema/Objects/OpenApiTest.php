<?php

use MohammadAlavi\LaravelOpenApi\Collections\ParameterCollection;
use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\AllOf;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Components;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Contact;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Info;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OAuthFlow;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\RequestBody;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityRequirementOld;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Tag;

describe('OpenApi', function (): void {
    it('can be created and validated', function (): void {
        $tag = Tag::create()
            ->name('Audits')
            ->description('All the audits');

        $contact = Contact::create()
            ->name('Example')
            ->url('https://example.com')
            ->email('hello@example.com');

        $info = Info::create()
            ->title('API Specification')
            ->version('v1')
            ->description('For using the Example App API')
            ->contact($contact);

        // TODO: Allow creating a Schema without a key.
        // Some schemas can be created without a key.
        //  We can call them anonymous Schemas.
        //  For example a Schema for a Response doesnt need a key.
        //  This is not possible right now.
        //  åBecause creating an Schema in anyway requires a "key".
        //  I think we should proved this functionality but I don't know how yet!
        //  Maybe we can create an AnonymousSchema class that extends Schema and doesn't require a key?
        //  Find a better name for it!
        //  Maybe Schema::anonymous()?
        // Another idea would be to create a BaseSchema class without the create method.
        //  Then create 2 Contracts, one for UnnamedSchema and another for NamedSchema.
        //  These contracts define the create method and either accept the key or not.
        // Then we accept the proper Contract when needed!
        // For example here for response we can accept the UnnamedSchema contract!
        $schema = Schema::object('response')
            ->properties(
                Schema::string('id')->format(Schema::FORMAT_UUID),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME),
                Schema::integer('age')->example(60),
                Schema::array('date')->items(
                    AllOf::create()->schemas(
                        Schema::string('id')->format(Schema::FORMAT_UUID),
                    ),
                ),
            )
            ->required('id', 'created_at');

        $expectedResponse = Response::ok()
            ->content(
                MediaType::json()->schema($schema),
            );

        $operation = Operation::get()
            ->responses($expectedResponse)
            ->tags($tag)
            ->summary('List all audits')
            ->operationId('audits.index');

        $createAudit = Operation::post()
            ->responses($expectedResponse)
            ->tags($tag)
            ->summary('Create an audit')
            ->operationId('audits.store')
            ->requestBody(RequestBody::create()->content(
                MediaType::json()->schema($schema),
            ));

        $auditId = Schema::string('id')
            ->format(Schema::FORMAT_UUID);
        $format = Schema::string('format')
            ->enum('json', 'ics')
            ->default('json');

        $readAudit = Operation::get()
            ->responses($expectedResponse)
            ->tags($tag)
            ->summary('View an audit')
            ->operationId('audits.show')
            ->parameters(
                ParameterCollection::create(
                    Parameter::path()
                        ->name('audit')
                        ->schema($auditId)
                        ->required(),
                    Parameter::query()
                        ->name('format')
                        ->schema($format)
                        ->description('The format of the appointments'),
                ),
            );

        $paths = Paths::create(
            Path::create(
                '/audits',
                PathItem::create()
                    ->operations($operation, $createAudit),
            ),
            Path::create(
                '/audits/{audit}',
                PathItem::create()
                    ->operations($readAudit),
            ),
        );

        $servers = [
            Server::create()->url('https://api.example.com/v1'),
            Server::create()->url('https://api.example.com/v2'),
        ];

        $oAuthFlow = OAuthFlow::create()
            ->flow(OAuthFlow::FLOW_PASSWORD)
            ->tokenUrl('https://api.example.com/oauth/authorize');

        $securityScheme = SecurityScheme::oauth2('OAuth2')
            ->flows($oAuthFlow);

        $components = Components::create()->securitySchemes($securityScheme);

        $securityRequirement = SecurityRequirementOld::create()->securityScheme($securityScheme);

        $externalDocs = ExternalDocs::create()
            ->url('https://example.com')
            ->description('Example');

        $openApi = OpenApi::create()
            ->openapi(OASVersion::V_3_1_0)
            ->info($info)
            ->paths($paths)
            ->servers(...$servers)
            ->components($components)
            ->security($securityRequirement)
            ->tags($tag)
            ->externalDocs($externalDocs);

        expect($openApi->jsonSerialize())->toBe([
            'openapi' => OASVersion::V_3_1_0->value,
            'info' => [
                'title' => 'API Specification',
                'description' => 'For using the Example App API',
                'contact' => [
                    'name' => 'Example',
                    'url' => 'https://example.com',
                    'email' => 'hello@example.com',
                ],
                'version' => 'v1',
            ],
            'servers' => [
                ['url' => 'https://api.example.com/v1'],
                ['url' => 'https://api.example.com/v2'],
            ],
            'paths' => [
                '/audits' => [
                    'get' => [
                        'tags' => ['Audits'],
                        'summary' => 'List all audits',
                        'operationId' => 'audits.index',
                        'responses' => [
                            200 => [
                                'description' => 'OK',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'required' => ['id', 'created_at'],
                                            'properties' => [
                                                'id' => [
                                                    'format' => 'uuid',
                                                    'type' => 'string',
                                                ],
                                                'created_at' => [
                                                    'format' => 'date-time',
                                                    'type' => 'string',
                                                ],
                                                'age' => [
                                                    'type' => 'integer',
                                                    'example' => 60,
                                                ],
                                                'data' => [
                                                    'type' => 'array',
                                                    'items' => [
                                                        'allOf' => [
                                                            ['format' => 'uuid', 'type' => 'string'],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'post' => [
                        'tags' => ['Audits'],
                        'summary' => 'Create an audit',
                        'operationId' => 'audits.store',
                        'requestBody' => [
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['id', 'created_at'],
                                        'properties' => [
                                            'id' => [
                                                'format' => 'uuid',
                                                'type' => 'string',
                                            ],
                                            'created_at' => [
                                                'format' => 'date-time',
                                                'type' => 'string',
                                            ],
                                            'age' => [
                                                'type' => 'integer',
                                                'example' => 60,
                                            ],
                                            'data' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'allOf' => [
                                                        ['format' => 'uuid', 'type' => 'string'],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            200 => [
                                'description' => 'OK',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'required' => ['id', 'created_at'],
                                            'properties' => [
                                                'id' => [
                                                    'format' => 'uuid',
                                                    'type' => 'string',
                                                ],
                                                'created_at' => [
                                                    'format' => 'date-time',
                                                    'type' => 'string',
                                                ],
                                                'age' => [
                                                    'type' => 'integer',
                                                    'example' => 60,
                                                ],
                                                'data' => [
                                                    'type' => 'array',
                                                    'items' => [
                                                        'allOf' => [
                                                            ['format' => 'uuid', 'type' => 'string'],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/audits/{audit}' => [
                    'get' => [
                        'tags' => ['Audits'],
                        'summary' => 'View an audit',
                        'operationId' => 'audits.show',
                        'parameters' => [
                            [
                                'name' => 'audit',
                                'in' => 'path',
                                'required' => true,
                                'schema' => [
                                    'format' => 'uuid',
                                    'type' => 'string',
                                ],
                            ],
                            [
                                'name' => 'format',
                                'in' => 'query',
                                'description' => 'The format of the appointments',
                                'schema' => [
                                    'enum' => ['json', 'ics'],
                                    'default' => 'json',
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'responses' => [
                            200 => [
                                'description' => 'OK',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'required' => ['id', 'created_at'],
                                            'properties' => [
                                                'id' => [
                                                    'format' => 'uuid',
                                                    'type' => 'string',
                                                ],
                                                'created_at' => [
                                                    'format' => 'date-time',
                                                    'type' => 'string',
                                                ],
                                                'age' => [
                                                    'type' => 'integer',
                                                    'example' => 60,
                                                ],
                                                'data' => [
                                                    'type' => 'array',
                                                    'items' => [
                                                        'allOf' => [
                                                            ['format' => 'uuid', 'type' => 'string'],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'components' => [
                'securitySchemes' => [
                    'OAuth2' => [
                        'type' => 'oauth2',
                        'flows' => [
                            'password' => [
                                'tokenUrl' => 'https://api.example.com/oauth/authorize',
                            ],
                        ],
                    ],
                ],
            ],
            'security' => [
                ['OAuth2' => []],
            ],
            'tags' => [
                ['name' => 'Audits', 'description' => 'All the audits'],
            ],
            'externalDocs' => [
                'description' => 'Example',
                'url' => 'https://example.com',
            ],
        ]);
    });
})->covers(OpenApi::class);
