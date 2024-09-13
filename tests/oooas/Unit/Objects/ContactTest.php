<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\Contact;
use MohammadAlavi\ObjectOrientedOAS\Objects\Info;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Contact::class)]
class ContactTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $contact = Contact::create()
            ->name('GoldSpec Digital')
            ->url('https://example.com')
            ->email('hello@example.com');

        $info = Info::create()
            ->contact($contact);

        $this->assertSame([
            'contact' => [
                'name' => 'GoldSpec Digital',
                'url' => 'https://example.com',
                'email' => 'hello@example.com',
            ],
        ], $info->toArray());
    }
}
