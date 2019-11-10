<?php

namespace MailCommentsCommon\Application;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class AuthorizationTokenTest extends TestCase
{
    /**
     * @test
     */
    public function it_requires_a_string_in_the_correct_format(): void
    {
        $this->expectException(InvalidArgumentException::class);

        AuthorizationToken::fromString('not the correct format');
    }

    /**
     * @test
     */
    public function it_can_be_created_from_a_string_and_converted_back_to_it(): void
    {
        $token = '1b67d3fe-b4e2-47be-83ad-28920b742e53';
        self::assertEquals(
            $token,
            AuthorizationToken::fromString($token)->asString()
        );
    }
}
