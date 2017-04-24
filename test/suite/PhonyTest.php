<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2017 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Call\Arguments;
use Eloquent\Phony\Matcher\MatcherFactory;
use Eloquent\Phony\Phpunit\Test\TestEvent;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

class PhonyTest extends TestCase
{
    protected function setUp()
    {
        $this->matcherFactory = MatcherFactory::instance();

        $this->eventA = new TestEvent(0, 0.0);
        $this->eventB = new TestEvent(1, 1.0);
    }

    public function testMockBuilder()
    {
        $actual = Phony::mockBuilder('Eloquent\Phony\Phpunit\Test\TestClassA');

        $this->assertInstanceOf('Eloquent\Phony\Mock\Builder\MockBuilder', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassA', $actual->get());
    }

    public function testMockBuilderFunction()
    {
        $actual = mockBuilder('Eloquent\Phony\Phpunit\Test\TestClassA');

        $this->assertInstanceOf('Eloquent\Phony\Mock\Builder\MockBuilder', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassA', $actual->get());
    }

    public function testPartialMock()
    {
        $types = array('Eloquent\Phony\Phpunit\Test\TestClassB', 'Countable');
        $arguments = new Arguments(array('a', 'b'));
        $actual = Phony::partialMock($types, $arguments);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassB', $actual->get());
        $this->assertInstanceOf('Countable', $actual->get());
        $this->assertSame(array('a', 'b'), $actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockWithNullArguments()
    {
        $types = array('Eloquent\Phony\Phpunit\Test\TestClassB', 'Countable');
        $arguments = null;
        $actual = Phony::partialMock($types, $arguments);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassB', $actual->get());
        $this->assertInstanceOf('Countable', $actual->get());
        $this->assertNull($actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockWithNoArguments()
    {
        $types = array('Eloquent\Phony\Phpunit\Test\TestClassB', 'Countable');
        $actual = Phony::partialMock($types);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassB', $actual->get());
        $this->assertInstanceOf('Countable', $actual->get());
        $this->assertEquals(array(), $actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockDefaults()
    {
        $actual = Phony::partialMock();

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
    }

    public function testPartialMockFunction()
    {
        $types = array('Eloquent\Phony\Phpunit\Test\TestClassB', 'Countable');
        $arguments = new Arguments(array('a', 'b'));
        $actual = partialMock($types, $arguments);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassB', $actual->get());
        $this->assertInstanceOf('Countable', $actual->get());
        $this->assertSame(array('a', 'b'), $actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockFunctionWithNullArguments()
    {
        $types = array('Eloquent\Phony\Phpunit\Test\TestClassB', 'Countable');
        $arguments = null;
        $actual = partialMock($types, $arguments);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassB', $actual->get());
        $this->assertInstanceOf('Countable', $actual->get());
        $this->assertNull($actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockFunctionWithNoArguments()
    {
        $types = array('Eloquent\Phony\Phpunit\Test\TestClassB', 'Countable');
        $actual = partialMock($types);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassB', $actual->get());
        $this->assertInstanceOf('Countable', $actual->get());
        $this->assertEquals(array(), $actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockFunctionDefaults()
    {
        $actual = partialMock();

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
    }

    public function testMock()
    {
        $types = array('Eloquent\Phony\Phpunit\Test\TestClassB', 'Countable');
        $actual = Phony::mock($types);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassB', $actual->get());
        $this->assertInstanceOf('Countable', $actual->get());
        $this->assertNull($actual->get()->constructorArguments);
        $this->assertNull($actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testMockFunction()
    {
        $types = array('Eloquent\Phony\Phpunit\Test\TestClassB', 'Countable');
        $actual = mock($types);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Mock\Mock', $actual->get());
        $this->assertInstanceOf('Eloquent\Phony\Phpunit\Test\TestClassB', $actual->get());
        $this->assertInstanceOf('Countable', $actual->get());
        $this->assertNull($actual->get()->constructorArguments);
        $this->assertNull($actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testOnStatic()
    {
        $class = Phony::mockBuilder()->build();
        $actual = Phony::onStatic($class);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\StaticHandle', $actual);
        $this->assertSame($class, $actual->clazz());
    }

    public function testOnStaticFunction()
    {
        $class = mockBuilder()->build();
        $actual = onStatic($class);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\StaticHandle', $actual);
        $this->assertSame($class, $actual->clazz());
    }

    public function testOn()
    {
        $mock = Phony::mockBuilder()->partial();
        $actual = Phony::on($mock);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertSame($mock, $actual->get());
    }

    public function testOnFunction()
    {
        $mock = mockBuilder()->partial();
        $actual = on($mock);

        $this->assertInstanceOf('Eloquent\Phony\Mock\Handle\InstanceHandle', $actual);
        $this->assertSame($mock, $actual->get());
    }

    public function testSpy()
    {
        $callback = function () {};
        $actual = Phony::spy($callback);

        $this->assertInstanceOf('Eloquent\Phony\Spy\SpyVerifier', $actual);
        $this->assertSame($callback, $actual->callback());
        $this->assertSpyAssertionRecorder($actual);
    }

    public function testSpyFunction()
    {
        $callback = function () {};
        $actual = spy($callback);

        $this->assertInstanceOf('Eloquent\Phony\Spy\SpyVerifier', $actual);
        $this->assertSame($callback, $actual->callback());
        $this->assertSpyAssertionRecorder($actual);
    }

    public function testSpyGlobal()
    {
        $actual = Phony::spyGlobal('sprintf', 'Eloquent\Phony\Phpunit\Facade');

        $this->assertInstanceOf('Eloquent\Phony\Spy\SpyVerifier', $actual);
        $this->assertSame('a, b', \Eloquent\Phony\Phpunit\Facade\sprintf('%s, %s', 'a', 'b'));
        $this->assertTrue((bool) $actual->calledWith('%s, %s', 'a', 'b'));
    }

    public function testSpyGlobalFunction()
    {
        $actual = spyGlobal('vsprintf', 'Eloquent\Phony\Phpunit\Facade');

        $this->assertInstanceOf('Eloquent\Phony\Spy\SpyVerifier', $actual);
        $this->assertSame('a, b', \Eloquent\Phony\Phpunit\Facade\vsprintf('%s, %s', array('a', 'b')));
        $this->assertTrue((bool) $actual->calledWith('%s, %s', array('a', 'b')));
    }

    public function testStub()
    {
        $callback = function () { return 'a'; };
        $actual = Phony::stub($callback);

        $this->assertInstanceOf('Eloquent\Phony\Stub\StubVerifier', $actual);
        $this->assertSame('a', call_user_func($actual->stub()->callback()));
        $this->assertSame($actual->stub(), $actual->spy()->callback());
        $this->assertStubAssertionRecorder($actual);
    }

    public function testStubFunction()
    {
        $callback = function () { return 'a'; };
        $actual = stub($callback);

        $this->assertInstanceOf('Eloquent\Phony\Stub\StubVerifier', $actual);
        $this->assertSame('a', call_user_func($actual->stub()->callback()));
        $this->assertSame($actual->stub(), $actual->spy()->callback());
        $this->assertStubAssertionRecorder($actual);
    }

    public function testStubGlobal()
    {
        $actual = Phony::stubGlobal('sprintf', 'Eloquent\Phony\Phpunit\Facade');
        $actual->with('%s, %s', 'a', 'b')->forwards();

        $this->assertInstanceOf('Eloquent\Phony\Stub\StubVerifier', $actual);
        $this->assertSame('a, b', \Eloquent\Phony\Phpunit\Facade\sprintf('%s, %s', 'a', 'b'));
        $this->assertNull(\Eloquent\Phony\Phpunit\Facade\sprintf('x', 'y'));
        $this->assertTrue((bool) $actual->calledWith('%s, %s', 'a', 'b'));
    }

    public function testStubGlobalFunction()
    {
        $actual = stubGlobal('vsprintf', 'Eloquent\Phony\Phpunit\Facade');
        $actual->with('%s, %s', array('a', 'b'))->forwards();

        $this->assertInstanceOf('Eloquent\Phony\Stub\StubVerifier', $actual);
        $this->assertSame('a, b', \Eloquent\Phony\Phpunit\Facade\vsprintf('%s, %s', array('a', 'b')));
        $this->assertNull(\Eloquent\Phony\Phpunit\Facade\vsprintf('x', 'y'));
        $this->assertTrue((bool) $actual->calledWith('%s, %s', array('a', 'b')));
    }

    public function testRestoreGlobalFunctions()
    {
        Phony::stubGlobal('sprintf', 'Eloquent\Phony\Phpunit\Facade');
        Phony::stubGlobal('vsprintf', 'Eloquent\Phony\Phpunit\Facade');

        $this->assertNull(\Eloquent\Phony\Phpunit\Facade\sprintf('%s, %s', 'a', 'b'));
        $this->assertNull(\Eloquent\Phony\Phpunit\Facade\vsprintf('%s, %s', array('a', 'b')));

        Phony::restoreGlobalFunctions();

        $this->assertSame('a, b', \Eloquent\Phony\Phpunit\Facade\sprintf('%s, %s', 'a', 'b'));
        $this->assertSame('a, b', \Eloquent\Phony\Phpunit\Facade\vsprintf('%s, %s', array('a', 'b')));
    }

    public function testRestoreGlobalFunctionsFunction()
    {
        stubGlobal('sprintf', 'Eloquent\Phony\Phpunit\Facade');
        stubGlobal('vsprintf', 'Eloquent\Phony\Phpunit\Facade');

        $this->assertNull(\Eloquent\Phony\Phpunit\Facade\sprintf('%s, %s', 'a', 'b'));
        $this->assertNull(\Eloquent\Phony\Phpunit\Facade\vsprintf('%s, %s', array('a', 'b')));

        restoreGlobalFunctions();

        $this->assertSame('a, b', \Eloquent\Phony\Phpunit\Facade\sprintf('%s, %s', 'a', 'b'));
        $this->assertSame('a, b', \Eloquent\Phony\Phpunit\Facade\vsprintf('%s, %s', array('a', 'b')));
    }

    public function testEventOrderMethods()
    {
        $this->assertTrue((bool) Phony::checkInOrder($this->eventA, $this->eventB));
        $this->assertFalse((bool) Phony::checkInOrder($this->eventB, $this->eventA));

        $result = Phony::inOrder($this->eventA, $this->eventB);

        $this->assertInstanceOf('Eloquent\Phony\Event\EventSequence', $result);
        $this->assertEquals(array($this->eventA, $this->eventB), $result->allEvents());

        $this->assertTrue((bool) Phony::checkInOrderSequence(array($this->eventA, $this->eventB)));
        $this->assertFalse((bool) Phony::checkInOrderSequence(array($this->eventB, $this->eventA)));

        $result = Phony::inOrderSequence(array($this->eventA, $this->eventB));

        $this->assertInstanceOf('Eloquent\Phony\Event\EventSequence', $result);
        $this->assertEquals(array($this->eventA, $this->eventB), $result->allEvents());

        $this->assertTrue((bool) Phony::checkAnyOrder($this->eventA, $this->eventB));
        $this->assertFalse((bool) Phony::checkAnyOrder());

        $result = Phony::anyOrder($this->eventA, $this->eventB);

        $this->assertInstanceOf('Eloquent\Phony\Event\EventSequence', $result);
        $this->assertEquals(array($this->eventA, $this->eventB), $result->allEvents());

        $this->assertTrue((bool) Phony::checkAnyOrderSequence(array($this->eventA, $this->eventB)));
        $this->assertFalse((bool) Phony::checkAnyOrderSequence(array()));
        $this->assertFalse((bool) Phony::checkAnyOrder());

        $result = Phony::anyOrderSequence(array($this->eventA, $this->eventB));

        $this->assertInstanceOf('Eloquent\Phony\Event\EventSequence', $result);
        $this->assertEquals(array($this->eventA, $this->eventB), $result->allEvents());
    }

    public function testInOrderMethodFailure()
    {
        $this->expectException('PHPUnit\Framework\AssertionFailedError');
        Phony::inOrder($this->eventB, $this->eventA);
    }

    public function testInOrderSequenceMethodFailure()
    {
        $this->expectException('PHPUnit\Framework\AssertionFailedError');
        Phony::inOrderSequence(array($this->eventB, $this->eventA));
    }

    public function testEventOrderFunctions()
    {
        $this->assertTrue((bool) checkInOrder($this->eventA, $this->eventB));
        $this->assertFalse((bool) checkInOrder($this->eventB, $this->eventA));

        $result = inOrder($this->eventA, $this->eventB);

        $this->assertInstanceOf('Eloquent\Phony\Event\EventSequence', $result);
        $this->assertEquals(array($this->eventA, $this->eventB), $result->allEvents());

        $this->assertTrue((bool) checkInOrderSequence(array($this->eventA, $this->eventB)));
        $this->assertFalse((bool) checkInOrderSequence(array($this->eventB, $this->eventA)));

        $result = inOrderSequence(array($this->eventA, $this->eventB));

        $this->assertInstanceOf('Eloquent\Phony\Event\EventSequence', $result);
        $this->assertEquals(array($this->eventA, $this->eventB), $result->allEvents());

        $this->assertTrue((bool) checkAnyOrder($this->eventA, $this->eventB));
        $this->assertFalse((bool) checkAnyOrder());

        $result = anyOrder($this->eventA, $this->eventB);

        $this->assertInstanceOf('Eloquent\Phony\Event\EventSequence', $result);
        $this->assertEquals(array($this->eventA, $this->eventB), $result->allEvents());

        $this->assertTrue((bool) checkAnyOrderSequence(array($this->eventA, $this->eventB)));
        $this->assertFalse((bool) checkAnyOrderSequence(array()));
        $this->assertFalse((bool) checkAnyOrder());

        $result = anyOrderSequence(array($this->eventA, $this->eventB));

        $this->assertInstanceOf('Eloquent\Phony\Event\EventSequence', $result);
        $this->assertEquals(array($this->eventA, $this->eventB), $result->allEvents());
    }

    public function testInOrderFunctionFailure()
    {
        $this->expectException('PHPUnit\Framework\AssertionFailedError');
        inOrder($this->eventB, $this->eventA);
    }

    public function testInOrderSequenceFunctionFailure()
    {
        $this->expectException('PHPUnit\Framework\AssertionFailedError');
        inOrderSequence(array($this->eventB, $this->eventA));
    }

    public function testAny()
    {
        $actual = Phony::any();

        $this->assertInstanceOf('Eloquent\Phony\Matcher\AnyMatcher', $actual);
    }

    public function testAnyFunction()
    {
        $actual = any();

        $this->assertInstanceOf('Eloquent\Phony\Matcher\AnyMatcher', $actual);
    }

    public function testEqualTo()
    {
        $actual = Phony::equalTo('a');

        $this->assertInstanceOf('Eloquent\Phony\Matcher\EqualToMatcher', $actual);
        $this->assertSame('a', $actual->value());
    }

    public function testEqualToFunction()
    {
        $actual = equalTo('a');

        $this->assertInstanceOf('Eloquent\Phony\Matcher\EqualToMatcher', $actual);
        $this->assertSame('a', $actual->value());
    }

    public function testWildcard()
    {
        $actual = Phony::wildcard('a', 1, 2);

        $this->assertInstanceOf('Eloquent\Phony\Matcher\WildcardMatcher', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Matcher\EqualToMatcher', $actual->matcher());
        $this->assertSame('a', $actual->matcher()->value());
        $this->assertSame(1, $actual->minimumArguments());
        $this->assertSame(2, $actual->maximumArguments());
    }

    public function testWildcardFunction()
    {
        $actual = wildcard('a', 1, 2);

        $this->assertInstanceOf('Eloquent\Phony\Matcher\WildcardMatcher', $actual);
        $this->assertInstanceOf('Eloquent\Phony\Matcher\EqualToMatcher', $actual->matcher());
        $this->assertSame('a', $actual->matcher()->value());
        $this->assertSame(1, $actual->minimumArguments());
        $this->assertSame(2, $actual->maximumArguments());
    }

    public function testMatcherIntegration()
    {
        $spy = spy();
        $spy('a');

        $this->assertTrue((bool) $spy->checkCalledWith($this->identicalTo('a')));
    }

    public function testSetExportDepth()
    {
        $this->assertSame(1, Phony::setExportDepth(111));
        $this->assertSame(111, Phony::setExportDepth(1));
    }

    public function testSetExportDepthFunction()
    {
        $this->assertSame(1, setExportDepth(111));
        $this->assertSame(111, setExportDepth(1));
    }

    public function testSetUseColor()
    {
        $this->assertNull(Phony::setUseColor(false));
    }

    public function testSetUseColorFunction()
    {
        $this->assertNull(setUseColor(false));
    }

    private function assertSpyAssertionRecorder($spy)
    {
        $reflector = new ReflectionObject($spy);
        $property = $reflector->getProperty('callVerifierFactory');
        $property->setAccessible(true);

        $callVerifierFactory = $property->getValue($spy);

        $reflector = new ReflectionObject($callVerifierFactory);
        $property = $reflector->getProperty('assertionRecorder');
        $property->setAccessible(true);

        $assertionRecorder = $property->getValue($callVerifierFactory);

        $this->assertInstanceOf('Eloquent\Phony\Phpunit\PhpunitAssertionRecorder', $assertionRecorder);
    }

    private function assertStubAssertionRecorder($stub)
    {
        $reflector = new ReflectionObject($stub);
        $property = $reflector->getParentClass()->getProperty('callVerifierFactory');
        $property->setAccessible(true);

        $callVerifierFactory = $property->getValue($stub);

        $reflector = new ReflectionObject($callVerifierFactory);
        $property = $reflector->getProperty('assertionRecorder');
        $property->setAccessible(true);

        $assertionRecorder = $property->getValue($callVerifierFactory);

        $this->assertInstanceOf('Eloquent\Phony\Phpunit\PhpunitAssertionRecorder', $assertionRecorder);
    }
}
