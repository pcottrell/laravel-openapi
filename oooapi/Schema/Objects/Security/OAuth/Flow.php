<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

abstract readonly class Flow extends ReadonlyJsonSerializable
{
    protected ScopeCollection $scopeCollection;

    protected function __construct(
        protected string|null $refreshUrl,
        ScopeCollection|null $scopeCollection,
    ) {
        $this->scopeCollection = $scopeCollection ?? ScopeCollection::create();
    }

    public function scopeCollection(): ScopeCollection
    {
        return $this->scopeCollection;
    }
}
