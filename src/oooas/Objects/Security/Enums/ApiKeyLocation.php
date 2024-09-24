<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Objects\Security\Enums;

enum ApiKeyLocation: string
{
    case QUERY = 'query';
    case HEADER = 'header';
    case COOKIE = 'cookie';
}
