<?php

namespace Tests;

use LaraTest\Traits\AccessProtectedTraits;
use LaraTest\Traits\AssertionTraits;
use LaraTest\Traits\MockTraits;
use LaraValidation\CoreValidator;
use LaraValidation\LaraValidator;

class LaraValidatorTest extends TestCase
{
    use MockTraits, AssertionTraits, AccessProtectedTraits;

    /**
     * @var
     */
    public $coreValidator;

    /**
     * @var
     */
    public $laraValidator;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->coreValidator = $this->getMockBuilder(CoreValidator::class)
            ->setMethods(null)
            ->getMock();

        $this->laraValidator = $this->getMockLaraValidator();
    }

    /**
     *
     */
    public function testIsValidWillReturnedWherePassesTrue()
    {
        $options = 'options';
        $laraValidator = $this->getMockLaraValidator(['validation' . $options, 'setErrors']);

        $objectValidate = $this->getMockObjectWithMockedMethods(['passes', 'errors']);
        $this->methodWillReturnFalse($objectValidate, 'passes');
        $this->methodWillReturnTrue($objectValidate, 'errors');

        $objectValidation = $this->getMockObjectWithMockedMethods(['validate']);
        $this->methodWillReturn($objectValidation, 'validate', $objectValidate);

        $this->methodWillReturn($laraValidator, 'validation' . $options, $objectValidation);

        $this->assertFalse($laraValidator->isValid([], $options));
    }

    /**
     *
     */
    public function testIsValidWillReturnedWherePassesFalse()
    {
        $options = 'options';
        $laraValidator = $this->getMockLaraValidator(['validation' . $options, 'setErrors']);

        $objectValidate = $this->getMockObjectWithMockedMethods(['passes']);
        $this->methodWillReturnTrue($objectValidate, 'passes');

        $objectValidation = $this->getMockObjectWithMockedMethods(['validate']);
        $this->methodWillReturn($objectValidation, 'validate', $objectValidate);
        $this->methodWillReturn($laraValidator, 'validation' . $options, $objectValidation);

        $this->assertTrue($laraValidator->isValid([], $options));
    }

    /**
     *
     */
    public function testIsValidWillReturnedException()
    {
        // $this->laraValidator->isValid([]);
        // ToDo
        $this->assertTrue(true);
    }

    /**
     * @param null $methods
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockLaraValidator($methods = null)
    {
        return $this->getMockBuilder(LaraValidator::class)
            ->setConstructorArgs([
                $this->coreValidator
            ])
            ->setMethods($methods)
            ->getMock();
    }

}
