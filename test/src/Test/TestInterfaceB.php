<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit\Test;

interface TestInterfaceB extends TestInterfaceA
{
    public static function testClassBStaticMethodA(): string;

    public function testClassBMethodA(): string;

    public function testClassBMethodB(string &$first, string &$second): string;
}
