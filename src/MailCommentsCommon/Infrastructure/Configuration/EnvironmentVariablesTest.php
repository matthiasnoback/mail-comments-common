<?php

namespace MailCommentsCommon\Infrastructure\Configuration;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EnvironmentVariablesTest extends TestCase
{
    /**
     * @test
     */
    public function it_fails_if_the_requested_key_is_not_defined(): void
    {
        $env = EnvironmentVariables::fromArray([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Please provide a value for the environment variable "undefined"');

        $env->getString('undefined');
    }

    /**
     * @test
     */
    public function it_returns_the_value_of_the_given_key_as_a_string(): void
    {
        $env = EnvironmentVariables::fromArray(['foo' => 'bar']);

        self::assertSame('bar', $env->getString('foo'));
    }

    /**
     * @test
     */
    public function it_returns_the_default_string_value_if_the_key_is_undefined(): void
    {
        $env = EnvironmentVariables::fromArray([]);

        self::assertSame('bar', $env->getString('foo', 'bar'));
    }

    /**
     * @test
     */
    public function it_returns_the_value_of_the_given_key_as_an_integer(): void
    {
        $env = EnvironmentVariables::fromArray(['foo' => '12']);

        self::assertSame(12, $env->getInt('foo'));
    }

    /**
     * @test
     */
    public function it_returns_the_default_int_value_if_the_key_is_undefined(): void
    {
        $env = EnvironmentVariables::fromArray([]);

        self::assertSame(12, $env->getInt('foo', 12));
    }

    /**
     * @test
     */
    public function it_returns_the_value_of_the_given_key_as_a_float(): void
    {
        $env = EnvironmentVariables::fromArray(['foo' => '1.5']);

        self::assertSame(1.5, $env->getFloat('foo'));
    }

    /**
     * @test
     */
    public function it_returns_the_default_float_value_if_the_key_is_undefined(): void
    {
        $env = EnvironmentVariables::fromArray([]);

        self::assertSame(1.2, $env->getFloat('foo', 1.2));
    }

    /**
     * @test
     * @dataProvider trueValues
     */
    public function it_returns_true_if_a_boolean_is_requested($value): void
    {
        $env = EnvironmentVariables::fromArray(
            [
                'foo' => $value
            ]
        );

        self::assertSame(true, $env->getBoolean('foo'));
    }

    /**
     * @test
     * @dataProvider falseValues
     */
    public function it_returns_false_if_a_boolean_is_requested($value): void
    {
        $env = EnvironmentVariables::fromArray(
            [
                'foo' => $value
            ]
        );

        self::assertSame(false, $env->getBoolean('foo'));
    }

    /**
     * @test
     */
    public function it_returns_the_given_boolean_default_value_if_the_key_is_undefined(): void
    {
        $env = EnvironmentVariables::fromArray([]);

        self::assertSame(true, $env->getBoolean('foo', true));
    }

    public function trueValues(): array
    {
        return [
            ['true'],
            ['1'],
            [1],
            [true]
        ];
    }

    public function falseValues(): array
    {
        return [
            ['false'],
            ['0'],
            [''],
            [0],
            [false]
        ];
    }
}
