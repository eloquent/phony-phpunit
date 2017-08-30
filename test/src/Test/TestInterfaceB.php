<?php

namespace Eloquent\Phony\Phpunit\Test;

interface TestInterfaceB extends TestInterfaceA
{
    public static function testClassBStaticMethodA();

    public function testClassBMethodA();

    public function testClassBMethodB(&$first, &$second);
}
