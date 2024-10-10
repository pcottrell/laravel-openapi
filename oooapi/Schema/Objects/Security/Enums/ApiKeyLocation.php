<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums;

enum ApiKeyLocation: string
{
    case QUERY = 'query';
    case HEADER = 'header';
    case COOKIE = 'cookie';
}
