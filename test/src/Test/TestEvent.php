<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit\Test;

use Eloquent\Phony\Event\Event;

class TestEvent implements Event
{
    public function __construct(int $sequenceNumber, float $time)
    {
        $this->sequenceNumber = $sequenceNumber;
        $this->time = $time;
    }

    public function sequenceNumber(): int
    {
        return $this->sequenceNumber;
    }

    public function time(): float
    {
        return $this->time;
    }

    /**
     * @var int
     */
    private $sequenceNumber;

    /**
     * @var float
     */
    private $time;
}
