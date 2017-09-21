<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Facade\FacadeContainerTrait;

/**
 * A service container for Phony for PHPUnit facades.
 */
class FacadeContainer
{
    use FacadeContainerTrait;

    public function __construct()
    {
        $this->initializeContainer(new AssertionRecorder());
        $this->matcherFactory->addMatcherDriver(new ConstraintMatcherDriver());
    }
}
