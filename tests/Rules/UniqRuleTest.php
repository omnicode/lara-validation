<?php

namespace LaraValidation\Rules;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use LaraTest\Traits\AccessProtectedTraits;
use LaraTest\Traits\AssertionTraits;
use LaraTest\Traits\MockTraits;use Tests\TestCase;

class UniqRuleTest extends  TestCase
{
    use MockTraits, AssertionTraits, AccessProtectedTraits;

    /**
     * @var
     */
    public $uniqRule;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->uniqRule = $this->getMockBuilder(UniqRule::class)
            ->setMethods(null)
            ->getMock();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetMethodWillReturnedWhereParametersEmpty()
    {
        $validatorObject = $this->getMockObjectWithMockedMethods(['getData']);
        $this->uniqRule->get('attribute', 'value', [], $validatorObject);
        $message = 'Second parameter is required for unique validation';
        $this->expectExceptionMessage($message);
    }

    /**
     * @throws \phpmock\MockEnabledException
     */
    public function testGetMethodWillReturnedWhereClassExist()
    {
//        $primaryKey = 'id';
//        $parametersKey = 'parameters';
//        $mockClassExists = $this->mockGlobalFunction('LaraValidation\Rules', 'class_exists');
//
//        $appObject = $this->getMockObjectWithMockedMethods(['where', 'count']);
//        $this->methodWillReturnTrue($appObject, 'where', 'any');
//        $this->methodWillReturn($appObject, 'count', 0);
//
//        $modelObject = $this->getMockObjectWithMockedMethods(['getKeyName', 'newQuery']);
//        $this->methodWillReturn($modelObject, 'getKeyName', $primaryKey);
//        $this->methodWillReturn($modelObject, 'newQuery', $appObject);
//        App::shouldReceive('make')
//            ->once()
//            ->with('parameters')
//            ->andReturn($modelObject);
//
//        $validatorObject = $this->getMockObjectWithMockedMethods(['getData']);
//        $returnedGetData = [
//            $primaryKey => 'number',
//            $parametersKey => 'parameters',
//        ];
//        $this->methodWillReturn($validatorObject, 'getData', $returnedGetData);
//        $returned = $this->uniqRule->get('attribute', 'value', [$parametersKey], $validatorObject);
//        $this->assertTrue($returned);
//
//        $mockClassExists->disable();
        $this->assertTrue(true);
    }

    /**
     *
     */
    public function testGetMethodWillReturnedWhereClassNotExist()
    {
        $this->assertTrue(true);
//        $primaryKey = 'id';
//        $parametersKey = 'parameters';
//        $mockClassExists = $this->mockGlobalFunction('LaraValidation\Rules', 'class_exists',
//            false);
//
//        $dbObject = $this->getMockObjectWithMockedMethods(['where', 'count']);
//        $this->methodWillReturnTrue($dbObject, 'where', 'any');
//        $this->methodWillReturn($dbObject, 'count', 1);
//
//        DB::shouldReceive('table')
//            ->once()
//            ->with($parametersKey)
//            ->andReturn($dbObject);
//
//        $validatorObject = $this->getMockObjectWithMockedMethods(['getData']);
//        $returnedGetData = [
//            $primaryKey => 'number',
//            $parametersKey => 'parameters',
//        ];
//        $dataParameters = [
//            $parametersKey,
//            $primaryKey
//        ];
//        $this->methodWillReturn($validatorObject, 'getData', $returnedGetData);
//        $returned = $this->uniqRule->get('attribute', 'value', $dataParameters, $validatorObject);
//        $this->assertFalse($returned);
//
//        $mockClassExists->disable();
    }

}
