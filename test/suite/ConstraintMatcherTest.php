<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use PHPUnit\Framework\TestCase;

class ConstraintMatcherTest extends TestCase
{
    protected function setUp()
    {
        $this->matcher = $this->equalTo('x');
        $this->subject = new ConstraintMatcher($this->matcher);

        $this->description = '<is equal to "x">';
    }

    public function testConstructor()
    {
        $this->assertSame($this->description, $this->subject->describe());
        $this->assertSame($this->description, strval($this->subject));
    }

    public function testMatches()
    {
        $this->assertTrue($this->subject->matches('x'));
        $this->assertFalse($this->subject->matches('y'));
    }
}
