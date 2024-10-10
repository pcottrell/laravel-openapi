<?php

namespace Tests\oooas\Integration;

use Illuminate\Support\Facades\File;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\AllOf;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Components;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Contact;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Info;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\License;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\RequestBody;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;
use PHPUnit\Framework\Attributes\CoversNothing;
use Tests\IntegrationTestCase;
use Tests\oooas\Doubles\Stubs\ReusableSchemaStub;

#[CoversNothing]
class PetStoreTest extends IntegrationTestCase
{
    public function testPetStoreExample(): void
    {
        $contact = Contact::create()
            ->name('Swagger API Team')
            ->email('apiteam@swagger.io')
            ->url('https://swagger.io');

        $license = License::create()
            ->name('Apache 2.0')
            ->url('https://www.apache.org/licenses/LICENSE-2.0.html');

        $server = Server::create()
            ->url('https://petstore.swagger.io/api');

        $info = Info::create()
            ->version('1.0.0')
            ->title('Swagger Petstore')
            ->description('A sample API that uses a petstore as an example to demonstrate features in the OpenAPI 3.0 specification')
            ->termsOfService('https://swagger.io/terms/')
            ->contact($contact)
            ->license($license);

        $tagsParameter = Parameter::query()
            ->name('tags')
            ->description('tags to filter by')
            ->required(false)
            ->style(Parameter::STYLE_FORM)
            ->schema(
                Schema::array('test')->items(
                    Schema::string('value'),
                ),
            );

        $limitParameter = Parameter::query()
            ->name('limit')
            ->description('maximum number of results to return')
            ->required(false)
            ->schema(
                Schema::integer('value')->format(Schema::FORMAT_INT32),
            );

        $allOf = AllOf::create()
            ->schemas(
                ReusableSchemaStub::create(),
                Schema::create('Pet')
                    ->required('id')
                    ->properties(
                        Schema::integer('id')->format(Schema::FORMAT_INT64),
                    ),
            );

        $newPetSchema = Schema::create('NewPet')
            ->required('name')
            ->properties(
                Schema::string('name'),
                Schema::string('tag'),
            );

        $errorSchema = Schema::create('Error')
            ->required('code', 'message')
            ->properties(
                Schema::integer('code')->format(Schema::FORMAT_INT32),
                Schema::string('message'),
            );

        $components = Components::create()
            ->schemas($allOf, $newPetSchema, $errorSchema);

        $petResponse = Response::ok('pet response')
            ->content(
                MediaType::json()->schema(
                    Schema::ref('#/components/schemas/Pet'),
                ),
            );

        $petListingResponse = Response::ok('pet response')
            ->content(
                MediaType::json()->schema(
                    Schema::array('array_test')->items(
                        Schema::ref('#/components/schemas/Pet'),
                    ),
                ),
            );

        $defaultErrorResponse = Response::internalServerError('unexpected error')
            ->content(MediaType::json()->schema(
                Schema::ref('#/components/schemas/Error'),
            ));

        $operation = Operation::get()
            ->description("Returns all pets from the system that the user has access to\nNam sed condimentum est. Maecenas tempor sagittis sapien, nec rhoncus sem sagittis sit amet. Aenean at gravida augue, ac iaculis sem. Curabitur odio lorem, ornare eget elementum nec, cursus id lectus. Duis mi turpis, pulvinar ac eros ac, tincidunt varius justo. In hac habitasse platea dictumst. Integer at adipiscing ante, a sagittis ligula. Aenean pharetra tempor ante molestie imperdiet. Vivamus id aliquam diam. Cras quis velit non tortor eleifend sagittis. Praesent at enim pharetra urna volutpat venenatis eget eget mauris. In eleifend fermentum facilisis. Praesent enim enim, gravida ac sodales sed, placerat id erat. Suspendisse lacus dolor, consectetur non augue vel, vehicula interdum libero. Morbi euismod sagittis libero sed lacinia.\n\nSed tempus felis lobortis leo pulvinar rutrum. Nam mattis velit nisl, eu condimentum ligula luctus nec. Phasellus semper velit eget aliquet faucibus. In a mattis elit. Phasellus vel urna viverra, condimentum lorem id, rhoncus nibh. Ut pellentesque posuere elementum. Sed a varius odio. Morbi rhoncus ligula libero, vel eleifend nunc tristique vitae. Fusce et sem dui. Aenean nec scelerisque tortor. Fusce malesuada accumsan magna vel tempus. Quisque mollis felis eu dolor tristique, sit amet auctor felis gravida. Sed libero lorem, molestie sed nisl in, accumsan tempor nisi. Fusce sollicitudin massa ut lacinia mattis. Sed vel eleifend lorem. Pellentesque vitae felis pretium, pulvinar elit eu, euismod sapien.\n")
            ->operationId('findPets')
            ->parameters($tagsParameter, $limitParameter)
            ->responses($petListingResponse, $defaultErrorResponse);

        $addPet = Operation::post()
            ->description('Creates a new pet in the store.  Duplicates are allowed')
            ->operationId('addPet')
            ->requestBody(
                RequestBody::create()
                    ->description('Pet to add to the store')
                    ->required()
                    ->content(
                        MediaType::json()->schema(
                            Schema::ref('#/components/schemas/NewPet'),
                        ),
                    ),
            )
            ->responses($petResponse, $defaultErrorResponse);

        $pathItem = PathItem::create()
            ->path('/pets')
            ->operations($operation, $addPet);

        $petIdParameter = Parameter::path()
            ->name('id')
            ->description('ID of pet to fetch')
            ->required()
            ->schema(
                Schema::integer('integer_test')->format(Schema::FORMAT_INT64),
            );

        $findPetById = Operation::get()
            ->description('Returns a user based on a single ID, if the user does not have access to the pet')
            ->operationId('find pet by id')
            ->parameters($petIdParameter)
            ->responses($petResponse, $defaultErrorResponse);

        $petDeletedResponse = Response::deleted('pet deleted');

        $deletePetById = Operation::delete()
            ->description('deletes a single pet based on the ID supplied')
            ->operationId('deletePet')
            ->parameters($petIdParameter->description('ID of pet to delete'))
            ->responses($petDeletedResponse, $defaultErrorResponse);

        $petNested = PathItem::create()
            ->path('/pets/{id}')
            ->operations($findPetById, $deletePetById);

        $openApi = OpenApi::create()
            ->openapi(OASVersion::V_3_1_0)
            ->info($info)
            ->servers($server)
            ->paths($pathItem, $petNested)
            ->components($components);

        $exampleResponse = file_get_contents(realpath(__DIR__ . '/../Doubles/Stubs/petstore_expanded.json'));

        $this->assertEquals(
            File::json($exampleResponse),
            $openApi->jsonSerialize(),
        );
    }
}
