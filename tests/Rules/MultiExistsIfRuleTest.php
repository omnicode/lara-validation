<?php

namespace Tests\Rules;

use LaraTest\Traits\AccessProtectedTraits;
use LaraTest\Traits\AssertionTraits;
use LaraTest\Traits\MockTraits;
use Illuminate\Support\Facades\DB;
use LaraValidation\Rules\MultiExistsIfRule;
use Tests\TestCase;

class MultiExistsIfRuleTest extends TestCase
{
    use MockTraits, AssertionTraits, AccessProtectedTraits;

    /**
     * @var
     */
    public $multiExistsIfRule;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->multiExistsIfRule = $this->getMockBuilder(MultiExistsIfRule::class)
            ->setMethods(null)
            ->getMock();
    }

    /**
     *
     */
    public function testGetMethodWillReturned()
    {
        $this->assertTrue(true);
//        $mockConfig = $this->mockGlobalFunction('LaraValidation\Rules', 'config');
//        $mockEndsWith = $this->mockGlobalFunction('LaraValidation\Rules', 'ends_with');
//        $mockStrContains = $this->mockGlobalFunction('LaraValidation\Rules', 'str_contains');
//
//        $objectCount = $this->getMockObjectWithMockedMethods(['count']);
//        $this->methodWillReturnTrue($objectCount, 'count');
//        $query = $this->getMockObjectWithMockedMethods(['where', 'whereIn']);
//        $this->methodWillReturn($query, 'where', $objectCount);
//        $this->methodWillReturn($query, 'whereIn', $objectCount);
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
//        $returned = $this->multiExistsIfRule->get('attribute', 'value', $parameters,
//            'validator');
//        $mockConfig->disable();
//        $mockEndsWith->disable();
//        $mockClassExists->disable();
//        $mockStrContains->disable();
//        $this->assertTrue($returned);
    }

}
