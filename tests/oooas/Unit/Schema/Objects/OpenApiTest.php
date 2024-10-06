<?php

use MohammadAlavi\LaravelOpenApi\oooas\Enums\OASVersion;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\AllOf;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Components;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Contact;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\ExternalDocs;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Info;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\MediaType;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OAuthFlow;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Parameter;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\RequestBody;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityRequirement;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Server;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Tag;

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

        $schema = Schema::object()
            ->properties(
                Schema::string()->format(Schema::FORMAT_UUID),
                Schema::string()->format(Schema::FORMAT_DATE_TIME),
                Schema::integer()->example(60),
                Schema::array()->items(
                    AllOf::create()->schemas(
                        Schema::string()->format(Schema::FORMAT_UUID),
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

        $auditId = Schema::string()
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
                Parameter::path()
                    ->name('audit')
                    ->schema($auditId)
                    ->required(),
                Parameter::query()
                    ->name('format')
                    ->schema($format)
                    ->description('The format of the appointments'),
            );

        $paths = [
            PathItem::create()
                ->path('/audits')
                ->operations($operation, $createAudit),
            PathItem::create()
                ->path('/audits/{audit}')
                ->operations($readAudit),
        ];

        $servers = [
            Server::create()->url('https://api.example.com/v1'),
            Server::create()->url('https://api.example.com/v2'),
        ];

        $oAuthFlow = OAuthFlow::create()
            ->flow(OAuthFlow::FLOW_PASSWORD)
            ->tokenUrl('https://api.example.com/oauth/authorize');

        $securityScheme = SecurityScheme::oauth2()
            ->flows($oAuthFlow);

        $components = Components::create()->securitySchemes($securityScheme);

        $securityRequirement = SecurityRequirement::create()->securityScheme($securityScheme);

        $externalDocs = ExternalDocs::create()
            ->url('https://example.com')
            ->description('Example');

        $openApi = OpenApi::create()
            ->openapi(OASVersion::V_3_1_0)
            ->info($info)
            ->paths(...$paths)
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
