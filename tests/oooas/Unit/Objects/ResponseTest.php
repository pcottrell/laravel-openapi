<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\Example;
use MohammadAlavi\ObjectOrientedOAS\Objects\Header;
use MohammadAlavi\ObjectOrientedOAS\Objects\Link;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Response::class)]
class ResponseTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks()
    {
        $header = Header::create('HeaderName')
            ->description('Lorem ipsum')
            ->required()
            ->deprecated()
            ->allowEmptyValue()
            ->style(Header::STYLE_SIMPLE)
            ->explode()
            ->allowReserved()
            ->schema(Schema::string())
            ->example('Example String')
            ->examples(
                Example::create('ExampleName')
                    ->value('Example value'),
            )
            ->content(MediaType::json());

        $link = Link::create('MyLink');

        $response = Response::create()
            ->statusCode(200)
            ->description('OK')
            ->headers($header)
            ->content(MediaType::json())
            ->links($link);

        $this->assertEquals(
            [
                'description' => 'OK',
                'headers' => [
                    'HeaderName' => [
                        'description' => 'Lorem ipsum',
                        'required' => true,
                        'deprecated' => true,
                        'allowEmptyValue' => true,
                        'style' => 'simple',
                        'explode' => true,
                        'allowReserved' => true,
                        'schema' => [
                            'type' => 'string',
                        ],
                        'example' => 'Example String',
                        'examples' => [
                            'ExampleName' => [
                                'value' => 'Example value',
                            ],
                        ],
                        'content' => [
                            'application/json' => [],
                        ],
                    ],
                ],
                'content' => [
                    'application/json' => [],
                ],
                'links' => [
                    'MyLink' => [],
                ],
            ],
            $response->toArray(),
        );
    }

    public function testCreateWithOkMethodWorks()
    {
        $response = Response::ok();

        $this->assertEquals(200, $response->statusCode);
        $this->assertEquals('OK', $response->description);
    }

    public function testCreateWithCreatedMethodWorks()
    {
        $response = Response::created();

        $this->assertEquals(201, $response->statusCode);
        $this->assertEquals('Created', $response->description);
    }

    public function testCreateWithMovedPermanentlyMethodWorks()
    {
        $response = Response::movedPermanently();

        $this->assertEquals(301, $response->statusCode);
        $this->assertEquals('Moved Permanently', $response->description);
    }

    public function testCreateWithMovedTemporarilyMethodWorks()
    {
        $response = Response::movedTemporarily();

        $this->assertEquals(302, $response->statusCode);
        $this->assertEquals('Moved Temporarily', $response->description);
    }

    public function testCreateWithBadRequestMethodWorks()
    {
        $response = Response::badRequest();

        $this->assertEquals(400, $response->statusCode);
        $this->assertEquals('Bad Request', $response->description);
    }

    public function testCreateWithUnauthorizedMethodWorks()
    {
        $response = Response::unauthorized();

        $this->assertEquals(401, $response->statusCode);
        $this->assertEquals('Unauthorized', $response->description);
    }

    public function testCreateWithNotFoundMethodWorks()
    {
        $response = Response::notFound();

        $this->assertEquals(404, $response->statusCode);
        $this->assertEquals('Not Found', $response->description);
    }

    public function testCreateWithUnprocessableEntityMethodWorks()
    {
        $response = Response::unprocessableEntity();

        $this->assertEquals(422, $response->statusCode);
        $this->assertEquals('Unprocessable Entity', $response->description);
    }

    public function testCreateWithTooManyRequestsMethodWorks()
    {
        $response = Response::tooManyRequests();

        $this->assertEquals(429, $response->statusCode);
        $this->assertEquals('Too Many Requests', $response->description);
    }

    public function testCreateWithInternalServerErrorMethodWorks()
    {
        $response = Response::internalServerError();

        $this->assertEquals(500, $response->statusCode);
        $this->assertEquals('Internal Server Error', $response->description);
    }
}
