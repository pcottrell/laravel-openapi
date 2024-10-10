<?php

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Link;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Server;

describe('Link', function (): void {
    it('can be created with no parameters', function (): void {
        $link = Link::create('test');

        expect($link->jsonSerialize())->toBeEmpty();
    });

    it('can be created with all parameters', function (): void {
        $server = Server::create();
        $link = Link::create('test')
            ->operationRef('testRef')
            ->operationId('testId')
            ->description('Some descriptions')
            ->server($server);

        expect($link->jsonSerialize())->toBe([
            'operationRef' => 'testRef',
            'operationId' => 'testId',
            'description' => 'Some descriptions',
            'server' => $server->jsonSerialize(),
        ]);
    });
})->covers(Link::class);
