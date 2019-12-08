<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use PHPUnit\Framework\TestCase;

class InitializeTest extends TestCase
{
    protected function setUp(): void
    {
        $this->previousContainer = Globals::$container;
    }

    protected function tearDown(): void
    {
        Globals::$container = $this->previousContainer;
    }

    public function testInitialize(): void
    {
        require __DIR__ . '/../../src/initialize.php';

        $this->assertInstanceOf(FacadeContainer::class, Globals::$container);
        $this->assertNotSame($this->previousContainer, Globals::$container);
    }
}
