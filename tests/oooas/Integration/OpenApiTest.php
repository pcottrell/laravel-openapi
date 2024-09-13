<?php

use JsonSchema\Constraints\BaseConstraint;
use JsonSchema\Validator;
use MohammadAlavi\ObjectOrientedOAS\Objects\AllOf;
use MohammadAlavi\ObjectOrientedOAS\Objects\Components;
use MohammadAlavi\ObjectOrientedOAS\Objects\Contact;
use MohammadAlavi\ObjectOrientedOAS\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOAS\Objects\Info;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\OAuthFlow;
use MohammadAlavi\ObjectOrientedOAS\Objects\Operation;
use MohammadAlavi\ObjectOrientedOAS\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityRequirement;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;
use MohammadAlavi\ObjectOrientedOAS\OpenApi;

describe('OpenApi', function (): void {
    it('can generate valid OpenAPI v3.0.x docs', function (): void {
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
                Schema::string('id')->format(Schema::FORMAT_UUID),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME),
                Schema::integer('age')->example(60),
                Schema::array('data')->items(
                    AllOf::create()->schemas(
                        Schema::string('id')->format(Schema::FORMAT_UUID),
                    ),
                ),
            )
            ->required('id', 'created_at');

        $expectedResponse = Response::create()
            ->statusCode(200)
            ->description('OK')
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

        $auditId = Schema::string('audit')
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
                ->route('/audits')
                ->operations($operation, $createAudit),
            PathItem::create()
                ->route('/audits/{audit}')
                ->operations($readAudit),
        ];

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

        $securityRequirement = SecurityRequirement::create()->securityScheme($securityScheme);

        $externalDocs = ExternalDocs::create()
            ->url('https://example.com')
            ->description('Example');

        $openApi = OpenApi::create()
            ->openapi(OpenApi::OPENAPI_3_0_1)
            ->info($info)
            ->paths(...$paths)
            ->servers(...$servers)
            ->components($components)
            ->security($securityRequirement)
            ->tags($tag)
            ->externalDocs($externalDocs);

        $expectedResponse = file_get_contents(realpath(__DIR__ . '/../Stubs/v3.0.x_expected_response.json'));

        $data = $openApi->toArray();
        expect($data)->toBe(json_decode($expectedResponse, true, 512, JSON_THROW_ON_ERROR));
        expect(isValid(realpath(__DIR__ . '/../Stubs/Schemas/v3.0.x.json'), $data))->toBeTrue();
    })->with([
        'v3.0.0' => [OpenApi::OPENAPI_3_0_0],
        'v3.0.1' => [OpenApi::OPENAPI_3_0_1],
        'v3.0.2' => [OpenApi::OPENAPI_3_0_2],
        'v3.0.3' => [OpenApi::OPENAPI_3_0_3],
    ]);

    it('can generate valid OpenAPI v3.1.0 docs', function (): void {
    })->todo();

    function isValid(string $schemaPath, array $data): bool
    {
        $schema = file_get_contents($schemaPath);
        $schema = json_decode($schema, false, 512, JSON_THROW_ON_ERROR);

        $data = BaseConstraint::arrayToObjectRecursive($data);
        $validator = new Validator();
        $validator->validate($data, $schema);

        return $validator->isValid();
    }
})->coversNothing();
