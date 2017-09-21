<?php

declare(strict_types=1);

use Eloquent\Phony\Phpunit\Phony;
use Eloquent\Phony\Phpunit\Test\TestClassA;
use PHPUnit\Framework\TestCase;

class PhonyTest extends TestCase
{
    protected function setUp()
    {
        $this->handle = Phony::mock(TestClassA::class);
        $this->mock = $this->handle->get();
    }

    public function testShouldRecordPassingMockAssertions()
    {
        $this->mock->testClassAMethodA('aardvark', 'bonobo');

        $this->handle->testClassAMethodA->calledWith('aardvark', 'bonobo');
    }

    public function testShouldRecordFailingMockAssertions()
    {
        $this->mock->testClassAMethodA('aardvark', ['bonobo', 'capybara', 'dugong']);
        $this->mock->testClassAMethodA('armadillo', ['bonobo', 'chameleon', 'dormouse']);

        $this->handle->testClassAMethodA->calledWith('aardvark', ['bonobo', 'chameleon', 'dugong']);
    }
}
