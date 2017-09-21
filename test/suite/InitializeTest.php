<?php

namespace Eloquent\Phony\Phpunit;

use PHPUnit\Framework\TestCase;

class InitializeTest extends TestCase
{
    protected function setUp()
    {
        $this->previousContainer = Globals::$container;
    }

    protected function tearDown()
    {
        Globals::$container = $this->previousContainer;
    }

    public function testInitialize()
    {
        require __DIR__ . '/../../src/initialize.php';

        $this->assertInstanceOf(FacadeContainer::class, Globals::$container);
        $this->assertNotSame($this->previousContainer, Globals::$container);
    }
}
