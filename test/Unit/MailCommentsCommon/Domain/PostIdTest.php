<?php

namespace MailCommentsCommon\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class PostIdTest extends TestCase
{
    /**
     * @test
     */
    public function it_requires_a_string_in_the_correct_format(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PostId::fromString('not the correct format');
    }

    /**
     * @test
     */
    public function it_can_be_created_from_a_string_and_converted_back_to_it(): void
    {
        $id = 'd8e8fca2ab';
        self::assertEquals(
            $id,
            PostId::fromString($id)->asString()
        );
    }
}
