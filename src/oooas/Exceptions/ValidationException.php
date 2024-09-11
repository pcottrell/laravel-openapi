<?php

namespace MohammadAlavi\ObjectOrientedOAS\Exceptions;

class ValidationException extends \Exception
{
    public function __construct(protected array $errors, $message = '', $code = 0, \Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
