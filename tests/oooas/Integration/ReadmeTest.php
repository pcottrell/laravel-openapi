<?php

namespace Tests\oooas\Integration;

use Illuminate\Support\Facades\File;
use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\AllOf;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Info;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Responses;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Tag;
use PHPUnit\Framework\Attributes\CoversNothing;
use Tests\IntegrationTestCase;

#[CoversNothing]
class ReadmeTest extends IntegrationTestCase
{
    public function testTheReadmeExample(): void
    {
        // Create a tag for all the user endpoints.
        $usersTag = Tag::create()
            ->name('Users')
            ->description('All user related endpoints');

        // Create the info section.
        $info = Info::create()
            ->title('API Specification')
            ->version('v1')
            ->description('For using the Example App API');

        // Create the user schema.
        $userSchema = Schema::object('user')
            ->properties(
                Schema::string('id')->format(Schema::FORMAT_UUID),
                Schema::string('name'),
                Schema::integer('age')->example(23),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME),
            );

        // Create the user response.
        $userResponse = Response::ok()
            ->content(
                MediaType::json()->schema($userSchema),
            );

        // Create the operation for the route (i.e., GET, POST, etc.).
        $operation = Operation::get()
            ->responses(Responses::create($userResponse))
            ->tags($usersTag)
            ->summary('Get an individual user')
            ->operationId('users.show');

        // Define the /users path along with the supported operations.
        $path = Path::create(
            '/users',
            PathItem::create()
                ->operations($operation),
        );

        // Create the main OpenAPI object composed off everything created above.
        $openApi = OpenApi::create()
            ->openapi(OASVersion::V_3_1_0)
            ->info($info)
            ->paths(Paths::create($path))
            ->tags($usersTag);

        $readmeExample = File::json(realpath(__DIR__ . '/../Doubles/Stubs/readme_example.json'));

        $this->assertEquals(
            $readmeExample,
            $openApi->jsonSerialize(),
        );
    }

    public function testSettingAndUnsettingProperties(): void
    {
        $info = Info::create()
            ->title('Example API');

        $openApi = OpenApi::create()
            ->info($info);

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
            'info' => [
                'title' => 'Example API',
            ],
        ], $openApi->jsonSerialize());

        $openApi = $openApi->info(null);

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
        ], $openApi->jsonSerialize());
    }

    public function testUnsettingVariadicMethods(): void
    {
        $path = Path::create(
            '/users',
            PathItem::create(),
        );

        $openApi = OpenApi::create()
            ->paths(Paths::create($path));

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
            'paths' => [
                '/users' => [],
            ],
        ], $openApi->jsonSerialize());

        $openApi = $openApi->paths(null);

        $this->assertSame([
            'openapi' => OASVersion::V_3_1_0->value,
        ], $openApi->jsonSerialize());
    }

    public function testRetrievingProperties(): void
    {
        $info = Info::create()->title('Example API');

        $this->assertSame('Example API', $info->title);
    }

    public function testObjectId(): void
    {
        $schema = Schema::create('test')
            ->type(Schema::TYPE_OBJECT)
            ->properties(
                Schema::create('username')->type(Schema::TYPE_STRING),
                Schema::create('age')->type(Schema::TYPE_INTEGER),
            );

        $this->assertSame([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                ],
                'age' => [
                    'type' => 'integer',
                ],
            ],
        ], $schema->jsonSerialize());
    }

    public function testSimplerObjectId(): void
    {
        $schema = Schema::object('test')
            ->properties(
                Schema::string('username'),
                Schema::integer('age'),
            );

        $this->assertSame([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                ],
                'age' => [
                    'type' => 'integer',
                ],
            ],
        ], $schema->jsonSerialize());
    }

    public function testDollarRef(): void
    {
        $allOf = AllOf::create()
            ->schemas(
                Schema::ref('#/components/schemas/ExampleSchema'),
            );

        $this->assertSame([
            'allOf' => [
                ['$ref' => '#/components/schemas/ExampleSchema'],
            ],
        ], $allOf->jsonSerialize());
    }
}
