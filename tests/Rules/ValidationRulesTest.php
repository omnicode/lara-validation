<?php

namespace Tests\Rules;

use LaraTest\Traits\AccessProtectedTraits;
use LaraTest\Traits\AssertionTraits;
use LaraTest\Traits\MockTraits;
use LaraValidation\Rules\ValidationRules;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidationRulesTest extends TestCase
{
    use MockTraits, AssertionTraits, AccessProtectedTraits;

    /**
     * @var
     */
    public $validationRules;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->validationRules = $this->getMockBuilder(ValidationRules::class)
            ->setMethods(null)
            ->getMock();
    }

    /**
     *
     */
    public function testExecuteMethodWillReturned()
    {
        $params = [
            ['uniq', 'LaraValidation\Rules\UniqRule@get'],
            ['exists_db', 'LaraValidation\Rules\ExistsDbRule@get'],
            ['exists_if', 'LaraValidation\Rules\ExistsIfRule@get'],
            ['multi_exists', 'LaraValidation\Rules\MultiExistsRule@get'],
            ['multi_exists_if', 'LaraValidation\Rules\multiExistsIfRule@get'],
        ];

        foreach ($params as $param) {
            $this->getMockValidatorExtend(... $param);
        }

        $this->assertTrue($this->validationRules->execute());
    }

    /**
     * @param $paramOne
     * @param $paramTwo
     */
    protected function getMockValidatorExtend($paramOne, $paramTwo)
    {
        Validator::shouldReceive('extend')
            ->times()
            ->with($paramOne, $paramTwo)
            ->andReturn(true);
    }
}
