<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Call\CallVerifierFactory;
use Eloquent\Phony\Call\Event\ReturnedEvent;
use Eloquent\Phony\Event\EventSequence;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class AssertionRecorderTest extends TestCase
{
    protected function setUp()
    {
        $this->subject = new AssertionRecorder();

        $this->callVerifierFactory = CallVerifierFactory::instance();
        $this->subject->setCallVerifierFactory($this->callVerifierFactory);
    }

    public function testCreateSuccess()
    {
        $events = [new ReturnedEvent(0, 0.0, null), new ReturnedEvent(1, 1.0, null)];
        $expected = new EventSequence($events, $this->callVerifierFactory);
        $beforeCount = Assert::getCount();
        $actual = $this->subject->createSuccess($events);
        $afterCount = Assert::getCount();

        $this->assertEquals($expected, $actual);
        $this->assertSame($beforeCount + 1, $afterCount);
    }

    public function testCreateSuccessDefaults()
    {
        $expected = new EventSequence([], $this->callVerifierFactory);
        $beforeCount = Assert::getCount();
        $actual = $this->subject->createSuccess();
        $afterCount = Assert::getCount();

        $this->assertEquals($expected, $actual);
        $this->assertSame($beforeCount + 1, $afterCount);
    }

    public function testCreateSuccessFromEventCollection()
    {
        $events = new EventSequence([], $this->callVerifierFactory);

        $this->assertEquals($events, $this->subject->createSuccessFromEventCollection($events));
    }

    public function testCreateFailure()
    {
        $description = 'description';

        $this->expectException(AssertionException::class);
        $this->expectExceptionMessage($description);
        $this->subject->createFailure($description);
    }
}
