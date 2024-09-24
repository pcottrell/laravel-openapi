<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Objects\Security\Enums;

enum HttpScheme: string
{
    case BASIC = 'basic';
    case BEARER = 'bearer';
    case DIGEST = 'digest';
    case DPOP = 'dpop';
    case GNAP = 'gnap';
    case HOBA = 'HOBA';
    case MUTUAL = 'Mutual';
    case NEGOTIATE = 'Negotiate';
    case OAUTH = 'OAuth';
    case PRIVATE_TOKEN = 'PrivateToken';
    case SCRAM_SHA_1 = 'SCRAM-SHA-1';
    case SCRAM_SHA_256 = 'SCRAM-SHA-256';
    case VAPID = 'vapid';
}
