<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums;

enum SecuritySchemeType: string
{
    case API_KEY = 'apiKey';
    case HTTP = 'http';
    case MUTUAL_TLS = 'mutualTLS';
    case OAUTH2 = 'oauth2';
    case OPEN_ID_CONNECT = 'openIdConnect';
}
