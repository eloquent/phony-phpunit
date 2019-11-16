<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit\Test;

class TestClassB extends TestClassA implements TestInterfaceB
{
    public static function testClassAStaticMethodB(
        $first,
        $second,
        &$third = null
    ) {
        $result = implode(func_get_args());

        $third = 'third';

        return $result;
    }

    public static function __callStatic($name, array $arguments)
    {
        return 'static magic ' . $name . ' ' . implode($arguments);
    }

    public function __construct()
    {
        parent::__construct();

        $this->constructorArguments = func_get_args();
    }

    public function testClassAMethodB($first, $second, &$third = null)
    {
        $result = implode(func_get_args());

        $third = 'third';

        return $result;
    }

    public static function testClassBStaticMethodA()
    {
        return implode(func_get_args());
    }

    public static function testClassBStaticMethodB($first, $second)
    {
        return implode(func_get_args());
    }

    public function testClassBMethodA()
    {
        return implode(func_get_args());
    }

    public function testClassBMethodB(&$first, &$second)
    {
        $result = implode(func_get_args());

        $first = 'first';
        $second = 'second';

        return $result;
    }

    public function __call($name, array $arguments)
    {
        return 'magic ' . $name . ' ' . implode($arguments);
    }
}
