<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Facade\FacadeTrait;

/**
 * A facade for Phony usage under PHPUnit.
 */
class Phony
{
    use FacadeTrait;

    /**
     * @var class-string
     */
    private static $globals = Globals::class;
}
