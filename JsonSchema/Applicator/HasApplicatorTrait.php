<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Applicator;

use MohammadAlavi\ObjectOrientedJSONSchema\Applicator;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;

trait HasApplicatorTrait
{
    private Applicator|null $applicator = null;

    /**
     * An <a href="https://json-schema.org/learn/glossary#instance">instance</a>
     * validates successfully against this keyword if it validates
     * successfully against all schemas defined by this keyword’s value.
     * It’s essentially a logical “AND” operation where all conditions must be met for validation to pass.
     * Remember, if any <a href="https://json-schema.org/learn/glossary#schema">subschema</a>
     * within the <a href="https://www.learnjsonschema.com/2020-12/applicator/allof/">allOf</a>
     * keyword fails validation or has a boolean false value, the entire validation will always fail.
     *
     * @see https://www.learnjsonschema.com/2020-12/applicator/allof/
     */
    public function allOf(bool|Descriptor ...$schema): self
    {
        $clone = clone $this;

        $clone->applicator = $this->applicator->allOf(...$schema);

        return $clone;
    }

    /**
     * An <a href="https://json-schema.org/learn/glossary#instance">instance</a>
     * validates successfully against this keyword if it validates
     * successfully against at least one schema defined by this keyword’s value.
     * It allows you to define multiple schemas, and if the data validates against any one of them,
     * the validation passes.
     * Remember, if any <a href="https://json-schema.org/learn/glossary#schema">subschema</a>
     * within the <a href="https://www.learnjsonschema.com/2020-12/applicator/anyof/">anyOf</a>
     * keyword passes validation or has a boolean true value, the overall result of anyOf is considered valid.
     *
     * @see https://www.learnjsonschema.com/2020-12/applicator/anyof/
     */
    public function anyOf(bool|Descriptor ...$schema): self
    {
        $clone = clone $this;

        $clone->applicator = $this->applicator->anyOf(...$schema);

        return $clone;
    }

    /**
     * An <a href="https://json-schema.org/learn/glossary#instance">instance</a>
     * validates successfully against this keyword if it validates
     * successfully against exactly one schema defined by this keyword’s value.
     * It ensures that the instance validates against one and only one of the defined
     * <a href="https://json-schema.org/learn/glossary#schema">subschemas</a> within the oneOf array.
     * This behavior is akin to a logical “XOR” (exclusive OR) operation,
     * where only one condition needs to be met for validation to pass.
     * Remember, if any subschema within the
     * <a href="https://www.learnjsonschema.com/2020-12/applicator/oneof/">oneOf</a>
     * keyword passes validation or has a boolean true value, all the other subschemas
     * within oneOf must fail the validation for the overall validation of the oneOf keyword to be true.
     *
     * @see https://www.learnjsonschema.com/2020-12/applicator/oneof/
     */
    public function oneOf(bool|Descriptor ...$schema): self
    {
        $clone = clone $this;

        $clone->applicator = $this->applicator->oneOf(...$schema);

        return $clone;
    }
}
