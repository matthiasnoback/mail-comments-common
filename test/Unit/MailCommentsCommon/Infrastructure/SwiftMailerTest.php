<?php

namespace MailCommentsCommon\Infrastructure;

use MailCommentsCommon\Application\Email\CouldNotSendEmail;
use MailCommentsCommon\Application\Email\Email;
use MailCommentsCommon\Infrastructure\SwiftMailer\SwiftMailer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Swift_Mailer;
use Swift_Message;
use Swift_Transport;

final class SwiftMailerTest extends TestCase
{
    /**
     * @var MockObject&Swift_Transport
     */
    private $transport;

    /**
     * @var SwiftMailer
     */
    private $mailer;

    protected function setUp(): void
    {
        $this->transport = $this->createMock(Swift_Transport::class);
        $this->mailer = new SwiftMailer(new Swift_Mailer($this->transport));
    }

    /**
     * @test
     */
    public function it_sends_a_swift_email_based_on_our_email_abstraction(): void
    {
        /** @var Swift_Message|null $sentMessage */
        $sentMessage = null;
        $this->transport->expects($this->once())
            ->method('send')
            ->willReturnCallback(
                function (Swift_Message $message) use (&$sentMessage) {
                    $sentMessage = $message;
                }
            );

        $this->mailer->send(
            Email::fromScratch()
                ->withSubject('Subject')
                ->withTo('blog@matthiasnoback.nl', 'Matthias Noback')
                ->withFrom('test@example.com', 'Test')
                ->withBody('Body', 'text/plain')
                ->withAttachment('text', 'text.txt', 'text/plain')
        );

        self::assertInstanceOf(Swift_Message::class, $sentMessage);
        self::assertEquals('Subject', $sentMessage->getSubject());
        self::assertEquals(['test@example.com' => 'Test'], $sentMessage->getFrom());
        self::assertEquals(['blog@matthiasnoback.nl' => 'Matthias Noback'], $sentMessage->getTo());
        self::assertEquals('Body', $sentMessage->getBody());
        self::assertEquals('text/plain', $sentMessage->getBodyContentType());
        $attachment = $sentMessage->getChildren()[0];
        self::assertEquals('text', $attachment->getBody());
        self::assertEquals(
            "Content-Type: text/plain; name=text.txt\r\n",
            $attachment->getHeaders()->get('Content-Type')->toString()
        );
    }

    /**
     * @test
     */
    public function it_throws_a_custom_exception_if_the_swift_mailer_has_sent_0_messages(): void
    {
        $this->transport->expects($this->once())
            ->method('send')
            ->willReturn(0);

        $this->expectException(CouldNotSendEmail::class);
        $this->expectExceptionMessage('0 messages');

        $this->mailer->send(
            Email::fromScratch()
                ->withTo('blog@matthiasnoback.nl')
                ->withFrom('test@example.com')
        );
    }

    /**
     * @test
     */
    public function it_throws_a_custom_exception_if_the_swift_mailer_throws_an_exception(): void
    {
        $this->transport->expects($this->once())
            ->method('send')
            ->willThrowException(new RuntimeException('Swift error'));

        $this->expectException(CouldNotSendEmail::class);
        $this->expectExceptionMessage('Swift error');

        $this->mailer->send(
            Email::fromScratch()
                ->withTo('blog@matthiasnoback.nl')
                ->withFrom('test@example.com')
        );
    }
}
