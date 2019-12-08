<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit\Test;

class TestClassB extends TestClassA implements TestInterfaceB
{
    public static function testClassAStaticMethodB(
        string $first,
        string $second,
        string &$third = null
    ): string {
        $result = implode(func_get_args());

        $third = 'third';

        return $result;
    }

    /**
     * @param array<string> $arguments
     */
    public static function __callStatic(string $name, array $arguments): string
    {
        return 'static magic ' . $name . ' ' . implode($arguments);
    }

    public function __construct()
    {
        parent::__construct();

        $this->constructorArguments = func_get_args();
    }

    public function testClassAMethodB(string $first, string $second, string &$third = null): string
    {
        $result = implode(func_get_args());

        $third = 'third';

        return $result;
    }

    public static function testClassBStaticMethodA(): string
    {
        return implode(func_get_args());
    }

    public static function testClassBStaticMethodB(string $first, string $second): string
    {
        return implode(func_get_args());
    }

    public function testClassBMethodA(): string
    {
        return implode(func_get_args());
    }

    public function testClassBMethodB(string &$first, string &$second): string
    {
        $result = implode(func_get_args());

        $first = 'first';
        $second = 'second';

        return $result;
    }

    /**
     * @param array<string> $arguments
     */
    public function __call(string $name, array $arguments): string
    {
        return 'magic ' . $name . ' ' . implode($arguments);
    }
}
