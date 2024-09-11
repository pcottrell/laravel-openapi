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
    public function testCreateWithAllParametersWorks(): void
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

    public function testCreateWithOkMethodWorks(): void
    {
        $response = Response::ok();

        $this->assertSame(200, $response->statusCode);
        $this->assertSame('OK', $response->description);
    }

    public function testCreateWithCreatedMethodWorks(): void
    {
        $response = Response::created();

        $this->assertSame(201, $response->statusCode);
        $this->assertSame('Created', $response->description);
    }

    public function testCreateWithMovedPermanentlyMethodWorks(): void
    {
        $response = Response::movedPermanently();

        $this->assertSame(301, $response->statusCode);
        $this->assertSame('Moved Permanently', $response->description);
    }

    public function testCreateWithMovedTemporarilyMethodWorks(): void
    {
        $response = Response::movedTemporarily();

        $this->assertSame(302, $response->statusCode);
        $this->assertSame('Moved Temporarily', $response->description);
    }

    public function testCreateWithBadRequestMethodWorks(): void
    {
        $response = Response::badRequest();

        $this->assertSame(400, $response->statusCode);
        $this->assertSame('Bad Request', $response->description);
    }

    public function testCreateWithUnauthorizedMethodWorks(): void
    {
        $response = Response::unauthorized();

        $this->assertSame(401, $response->statusCode);
        $this->assertSame('Unauthorized', $response->description);
    }

    public function testCreateWithNotFoundMethodWorks(): void
    {
        $response = Response::notFound();

        $this->assertSame(404, $response->statusCode);
        $this->assertSame('Not Found', $response->description);
    }

    public function testCreateWithUnprocessableEntityMethodWorks(): void
    {
        $response = Response::unprocessableEntity();

        $this->assertSame(422, $response->statusCode);
        $this->assertSame('Unprocessable Entity', $response->description);
    }

    public function testCreateWithTooManyRequestsMethodWorks(): void
    {
        $response = Response::tooManyRequests();

        $this->assertSame(429, $response->statusCode);
        $this->assertSame('Too Many Requests', $response->description);
    }

    public function testCreateWithInternalServerErrorMethodWorks(): void
    {
        $response = Response::internalServerError();

        $this->assertSame(500, $response->statusCode);
        $this->assertSame('Internal Server Error', $response->description);
    }
}
