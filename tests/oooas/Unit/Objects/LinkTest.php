<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\Link;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Link::class)]
class LinkTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks()
    {
        $link = Link::create('LinkName')
            ->operationId('goldspecdigital')
            ->description('The GoldSpec Digital website');

        $response = Response::create()
            ->links($link);

        $this->assertSame([
            'links' => [
                'LinkName' => [
                    'operationId' => 'goldspecdigital',
                    'description' => 'The GoldSpec Digital website',
                ],
            ],
        ], $response->toArray());
    }
}
