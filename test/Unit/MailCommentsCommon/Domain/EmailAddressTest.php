<?php

namespace MailCommentsCommon\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EmailAddressTest extends TestCase
{
    /**
     * @test
     */
    public function it_requires_a_valid_email_address(): void
    {
        $this->expectException(InvalidArgumentException::class);

        EmailAddress::fromString('invalid');
    }

    /**
     * @test
     */
    public function it_can_be_converted_to_and_from_a_string(): void
    {
        $emailAddress = 'test@example.com';

        self::assertEquals(
            $emailAddress, EmailAddress::fromString($emailAddress)->asString()
        );
    }
}
