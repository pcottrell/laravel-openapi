<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Core;

use MohammadAlavi\ObjectOrientedJSONSchema\Core;
use MohammadAlavi\ObjectOrientedJSONSchema\Core\Defs\Def;

trait CoreVocabulary
{
    private Core|null $core = null;

    /**
     * Set a static reference to another <a href="https://json-schema.org/learn/glossary#schema">schema</a>.
     * This is useful for avoiding code duplication and promoting modularity when describing complex data structures.
     *
     * @param string $value Must be an absolute URI or a relative reference as defined by
     * <a href="https://www.rfc-editor.org/info/rfc3986">RFC 3986</a>, where its fragment (if any) can
     * consist of a JSON Pointer as defined by <a href="https://datatracker.ietf.org/doc/html/rfc6901">RFC 6901</a>
     *
     * @see https://www.learnjsonschema.com/2020-12/core/ref/
     * @see https://json-schema.org/understanding-json-schema/structuring
     */
    public function ref(string $value): self
    {
        $clone = clone $this;

        $clone->core = $this->core->ref($value);

        return $clone;
    }

    public function defs(Def ...$def): self
    {
        $clone = clone $this;

        $clone->core = $this->core->defs(...$def);

        return $clone;
    }
}
