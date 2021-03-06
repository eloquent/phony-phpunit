<?php

declare(strict_types=1);

namespace Eloquent\Phony\Phpunit;

use Countable;
use Eloquent\Phony\Call\Arguments;
use Eloquent\Phony\Event\EventSequence;
use Eloquent\Phony\Matcher\AnyMatcher;
use Eloquent\Phony\Matcher\EqualToMatcher;
use Eloquent\Phony\Matcher\InstanceOfMatcher;
use Eloquent\Phony\Matcher\MatcherFactory;
use Eloquent\Phony\Matcher\WildcardMatcher;
use Eloquent\Phony\Mock\Builder\MockBuilder;
use Eloquent\Phony\Mock\Handle\InstanceHandle;
use Eloquent\Phony\Mock\Handle\StaticHandle;
use Eloquent\Phony\Mock\Mock;
use Eloquent\Phony\Phpunit\Facade as TestNamespace;
use Eloquent\Phony\Phpunit\Test\TestClassA;
use Eloquent\Phony\Phpunit\Test\TestClassB;
use Eloquent\Phony\Phpunit\Test\TestEvent;
use Eloquent\Phony\Spy\SpyVerifier;
use Eloquent\Phony\Stub\StubVerifier;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionObject;

class PhonyTest extends TestCase
{
    protected function setUp(): void
    {
        $this->matcherFactory = MatcherFactory::instance();

        $this->eventA = new TestEvent(0, 0.0);
        $this->eventB = new TestEvent(1, 1.0);
    }

    public function testMockBuilder(): void
    {
        $actual = Phony::mockBuilder(TestClassA::class);

        $this->assertInstanceOf(MockBuilder::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassA::class, $actual->get());
    }

    public function testMockBuilderFunction(): void
    {
        $actual = mockBuilder(TestClassA::class);

        $this->assertInstanceOf(MockBuilder::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassA::class, $actual->get());
    }

    public function testPartialMock(): void
    {
        $actual = Phony::partialMock([TestClassB::class, Countable::class], new Arguments(['a', 'b']));

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassB::class, $actual->get());
        $this->assertInstanceOf(Countable::class, $actual->get());
        $this->assertSame(['a', 'b'], $actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockWithNullArguments(): void
    {
        $actual = Phony::partialMock([TestClassB::class, Countable::class], null);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassB::class, $actual->get());
        $this->assertInstanceOf(Countable::class, $actual->get());
        $this->assertNull($actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockWithNoArguments(): void
    {
        $actual = Phony::partialMock([TestClassB::class, Countable::class]);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassB::class, $actual->get());
        $this->assertInstanceOf(Countable::class, $actual->get());
        $this->assertEquals([], $actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockDefaults(): void
    {
        $actual = Phony::partialMock();

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
    }

    public function testPartialMockFunction(): void
    {
        $actual = partialMock([TestClassB::class, Countable::class], ['a', 'b']);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassB::class, $actual->get());
        $this->assertInstanceOf(Countable::class, $actual->get());
        $this->assertSame(['a', 'b'], $actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockFunctionWithNullArguments(): void
    {
        $actual = partialMock([TestClassB::class, Countable::class], null);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassB::class, $actual->get());
        $this->assertInstanceOf(Countable::class, $actual->get());
        $this->assertNull($actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockFunctionWithNoArguments(): void
    {
        $actual = partialMock([TestClassB::class, Countable::class]);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassB::class, $actual->get());
        $this->assertInstanceOf(Countable::class, $actual->get());
        $this->assertEquals([], $actual->get()->constructorArguments);
        $this->assertSame('ab', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testPartialMockFunctionDefaults(): void
    {
        $actual = partialMock();

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
    }

    public function testMock(): void
    {
        $actual = Phony::mock([TestClassB::class, Countable::class]);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassB::class, $actual->get());
        $this->assertInstanceOf(Countable::class, $actual->get());
        $this->assertNull($actual->get()->constructorArguments);
        $this->assertSame('', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testMockFunction(): void
    {
        $actual = mock([TestClassB::class, Countable::class]);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertInstanceOf(Mock::class, $actual->get());
        $this->assertInstanceOf(TestClassB::class, $actual->get());
        $this->assertInstanceOf(Countable::class, $actual->get());
        $this->assertNull($actual->get()->constructorArguments);
        $this->assertSame('', $actual->get()->testClassAMethodA('a', 'b'));
    }

    public function testOnStatic(): void
    {
        $class = Phony::mockBuilder()->build();
        $actual = Phony::onStatic($class);

        $this->assertInstanceOf(StaticHandle::class, $actual);
        $this->assertSame($class, $actual->class());
    }

    public function testOnStaticFunction(): void
    {
        $class = mockBuilder()->build();
        $actual = onStatic($class);

        $this->assertInstanceOf(StaticHandle::class, $actual);
        $this->assertSame($class, $actual->class());
    }

    public function testOn(): void
    {
        $mock = Phony::mockBuilder()->partial();
        $actual = Phony::on($mock);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertSame($mock, $actual->get());
    }

    public function testOnFunction(): void
    {
        $mock = mockBuilder()->partial();
        $actual = on($mock);

        $this->assertInstanceOf(InstanceHandle::class, $actual);
        $this->assertSame($mock, $actual->get());
    }

    public function testSpy(): void
    {
        $callback = function () {};
        $actual = Phony::spy($callback);

        $this->assertInstanceOf(SpyVerifier::class, $actual);
        $this->assertSame($callback, $actual->callback());
        $this->assertSpyAssertionRecorder($actual);
    }

    public function testSpyFunction(): void
    {
        $callback = function () {};
        $actual = spy($callback);

        $this->assertInstanceOf(SpyVerifier::class, $actual);
        $this->assertSame($callback, $actual->callback());
        $this->assertSpyAssertionRecorder($actual);
    }

    public function testSpyGlobal(): void
    {
        $actual = Phony::spyGlobal('sprintf', TestNamespace::class);

        $this->assertInstanceOf(SpyVerifier::class, $actual);
        $this->assertSame('a, b', TestNamespace\sprintf('%s, %s', 'a', 'b'));
        $this->assertTrue((bool) $actual->calledWith('%s, %s', 'a', 'b'));
    }

    public function testSpyGlobalFunction(): void
    {
        $actual = spyGlobal('vsprintf', TestNamespace::class);

        $this->assertInstanceOf(SpyVerifier::class, $actual);
        $this->assertSame('a, b', TestNamespace\vsprintf('%s, %s', ['a', 'b']));
        $this->assertTrue((bool) $actual->calledWith('%s, %s', ['a', 'b']));
    }

    public function testStub(): void
    {
        $callback = function () { return 'a'; };
        $actual = Phony::stub($callback);
        /** @var callable */
        $actualStubCallback = $actual->stub()->callback();

        $this->assertInstanceOf(StubVerifier::class, $actual);
        $this->assertSame('a', call_user_func($actualStubCallback));
        $this->assertSame($actual->stub(), $actual->spy()->callback());
        $this->assertStubAssertionRecorder($actual);
    }

    public function testStubFunction(): void
    {
        $callback = function () { return 'a'; };
        $actual = stub($callback);
        /** @var callable */
        $actualStubCallback = $actual->stub()->callback();

        $this->assertInstanceOf(StubVerifier::class, $actual);
        $this->assertSame('a', call_user_func($actualStubCallback));
        $this->assertSame($actual->stub(), $actual->spy()->callback());
        $this->assertStubAssertionRecorder($actual);
    }

    public function testStubGlobal(): void
    {
        $actual = Phony::stubGlobal('sprintf', TestNamespace::class);
        $actual->with('%s, %s', 'a', 'b')->forwards();

        $this->assertInstanceOf(StubVerifier::class, $actual);
        $this->assertSame('a, b', TestNamespace\sprintf('%s, %s', 'a', 'b'));
        $this->assertEmpty(TestNamespace\sprintf('x', 'y'));
        $this->assertTrue((bool) $actual->calledWith('%s, %s', 'a', 'b'));
    }

    public function testStubGlobalFunction(): void
    {
        $actual = stubGlobal('vsprintf', TestNamespace::class);
        $actual->with('%s, %s', ['a', 'b'])->forwards();

        $this->assertInstanceOf(StubVerifier::class, $actual);
        $this->assertSame('a, b', TestNamespace\vsprintf('%s, %s', ['a', 'b']));
        $this->assertEmpty(TestNamespace\vsprintf('x', ['y']));
        $this->assertTrue((bool) $actual->calledWith('%s, %s', ['a', 'b']));
    }

    public function testRestoreGlobalFunctions(): void
    {
        Phony::stubGlobal('sprintf', TestNamespace::class);
        Phony::stubGlobal('vsprintf', TestNamespace::class);

        $this->assertEmpty(TestNamespace\sprintf('%s, %s', 'a', 'b'));
        $this->assertEmpty(TestNamespace\vsprintf('%s, %s', ['a', 'b']));

        Phony::restoreGlobalFunctions();

        $this->assertSame('a, b', TestNamespace\sprintf('%s, %s', 'a', 'b'));
        $this->assertSame('a, b', TestNamespace\vsprintf('%s, %s', ['a', 'b']));
    }

    public function testRestoreGlobalFunctionsFunction(): void
    {
        stubGlobal('sprintf', TestNamespace::class);
        stubGlobal('vsprintf', TestNamespace::class);

        $this->assertEmpty(TestNamespace\sprintf('%s, %s', 'a', 'b'));
        $this->assertEmpty(TestNamespace\vsprintf('%s, %s', ['a', 'b']));

        restoreGlobalFunctions();

        $this->assertSame('a, b', TestNamespace\sprintf('%s, %s', 'a', 'b'));
        $this->assertSame('a, b', TestNamespace\vsprintf('%s, %s', ['a', 'b']));
    }

    public function testEventOrderMethods(): void
    {
        $this->assertTrue((bool) Phony::checkInOrder($this->eventA, $this->eventB));
        $this->assertFalse((bool) Phony::checkInOrder($this->eventB, $this->eventA));

        $result = Phony::inOrder($this->eventA, $this->eventB);

        $this->assertInstanceOf(EventSequence::class, $result);
        $this->assertEquals([$this->eventA, $this->eventB], $result->allEvents());

        $this->assertTrue((bool) Phony::checkAnyOrder($this->eventA, $this->eventB));
        $this->assertFalse((bool) Phony::checkAnyOrder());

        $result = Phony::anyOrder($this->eventA, $this->eventB);

        $this->assertInstanceOf(EventSequence::class, $result);
        $this->assertEquals([$this->eventA, $this->eventB], $result->allEvents());

        $this->assertFalse((bool) Phony::checkAnyOrder());
    }

    public function testInOrderMethodFailure(): void
    {
        $this->expectException(AssertionFailedError::class);
        Phony::inOrder($this->eventB, $this->eventA);
    }

    public function testEventOrderFunctions(): void
    {
        $this->assertTrue((bool) checkInOrder($this->eventA, $this->eventB));
        $this->assertFalse((bool) checkInOrder($this->eventB, $this->eventA));

        $result = inOrder($this->eventA, $this->eventB);

        $this->assertInstanceOf(EventSequence::class, $result);
        $this->assertEquals([$this->eventA, $this->eventB], $result->allEvents());

        $this->assertTrue((bool) checkAnyOrder($this->eventA, $this->eventB));
        $this->assertFalse((bool) checkAnyOrder());

        $result = anyOrder($this->eventA, $this->eventB);

        $this->assertInstanceOf(EventSequence::class, $result);
        $this->assertEquals([$this->eventA, $this->eventB], $result->allEvents());

        $this->assertFalse((bool) checkAnyOrder());
    }

    public function testInOrderFunctionFailure(): void
    {
        $this->expectException(AssertionFailedError::class);
        inOrder($this->eventB, $this->eventA);
    }

    public function testAny(): void
    {
        $actual = Phony::any();

        $this->assertInstanceOf(AnyMatcher::class, $actual);
    }

    public function testAnyFunction(): void
    {
        $actual = any();

        $this->assertInstanceOf(AnyMatcher::class, $actual);
    }

    public function testEqualTo(): void
    {
        $actual = Phony::equalTo('a');

        $this->assertInstanceOf(EqualToMatcher::class, $actual);
        $this->assertSame('a', $actual->value());
    }

    public function testEqualToFunction(): void
    {
        $actual = equalTo('a');

        $this->assertInstanceOf(EqualToMatcher::class, $actual);
        $this->assertSame('a', $actual->value());
    }

    public function testAnInstanceOf(): void
    {
        $actual = Phony::anInstanceOf(TestClassA::class);

        $this->assertInstanceOf(InstanceOfMatcher::class, $actual);
        $this->assertSame(TestClassA::class, $actual->type());
    }

    public function testAnInstanceOfFunction(): void
    {
        $actual = anInstanceOf(TestClassA::class);

        $this->assertInstanceOf(InstanceOfMatcher::class, $actual);
        $this->assertSame(TestClassA::class, $actual->type());
    }

    public function testWildcard(): void
    {
        $actual = Phony::wildcard('a', 1, 2);

        $this->assertInstanceOf(WildcardMatcher::class, $actual);
        $this->assertInstanceOf(EqualToMatcher::class, $actual->matcher());
        $this->assertSame('a', $actual->matcher()->value());
        $this->assertSame(1, $actual->minimumArguments());
        $this->assertSame(2, $actual->maximumArguments());
    }

    public function testWildcardFunction(): void
    {
        $actual = wildcard('a', 1, 2);

        $this->assertInstanceOf(WildcardMatcher::class, $actual);
        $this->assertInstanceOf(EqualToMatcher::class, $actual->matcher());
        $this->assertSame('a', $actual->matcher()->value());
        $this->assertSame(1, $actual->minimumArguments());
        $this->assertSame(2, $actual->maximumArguments());
    }

    public function testMatcherIntegration(): void
    {
        $spy = spy();
        $spy('a');

        $this->assertTrue((bool) $spy->checkCalledWith($this->identicalTo('a')));
    }

    public function testSetExportDepth(): void
    {
        $this->assertSame(1, Phony::setExportDepth(111));
        $this->assertSame(111, Phony::setExportDepth(1));
    }

    public function testSetExportDepthFunction(): void
    {
        $this->assertSame(1, setExportDepth(111));
        $this->assertSame(111, setExportDepth(1));
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSetUseColor(): void
    {
        Phony::setUseColor(false);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSetUseColorFunction(): void
    {
        setUseColor(false);
    }

    private function assertSpyAssertionRecorder(SpyVerifier $spy): void
    {
        $reflector = new ReflectionObject($spy);
        $property = $reflector->getProperty('callVerifierFactory');
        $property->setAccessible(true);

        $callVerifierFactory = $property->getValue($spy);

        $reflector = new ReflectionObject($callVerifierFactory);
        $property = $reflector->getProperty('assertionRecorder');
        $property->setAccessible(true);

        $assertionRecorder = $property->getValue($callVerifierFactory);

        $this->assertInstanceOf(AssertionRecorder::class, $assertionRecorder);
    }

    private function assertStubAssertionRecorder(StubVerifier $stub): void
    {
        $reflector = new ReflectionObject($stub);
        /** @var ReflectionClass<SpyVerifier> */
        $parentClass = $reflector->getParentClass();
        $property = $parentClass->getProperty('callVerifierFactory');
        $property->setAccessible(true);

        $callVerifierFactory = $property->getValue($stub);

        $reflector = new ReflectionObject($callVerifierFactory);
        $property = $reflector->getProperty('assertionRecorder');
        $property->setAccessible(true);

        $assertionRecorder = $property->getValue($callVerifierFactory);

        $this->assertInstanceOf(AssertionRecorder::class, $assertionRecorder);
    }
}
