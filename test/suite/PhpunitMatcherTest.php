<?php

namespace Eloquent\Phony\Phpunit;

use PHPUnit\Framework\TestCase;

class PhpunitMatcherTest extends TestCase
{
    protected function setUp()
    {
        $this->matcher = $this->equalTo('x');
        $this->subject = new PhpunitMatcher($this->matcher);

        $this->description = '<is equal to <string:x>>';
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
