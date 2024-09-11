<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors;

use MohammadAlavi\LaravelOpenApi\Factories\ServerFactory;
use MohammadAlavi\LaravelOpenApi\Helpers\BuilderHelper;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;

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
            ->filter(static fn ($serverFactory): bool => app($serverFactory) instanceof ServerFactory)
            ->map(static function (string $serverFactory): Server {
                $server = app($serverFactory)->build();

                throw_if(BuilderHelper::hasInvalidField($server->toArray(), 'url'), new \InvalidArgumentException('Server url is required.'));

                return $server;
            })
            ->toArray();
    }
}
