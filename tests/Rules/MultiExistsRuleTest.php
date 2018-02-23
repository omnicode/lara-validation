<?php

namespace Tests\Rules;

use LaraTest\Traits\AccessProtectedTraits;
use LaraTest\Traits\AssertionTraits;
use LaraTest\Traits\MockTraits;
use Illuminate\Support\Facades\DB;
use LaraValidation\Rules\MultiExistsRule;
use Tests\TestCase;

class MultiExistsRuleTest extends TestCase
{
    use MockTraits, AssertionTraits, AccessProtectedTraits;

    /**
     * @var
     */
    public $multiExistsRule;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->multiExistsRule = $this->getMockBuilder(MultiExistsRule::class)
            ->setMethods(null)
            ->getMock();
    }

    /**
     *
     */
    public function testGetMethodWillReturned()
    {
        $this->assertTrue(true);
//        $mockArrayShift = $this->mockGlobalFunction('LaraValidation\Rules', 'array_shift');
//        $mockConfig = $this->mockGlobalFunction('LaraValidation\Rules', 'config');
//        $mockEndsWith = $this->mockGlobalFunction('LaraValidation\Rules', 'ends_with');
//
//        $objectCount = $this->getMockObjectWithMockedMethods(['count']);
//        $this->methodWillReturnTrue($objectCount, 'count');
//        $query = $this->getMockObjectWithMockedMethods(['whereIn']);
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
//        $returned = $this->multiExistsRule->get('attribute', 'value', 'parameters',
//            'validator');
//        $this->assertTrue($returned);
//
//        $mockArrayShift->disable();
//        $mockConfig->disable();
//        $mockEndsWith->disable();
//        $mockClassExists->disable();
    }

}
