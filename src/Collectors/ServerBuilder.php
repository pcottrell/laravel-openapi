<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors;

use MohammadAlavi\LaravelOpenApi\Factories\ServerFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;
use Webmozart\Assert\Assert;

class ServerBuilder
{
    /**
     * @param array<array-key, class-string<ServerFactory>> $serverFactories
     *
     * @return Server[]
     */
    public function build(array $serverFactories): array
    {
        return collect($serverFactories)
            ->filter(static fn (string $serverFactory): bool => app($serverFactory) instanceof ServerFactory)
            ->map(static function (string $serverFactory): Server {
                /** @var Server $server */
                $server = app($serverFactory)->build();
                // TODO: this can be moved to Serve Constructor I think
                Assert::stringNotEmpty($server->url);

                return $server;
            })
            ->toArray();
    }
}
