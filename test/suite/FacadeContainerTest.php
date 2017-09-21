<?php

namespace Eloquent\Phony\Phpunit;

use PHPUnit\Framework\TestCase;

class FacadeContainerTest extends TestCase
{
    public function testContainer()
    {
        $subject = new FacadeContainer();

        $this->assertNotNull($subject->mockBuilderFactory);
        $this->assertNotNull($subject->handleFactory);
        $this->assertNotNull($subject->spyVerifierFactory);
        $this->assertNotNull($subject->stubVerifierFactory);
        $this->assertNotNull($subject->functionHookManager);
        $this->assertNotNull($subject->eventOrderVerifier);
        $this->assertNotNull($subject->matcherFactory);
        $this->assertNotNull($subject->exporter);
        $this->assertNotNull($subject->assertionRenderer);
        $this->assertNotNull($subject->differenceEngine);
        $this->assertNotNull($subject->emptyValueFactory);
        $this->assertNotNull($subject->sequences);
    }
}
