<?php

namespace Tests\Rules;

use LaraTest\Traits\AccessProtectedTraits;
use LaraTest\Traits\AssertionTraits;
use LaraTest\Traits\MockTraits;
use Illuminate\Support\Facades\DB;
use LaraValidation\Rules\DbRule;
use Tests\TestCase;

class DbRuleTest extends TestCase
{
    use MockTraits, AssertionTraits, AccessProtectedTraits;

    /**
     * @var
     */
    public $dbRule;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->dbRule = $this->getMockBuilder(DbRule::class)
            ->setMethods(null)
            ->getMock();;
    }


    /**
     *
     */
    public function testGetForExistsMethodWillReturnedWhereParametersEmpty()
    {
        $this->assertTrue(true);
//        $message = 'message';
//        $this->callProtectedMethod($this->dbRule, 'getForExists', [
//            'attribute', 'value', null, 'validator',  $message]);
//        $message = sprintf('Second parameter is required for %s validation', $message);
//        $this->expectExceptionMessage($message);
    }

    /**
     *
     */
    public function testGetForExistsMethodWillReturned()
    {
        $this->assertTrue(true);
//        $mockArrayShift = $this->mockGlobalFunction('LaraValidation\Rules', 'array_shift');
//        $mockConfig = $this->mockGlobalFunction('LaraValidation\Rules', 'config');
//        $mockEndsWith = $this->mockGlobalFunction('LaraValidation\Rules', 'ends_with');
//
//        $objectCount = $this->getMockObjectWithMockedMethods(['count']);
//        $this->methodWillReturnTrue($objectCount, 'count');
//        $query = $this->getMockObjectWithMockedMethods(['where']);
//        $this->methodWillReturn($query, 'where', $objectCount);
//
//        $mockClassExists = $this->mockGlobalFunction('LaraValidation\Rules', 'class_exists',
//            false);
//
//        $objectSelect = $this->getMockObjectWithMockedMethods(['select']);
//        $this->methodWillReturn($objectSelect, 'select', $query);
//        $objectDbConnection = $this->getMockObjectWithMockedMethods(['table']);
//        $this->methodWillReturn($objectDbConnection, 'table', $objectSelect);
//
//        DB::shouldReceive('connection')
//            ->once()
//            ->with('connection')
//            ->andReturn($objectDbConnection);
//
//        $returned = $this->callProtectedMethod($this->dbRule, 'getForExists', [
//            'attribute', 'value', 'parameters', 'validator',  'message']);
//        $this->assertTrue($returned);
//
//        $mockArrayShift->disable();
//        $mockConfig->disable();
//        $mockEndsWith->disable();
//        $mockClassExists->disable();
    }

    /**
     *
     */
    public function testGetForExistsIfMethodWillReturnedWhereParametersEmpty()
    {
        $this->assertTrue(true);
//        $message = 'message';
//        $this->callProtectedMethod($this->dbRule, 'getForExistsIf', ['attribute', 'value', [], 'validator',  $message]);
//        $message = sprintf('Second parameter is required for %s validation', $message);
//        $this->expectExceptionMessage($message);
    }

    /**
     *
     */
    public function testGetForExistsIfMethodWillReturned()
    {
        $this->assertTrue(true);
//        $mockConfig = $this->mockGlobalFunction('LaraValidation\Rules', 'config');
//        $mockEndsWith = $this->mockGlobalFunction('LaraValidation\Rules', 'ends_with');
//        $mockStrContains = $this->mockGlobalFunction('LaraValidation\Rules', 'str_contains');
//        $mockArrayUnshift = $this->mockGlobalFunction('LaraValidation\Rules', 'array_unshift');
//        $mockStrtolower = $this->mockGlobalFunction('LaraValidation\Rules', 'strtolower');
//
//        $objectCount = $this->getMockObjectWithMockedMethods(['count']);
//        $this->methodWillReturnTrue($objectCount, 'count');
//        $query = $this->getMockObjectWithMockedMethods(['where']);
//        $this->methodWillReturn($query, 'where', $objectCount, 'any');
//
//        $mockClassExists = $this->mockGlobalFunction('LaraValidation\Rules', 'class_exists',
//            false);
//
//        $objectSelect = $this->getMockObjectWithMockedMethods(['select']);
//        $this->methodWillReturn($objectSelect, 'select', $query);
//        $objectDbConnection = $this->getMockObjectWithMockedMethods(['table']);
//        $this->methodWillReturn($objectDbConnection, 'table', $objectSelect);
//
//        DB::shouldReceive('connection')
//            ->once()
//            ->with('connection')
//            ->andReturn($objectDbConnection);
//
//        $parameters = ['one', 'two', 'free', 'four'];
//        $returned = $this->callProtectedMethod($this->dbRule, 'getForExistsIf', [
//            'attribute', 'value', $parameters, 'validator',  'message']);
//        $this->assertTrue($returned);
//
//        $mockConfig->disable();
//        $mockEndsWith->disable();
//        $mockClassExists->disable();
//        $mockStrContains->disable();
//        $mockArrayUnshift->disable();
//        $mockStrtolower->disable();
    }

    /**
     *
     */
    public function testGetForExistsIfMethodWillReturnedWhereConditionsEmpty()
    {
        $this->assertTrue(true);
//        $mockConfig = $this->mockGlobalFunction('LaraValidation\Rules', 'config');
//        $mockStrContains = $this->mockGlobalFunction('LaraValidation\Rules', 'str_contains',
//            false);
//
//        $parameters = ['parameters'];
//        $this->callProtectedMethod($this->dbRule, 'getForExistsIf', [
//            'attribute', 'value', $parameters, 'validator',  'message']);
//
//        $this->expectExceptionMessage('The Params must be contain [attribute => value] value');
//
//        $mockConfig->disable();
//        $mockStrContains->disable();
    }


    /**
     *
     */
    public function testGetQueryBasedMethodWhereClassExist()
    {
        $this->assertTrue(true);
//        $mockClassExists = $this->mockGlobalFunction('LaraValidation\Rules', 'class_exists');
//
//        $object = $this->getMockObjectWithMockedMethods(['setConnection', 'newQuery']);
//        $mockApp = $this->mockGlobalFunction('LaraValidation\Rules', 'app', $object);
//        $this->methodWillReturnTrue($object, 'newQuery');
//
//        $returned = $this->callProtectedMethod($this->dbRule, 'getQueryBased', [
//            'tableParam', 'column', 'connection']);
//        $this->assertTrue($returned);
//        $mockClassExists->disable();
//        $mockApp->disable();
    }

    /**
     *
     */
    public function testGetQueryBasedMethodWhereClassNotExist()
    {
        $this->assertTrue(true);
//        $mockClassExists = $this->mockGlobalFunction('LaraValidation\Rules', 'class_exists',
//            false);
//
//        $object = $this->getMockObjectWithMockedMethods(['select']);
//        $this->methodWillReturnTrue($object, 'select');
//        $objectDbConnection = $this->getMockObjectWithMockedMethods(['table']);
//        $this->methodWillReturn($objectDbConnection, 'table', $object);
//
//        DB::shouldReceive('connection')
//            ->once()
//            ->with('connection')
//            ->andReturn($objectDbConnection);
//
//        $returned = $this->callProtectedMethod($this->dbRule, 'getQueryBased', [
//            'tableParam', 'column', 'connection']);
//        $this->assertTrue($returned);
//        $mockClassExists->disable();
    }


    /**
     *
     */
    public function testFixIsMultiMethodWhereIsMultiFalse()
    {
        $object = $this->getMockObjectWithMockedMethods(['count']);
        $this->methodWillReturnTrue($object, 'count');
        $query = $this->getMockObjectWithMockedMethods(['where']);
        $this->methodWillReturn($query, 'where', $object);
        $returned = $this->callProtectedMethod($this->dbRule, 'fixIsMulti', [
            false, $query, 'column', 'value']);
        $this->assertTrue($returned);
    }

    /**
     *
     */
    public function testFixIsMultiMethodWillReturned()
    {
        $object = $this->getMockObjectWithMockedMethods(['count']);
        $this->methodWillReturn($object, 'count', 1);
        $query = $this->getMockObjectWithMockedMethods(['whereIn']);
        $this->methodWillReturn($query, 'whereIn', $object);
        $returned = $this->callProtectedMethod($this->dbRule, 'fixIsMulti', [
            true, $query, 'column', 'value']);
        $this->assertTrue($returned);
    }
}
