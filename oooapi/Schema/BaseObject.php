<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema;

abstract class BaseObject implements \JsonSerializable
{
    public function toJson(
        $options = JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT,
    ): string {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    abstract protected function toArray(): array;
}
