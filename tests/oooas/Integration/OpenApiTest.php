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
    it('can generate valid OpenAPI v3.1.0 docs', function (SecurityScheme $securityScheme): void {
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
        $schema = Schema::object('Audits Response')
            ->properties(
                Schema::string('id')->format(Schema::FORMAT_UUID),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME),
                Schema::integer('age')->example(60),
                Schema::array('data')->items(
                    AllOf::create()->schemas(
                        Schema::string('id')->format(Schema::FORMAT_UUID),
                    ),
                ),
            )->required('id', 'created_at');
        $expectedResponse = Response::ok()
            ->content(MediaType::json()->schema($schema));
        $operationIndex = Operation::get()
            ->responses($expectedResponse)
            ->tags($tag)
            ->summary('List all audits')
            ->operationId('audits.index');
        $operationCreate = Operation::post()
            ->responses($expectedResponse)
            ->tags($tag)
            ->summary('Create an audit')
            ->operationId('audits.store')
            ->requestBody(RequestBody::create()->content(MediaType::json()->schema($schema)));
        $auditId = Schema::string('audit')->format(Schema::FORMAT_UUID);
        $format = Schema::string('format')
            ->enum('json', 'ics')
            ->default('json');
        $operationGet = Operation::get()
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
                ->operations($operationIndex, $operationCreate),
            PathItem::create()
                ->path('/audits/{audit}')
                ->operations($operationGet),
        ];
        $servers = [
            Server::create()->url('https://api.example.com/v1'),
            Server::create()->url('https://api.example.com/v2'),
        ];
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

        $data = $openApi->jsonSerialize();
        $result = file_put_contents('openapi.json', $openApi->toJson());
        // docker run --rm -v $PWD:/spec redocly/cli lint --extends recommend openapi.json
    })->with([
        function (): SecurityScheme {
            $oAuthFlow = OAuthFlow::create()
                ->flow(OAuthFlow::FLOW_IMPLICIT)
                ->authorizationUrl('https://api.example.com/oauth/authorize')
                ->refreshUrl('https://api.example.com/oauth/refresh')
                ->scopes([
                    'read:audits' => 'Read audits',
                    'write:audits' => 'Write audits',
                ]);

            return SecurityScheme::oauth2('OAuth2')
                ->flows($oAuthFlow);
        },
        function (): SecurityScheme {
            $oAuthFlow = OAuthFlow::create()
                ->flow(OAuthFlow::FLOW_PASSWORD)
                ->tokenUrl('https://api.example.com/oauth/authorize')
                ->refreshUrl('https://api.example.com/oauth/refresh')
                ->scopes([
                    'read:audits' => 'Read audits',
                    'write:audits' => 'Write audits',
                ]);

            return SecurityScheme::oauth2('OAuth2')
                ->flows($oAuthFlow);
        },
        function (): SecurityScheme {
            $oAuthFlow = OAuthFlow::create()
                ->flow(OAuthFlow::FLOW_CLIENT_CREDENTIALS)
                ->tokenUrl('https://api.example.com/oauth/authorize')
                ->refreshUrl('https://api.example.com/oauth/refresh')
                ->scopes(null);

            return SecurityScheme::oauth2('OAuth2')
                ->flows($oAuthFlow);
        },
        function (): SecurityScheme {
            $oAuthFlow = OAuthFlow::create()
                ->flow(OAuthFlow::FLOW_AUTHORIZATION_CODE)
                ->authorizationUrl('https://api.example.com/oauth/authorize')
                ->tokenUrl('https://api.example.com/oauth/token')
                ->refreshUrl('https://api.example.com/oauth/refresh');

            return SecurityScheme::oauth2('OAuth2')
                ->flows($oAuthFlow);
        },
        fn (): SecurityScheme => SecurityScheme::create('test_api_key')->type(SecurityScheme::TYPE_API_KEY),
        fn (): SecurityScheme => SecurityScheme::create('test_api_key')->type(SecurityScheme::TYPE_API_KEY)
            ->name('X-API-Key')
            ->in(SecurityScheme::IN_HEADER),
        fn (): SecurityScheme => SecurityScheme::create('test_api_key')->type(SecurityScheme::TYPE_API_KEY)
            ->name('in-query')
            ->in(SecurityScheme::IN_QUERY),
        fn (): SecurityScheme => SecurityScheme::create('test_api_key')->type(SecurityScheme::TYPE_API_KEY)
            ->name('in-cookie')
            ->in(SecurityScheme::IN_COOKIE),
        fn (): SecurityScheme => SecurityScheme::create('test_api_key')->type(SecurityScheme::TYPE_HTTP)
            ->scheme('Basic'),
        fn (): SecurityScheme => SecurityScheme::create('test_api_key')->type(SecurityScheme::TYPE_HTTP)
            ->scheme('Bearer')
            ->bearerFormat('JWT'),
        fn (): SecurityScheme => SecurityScheme::create('test_api_key')->type(SecurityScheme::TYPE_OPEN_ID_CONNECT)
            ->openIdConnectUrl('https://api.example.com/.well-known/openid-configuration'),
    ]);
})->coversNothing()->skip();
