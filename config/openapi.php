<?php

use Tests\Doubles\Fakes\Petstore\Security\ExampleSingleSecurityRequirementSecurity;

return [
    'collections' => [
        'default' => [
            // TODO: change this to use an InfoFactory class.
            'info' => [
                'title' => config('app.name'),
                'description' => null,
                'version' => '1.0.0',
                'contact' => [],
            ],

            'servers' => [
                // Servers should extend `MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ServerFactory` class.
                // ExampleServer::class
            ],

            'tags' => [
                // Tags should extend `MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\TagFactory` class.
                // ExampleTag::class,
            ],

            // TODO: add an example for security.
            'security' => null,

            // Non-standard attributes used by code/doc generation tools can be added here
            'extensions' => [
                // 'x-tagGroups' => [
                //     [
                //         'name' => 'General',
                //         'tags' => [
                //             'user',
                //         ],
                //     ],
                // ],
            ],

            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => '/openapi',
                'middleware' => [],
            ],

            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [
                ],
                'components' => [
                ],
            ],
        ],
    ],

    // Directories to use for locating OpenAPI object definitions.
    'locations' => [
        'callbacks' => [
            app_path('OpenApi/Callbacks'),
        ],

        'request_bodies' => [
            app_path('OpenApi/RequestBodies'),
        ],

        'responses' => [
            app_path('OpenApi/Responses'),
        ],

        'schemas' => [
            app_path('OpenApi/Schemas'),
        ],

        'security_schemes' => [
            app_path('OpenApi/SecuritySchemes'),
        ],
    ],
];
