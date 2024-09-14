<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody as RequestBodyAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;

class RequestBodyBuilder
{
    public function build(RouteInformation $routeInformation): RequestBody|null
    {
        /** @var RequestBodyAttribute|null $requestBody */
        $requestBody = $routeInformation->actionAttributes->first(static fn (object $attribute): bool => $attribute instanceof RequestBodyAttribute);

        if ($requestBody) {
            /** @var RequestBodyFactory $requestBodyFactory */
            $requestBodyFactory = app($requestBody->factory);

            $requestBody = $requestBodyFactory->build();

            if ($requestBodyFactory instanceof Reusable) {
                return RequestBody::ref('#/components/requestBodies/' . $requestBody->objectId);
            }
        }

        return $requestBody;
    }
}
