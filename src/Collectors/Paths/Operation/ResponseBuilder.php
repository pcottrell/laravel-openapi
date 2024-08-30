<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\LaravelOpenApi\Attributes\Response as ResponseAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

class ResponseBuilder
{
    public function build(RouteInformation $route): array
    {
        return $route->actionAttributes
            ->filter(static fn (object $attribute) => $attribute instanceof ResponseAttribute)
            ->map(static function (ResponseAttribute $attribute) {
                $factory = app($attribute->factory);
                $response = $factory->build();

                if ($factory instanceof Reusable) {
                    return Response::ref('#/components/responses/' . $response->objectId)
                        ->statusCode($attribute->statusCode)
                        ->description($attribute->description);
                }

                return $response;
            })
            ->values()
            ->toArray();
    }
}