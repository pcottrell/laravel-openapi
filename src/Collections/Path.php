<?php

namespace MohammadAlavi\LaravelOpenApi\Collections;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;
use Webmozart\Assert\Assert;

final readonly class Path
{
    public string $path;
    public PathItem $pathItem;

    public static function create(string $path, PathItem $pathItem): self
    {
        Assert::startsWith($path, '/');

        $instance = new self();
        $instance->path = $path;
        $instance->pathItem = $pathItem;

        return $instance;
    }
}
