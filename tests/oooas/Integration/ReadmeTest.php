<?php

namespace Tests\oooas\Integration;

use MohammadAlavi\ObjectOrientedOAS\Objects\AllOf;
use MohammadAlavi\ObjectOrientedOAS\Objects\Info;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\Operation;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;
use MohammadAlavi\ObjectOrientedOAS\OpenApi;
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
        $userSchema = Schema::object()
            ->properties(
                Schema::string('id')->format(Schema::FORMAT_UUID),
                Schema::string('name'),
                Schema::integer('age')->example(23),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME),
            );

        // Create the user response.
        $userResponse = Response::create()
            ->statusCode(200)
            ->description('OK')
            ->content(
                MediaType::json()->schema($userSchema),
            );

        // Create the operation for the route (i.e., GET, POST, etc.).
        $operation = Operation::get()
            ->responses($userResponse)
            ->tags($usersTag)
            ->summary('Get an individual user')
            ->operationId('users.show');

        // Define the /users path along with the supported operations.
        $pathItem = PathItem::create()
            ->route('/users')
            ->operations($operation);

        // Create the main OpenAPI object composed off everything created above.
        $openApi = OpenApi::create()
            ->openapi(OpenApi::OPENAPI_3_0_1)
            ->info($info)
            ->paths($pathItem)
            ->tags($usersTag);

        $readmeExample = file_get_contents(realpath(__DIR__ . '/../Stubs/readme_example.json'));

        $this->assertEquals(
            json_decode($readmeExample, true),
            $openApi->toArray(),
        );
    }

    public function testSettingAndUnsettingProperties(): void
    {
        $info = Info::create()
            ->title('Example API');

        $openApi = OpenApi::create()
            ->info($info);

        $this->assertSame([
            'info' => [
                'title' => 'Example API',
            ],
        ], $openApi->toArray());

        $openApi = $openApi->info(null);

        $this->assertSame([], $openApi->toArray());
    }

    public function testUnsettingVariadicMethods(): void
    {
        $pathItem = PathItem::create()
            ->route('/users');

        $openApi = OpenApi::create()
            ->paths($pathItem);

        $this->assertSame([
            'paths' => [
                '/users' => [],
            ],
        ], $openApi->toArray());

        $openApi = $openApi->paths();

        $this->assertSame([], $openApi->toArray());
    }

    public function testRetrievingProperties(): void
    {
        $info = Info::create()->title('Example API');

        $this->assertSame('Example API', $info->title);
    }

    public function testObjectId(): void
    {
        $schema = Schema::create()
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
        ], $schema->toArray());
    }

    public function testSimplerObjectId(): void
    {
        $schema = Schema::object()
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
        ], $schema->toArray());
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
        ], $allOf->toArray());
    }
}
