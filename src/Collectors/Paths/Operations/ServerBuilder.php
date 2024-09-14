<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations;

use MohammadAlavi\ObjectOrientedOAS\Objects\Server;

readonly class ServerBuilder
{
    public function __construct(
        private \MohammadAlavi\LaravelOpenApi\Collectors\ServerBuilder $serverBuilder,
    ) {
    }

    /**
     * @param array<array-key, class-string<Server>> $serverFactories
     *
     * @return Server[]
     */
    public function build(array $serverFactories): array
    {
        return $this->serverBuilder->build($serverFactories);
    }
}
