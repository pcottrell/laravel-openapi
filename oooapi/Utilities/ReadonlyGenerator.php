<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Utilities;

// TODO: is it possible to make this class readonly?
abstract readonly class ReadonlyGenerator implements \JsonSerializable
{
    use Generator;
}
