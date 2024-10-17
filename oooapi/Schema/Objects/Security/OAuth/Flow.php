<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyGenerator;

abstract readonly class Flow extends ReadonlyGenerator
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
