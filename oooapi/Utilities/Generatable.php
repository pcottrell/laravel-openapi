<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Utilities;

// TODO: is it possible to make this class readonly?
abstract class Generatable implements \JsonSerializable
{
    use Generator;
}
