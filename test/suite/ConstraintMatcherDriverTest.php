<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase;

class ConstraintMatcherDriverTest extends TestCase
{
    protected function setUp(): void
    {
        $this->subject = new ConstraintMatcherDriver();

        $this->matcher = $this->equalTo('x');
    }

    public function testIsAvailable(): void
    {
        $this->assertTrue($this->subject->isAvailable());
    }

    public function testMatcherClassNames(): void
    {
        $this->assertSame([Constraint::class], $this->subject->matcherClassNames());
    }

    public function testWrapMatcher(): void
    {
        $this->assertEquals(new ConstraintMatcher($this->matcher), $this->subject->wrapMatcher($this->matcher));
    }
}
