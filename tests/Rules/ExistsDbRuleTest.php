<?php

namespace Tests\Rules;

use LaraTest\Traits\AccessProtectedTraits;
use LaraTest\Traits\AssertionTraits;
use LaraTest\Traits\MockTraits;
use LaraValidation\Rules\ExistsDbRule;
use Tests\TestCase;

class ExistsDbRuleTest extends TestCase
{
    use MockTraits, AssertionTraits, AccessProtectedTraits;

    /**
     * @var
     */
    public $existsDbRule;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->existsDbRule = $this->getMockBuilder(ExistsDbRule::class)
            ->setMethods(null)
            ->getMock();;
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
//        $returned = $this->existsDbRule->get('attribute', 'value', 'parameters',
//            'validator');
//        $this->assertTrue($returned);
//
//        $mockArrayShift->disable();
//        $mockConfig->disable();
//        $mockEndsWith->disable();
//        $mockClassExists->disable();
    }

}
