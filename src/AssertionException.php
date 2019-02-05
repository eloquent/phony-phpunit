<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Assertion\Exception\AssertionException as PhonyAssertionException;
use PHPUnit\Framework\AssertionFailedError;

/**
 * Wraps PHPUnit's expectation failed exception for improved assertion failure
 * output.
 */
final class AssertionException extends AssertionFailedError
{
    /**
     * Construct a new PHPUnit assertion exception.
     *
     * @param string $description The failure description.
     */
    public function __construct(string $description)
    {
        PhonyAssertionException::trim($this);

        parent::__construct($description);
    }
}
