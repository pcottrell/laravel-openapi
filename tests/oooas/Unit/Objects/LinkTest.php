<?php

use MohammadAlavi\ObjectOrientedOAS\Objects\Link;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;

describe('Link', function (): void {
    it('can be created with all parameters', function (): void {
        $server = Server::create('testServer');
        $link = Link::create('LinkName')
            ->operationRef('testRef')
            ->operationId('testId')
            ->description('Some descriptions')
            ->server($server);

        expect($link->toArray())->toEqual([
            'operationRef' => 'testRef',
            'operationId' => 'testId',
            'description' => 'Some descriptions',
            'server' => $server->toArray(),
        ]);
    });
})->covers(Link::class);
