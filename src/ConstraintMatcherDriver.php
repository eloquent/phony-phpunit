<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Matcher\Matcher;
use Eloquent\Phony\Matcher\MatcherDriver;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * A matcher driver for PHPUnit constraints.
 */
class ConstraintMatcherDriver implements MatcherDriver
{
    /**
     * Returns true if this matcher driver's classes or interfaces exist.
     *
     * @return bool True if available.
     */
    public function isAvailable(): bool
    {
        return class_exists(Constraint::class);
    }

    /**
     * Get the supported matcher class names.
     *
     * @return array<string> The matcher class names.
     */
    public function matcherClassNames(): array
    {
        return [Constraint::class];
    }

    /**
     * Wrap the supplied third party matcher.
     *
     * @param Constraint $matcher The matcher to wrap.
     *
     * @return Matcher The wrapped matcher.
     */
    public function wrapMatcher(object $matcher): Matcher
    {
        return new ConstraintMatcher($matcher);
    }
}
