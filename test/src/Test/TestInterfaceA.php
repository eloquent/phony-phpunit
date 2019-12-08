<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit\Test;

interface TestInterfaceA
{
    public static function testClassAStaticMethodA(): string;

    public static function testClassAStaticMethodB(string $first, string $second): string;

    public function testClassAMethodA(): string;

    public function testClassAMethodB(string $first, string $second): string;
}
