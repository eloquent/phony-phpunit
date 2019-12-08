<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Exporter\Exporter;
use Eloquent\Phony\Matcher\Matcher;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * A matcher that wraps a PHPUnit constraint.
 */
class ConstraintMatcher implements Matcher
{
    /**
     * Construct a new constraint matcher.
     *
     * @param Constraint $constraint The constraint to wrap.
     */
    public function __construct(Constraint $constraint)
    {
        $this->constraint = $constraint;
    }

    /**
     * Returns `true` if `$value` matches this matcher's criteria.
     *
     * @param mixed $value The value to check.
     *
     * @return bool True if the value matches.
     */
    public function matches($value): bool
    {
        return (bool) $this->constraint->evaluate($value, '', true);
    }

    /**
     * Describe this matcher.
     *
     * @param Exporter|null $exporter The exporter to use.
     *
     * @return string The description.
     */
    public function describe(Exporter $exporter = null): string
    {
        return '<' . $this->constraint->toString() . '>';
    }

    /**
     * Describe this matcher.
     *
     * @return string The description.
     */
    public function __toString(): string
    {
        return '<' . $this->constraint->toString() . '>';
    }

    /**
     * @var Constraint
     */
    private $constraint;
}
