<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit\Test;

interface TestInterfaceA
{
    public static function testClassAStaticMethodA();

    public static function testClassAStaticMethodB($first, $second);

    public function testClassAMethodA();

    public function testClassAMethodB($first, $second);
}
