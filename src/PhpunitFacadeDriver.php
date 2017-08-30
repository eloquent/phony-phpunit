<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Facade\FacadeDriverTrait;

/**
 * A facade driver for PHPUnit.
 */
class PhpunitFacadeDriver
{
    use FacadeDriverTrait;

    /**
     * Get the static instance of this driver.
     *
     * @return PhpunitFacadeDriver The static driver.
     */
    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    private function __construct()
    {
        $this->initializeFacadeDriver(new PhpunitAssertionRecorder());
        $this->matcherFactory->addMatcherDriver(new PhpunitMatcherDriver());
    }

    private static $instance;
}
