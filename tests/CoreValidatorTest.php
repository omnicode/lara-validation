<?php

namespace Tests;

use LaraTest\Traits\AccessProtectedTraits;
use LaraTest\Traits\AssertionTraits;
use LaraTest\Traits\MockTraits;
use LaraValidation\CoreValidator;

class CoreValidatorTest extends TestCase
{
    use MockTraits, AssertionTraits, AccessProtectedTraits;

    /**
     * @var
     */
    public $coreValidator;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->coreValidator = $this->getMockCoreValidator([
            'add',
            'rules',
            'messages',
            'fixMultiRuleStructure',
            'fixRuleStructure',
            'getTextLength',
            'bail',
            'addStringMethodRule',
            'fixDbIfRuleStructure'
        ]);
    }

    /**
     *
     */
    public function testGetRuleNameWhereRuleEmpty()
    {
        $this->assertEquals('', $this->coreValidator->getRuleName());
    }

    /**
     *
     */
    public function testGetRuleNameWhereRuleNoteEmpty()
    {
        $this->assertEquals('email', $this->coreValidator->getRuleName('email:unique'));
    }

    /**
     *
     */
    public function testValidateMethodWillReturned()
    {
        $data = $this->getMockObjectWithMockedMethods(['sometimes']);

        $this->setProtectedAttributeOf($this->coreValidator, '_sometimes', ['col' => ['key' => 'value']]);
        $this->methodWillReturnEmptyArray($this->coreValidator, 'rules');
        $this->methodWillReturnEmptyArray($this->coreValidator, 'messages');

        CoreValidator::shouldReceive('make')
            ->once()
            ->with([], [], [])
            ->andReturn($data);
        $this->assertEquals($data, $this->coreValidator->validate([]));
    }

    /**
     *
     */
    public function testRulesWhereRulesVariableEmptyArray()
    {
        $coreValidator = $this->getMockCoreValidator();
        $this->assertEquals([], $coreValidator->rules());
    }

    /**
     *
     */
    public function testRulesWhereRulesVariableNotEmptyArray()
    {
        $coreValidator = $this->getMockCoreValidator();
        $data = [
            'name' => [
                'required',
                'unique'
            ]
        ];
        $this->setProtectedAttributeOf($coreValidator, '_rules', $data);
        $this->assertEquals(['name' => 'required|unique'], $coreValidator->rules());
    }

    /**
     * @throws \ReflectionException
     */
    public function test_RulesMethodWillReturned()
    {
        $this->assertEquals([], $this->callProtectedMethod($this->coreValidator, '_rules'));
    }

    /**
     * @throws \ReflectionException
     */
    public function testMessagesMethodWillReturned()
    {
        $coreValidator = $this->getMockCoreValidator();
        $this->assertEquals([], $this->callProtectedMethod($coreValidator, 'messages'));
    }

    /**
     *
     */
    public function testRequiredMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add');
        $this->assertEquals($this->coreValidator, $this->coreValidator->required('name'));
//        $this->expectCallMethodWithArgument($coreValidator, 'add', ['name', 'required', '', null]);
    }

    /**
     *
     */
    public function testRequiredIfMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixMultiRuleStructure', ['name', 'required_if', 'data', '', null]);
        $this->assertTrue($this->coreValidator->requiredIf('name', 'data'));
    }

    /**
     *
     */
    public function testRequiredUnlessMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixMultiRuleStructure', ['name', 'required_unless', 'data', '', null]);
        $this->assertTrue($this->coreValidator->requiredUnless('name', 'data'));
    }

    /**
     *
     */
    public function testRequiredWithMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'required_with', 'data', '', null]);
        $this->assertTrue($this->coreValidator->requiredWith('name', 'data'));
    }

    /**
     *
     */
    public function testRequiredWithAllMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'required_with_all', 'data', '', null]);
        $this->assertTrue($this->coreValidator->requiredWithAll('name', 'data'));
    }

    /**
     *
     */
    public function testRequiredWithoutMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator,'fixRuleStructure', ['name', 'required_without', 'data', '', null]);
        $this->assertTrue($this->coreValidator->requiredWithout('name', 'data'));
    }

    /**
     *
     */
    public function testRequiredWithoutAllMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'required_without_all', 'data', '', null]);
        $this->assertTrue($this->coreValidator->requiredWithoutAll('name', 'data'));
    }

    /**
     *
     */
    public function testPresentMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'present', '', null]);
        $this->assertTrue($this->coreValidator->present('name'));
    }

    /**
     *
     */
    public function testFilledMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'filled', '', null]);
        $this->assertTrue($this->coreValidator->filled('name'));
    }

    /**
     *
     */
    public function testAcceptedMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'accepted', '', null]);
        $this->assertTrue($this->coreValidator->accepted('name'));
    }

    /**
     *
     */
    public function testNullableMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'nullable', '', null]);
        $this->assertTrue($this->coreValidator->nullable('name'));
    }

    /**
     *
     */
    public function testSizeMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'size', 'size', '', null]);
        $this->assertTrue($this->coreValidator->size('name', 'size'));
    }

    /**
     *
     */
    public function testMinLengthMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'min', 'length', '', null]);
        $this->assertTrue($this->coreValidator->minLength('name', 'length'));
    }

    /**
     *
     */
    public function testMaxLengthMethodWillReturned()
    {
        $this->methodWillReturn($this->coreValidator, 'getTextLength', 'length');
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'max', 'length', '', null]);
        $this->assertTrue($this->coreValidator->maxLength('name', 'length'));
    }

    /**
     *
     */
    public function testBetweenMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'between', ['min', 'max'], '', null]);
        $this->assertTrue($this->coreValidator->between('name', 'min', 'max'));
    }

    /**
     *
     */
    public function testDifferentMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'different', 'value', '', null]);
        $this->assertTrue($this->coreValidator->different('name', 'value'));
    }

    /**
     *
     */
    public function testLastMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'bail');
        $this->assertTrue($this->coreValidator->last());
    }


    /**
     *
     */
    public function testBailMethodWillReturned()
    {
        $coreValidator = $this->getMockCoreValidator(['add']);
        $this->methodWillReturnTrue($coreValidator, 'add', [null, 'bail', '', null]);
        $this->assertTrue(true, $coreValidator->bail());
    }


    /**
     *
     */
    public function testAddMethodWillReturnedWhereWhenVariableIsCallable()
    {
        //TODO
        $this->assertTrue(true);

//        $coreValidator = $this->getMockCoreValidator([
//            'addCustomRule',
//            'checkWhen',
//            'getRuleName'
//        ]);
//
//        $this->methodWillReturnTrue($coreValidator, 'addCustomRule');
//        $this->methodWillReturn($coreValidator, 'checkWhen', function() {return true;});
//        $this->methodWillReturnTrue($coreValidator, 'getRuleName', 'rulName');
//
//        $this->assertEquals($coreValidator, $coreValidator->add('name', [], 'message'));
    }

    /**
     *
     */
    public function testAddMethodWillReturnedWhereWhenVariableInArray()
    {
        //TODO
        $this->assertTrue(true);

//        $coreValidator = $this->getMockCoreValidator([
//            'addCustomRule',
//            'checkWhen',
//            'getRuleName'
//        ]);
//
//        $this->methodWillReturnTrue($coreValidator, 'addCustomRule');
//        $this->methodWillReturn($coreValidator, 'checkWhen', 'create');
//        $this->methodWillReturn($coreValidator, 'getRuleName', 'rulName');
//
//        $this->assertEquals($coreValidator, $coreValidator->add('name', [], 'message'));
    }

    /**
     *
     */
    public function testAddMethodWillReturned()
    {
        //TODO
        $this->assertTrue(true);

//        $coreValidator = $this->getMockCoreValidator([
//            'addCustomRule',
//            'checkWhen',
//            'getRuleName'
//        ]);
//
//        $this->methodWillReturnTrue($coreValidator, 'addCustomRule');
//        $this->methodWillReturnFalse($coreValidator, 'checkWhen');
//        $this->methodWillReturn($coreValidator, 'getRuleName', 'rulName');
//
//        $this->assertEquals($coreValidator, $coreValidator->add('name', [], 'message'));
    }

    /**
     *
     */
    public function testRemoveMethodWillReturnedWhereRulesNameAndSometimesnameNotIsset()
    {
        $this->assertEquals($this->coreValidator, $this->coreValidator->remove('name'));
    }

    /**
     *
     */
    public function testRemoveMethodWillReturnedWhereRuleNameEqualsNull()
    {
        $this->setProtectedAttributeOf($this->coreValidator, '_rules', ['name' => 'name']);
        $this->setProtectedAttributeOf($this->coreValidator, '_sometimes', ['name' => 'name']);

        $this->assertEquals($this->coreValidator, $this->coreValidator->remove('name'));
    }

    /**
     *
     */
    public function testRemoveMethodWillReturnedWhereRuleNameEqualsNotNull()
    {
        $coreValidator = $this->getMockCoreValidator(['getRuleName']);
        $ruleName = 'ruleName';
        $this->setProtectedAttributeOf($coreValidator, '_rules', ['name' => [$ruleName]]);
        $this->setProtectedAttributeOf($coreValidator, '_sometimes', ['name' => [$ruleName => 'name']]);
        $this->methodWillReturn($coreValidator, 'getRuleName', $ruleName);

        $this->assertEquals($coreValidator, $coreValidator->remove('name', $ruleName));
    }


    /**
     *
     */
    public function testNumericMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'numeric', '', null]);
        $this->assertTrue($this->coreValidator->numeric('name'));
    }

    /**
     *
     */
    public function testIntegerMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'integer', '', null]);
        $this->assertTrue($this->coreValidator->integer('name'));
    }

    /**
     *
     */
    public function testDigitsMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'digits', 'value', '', null]);
        $this->assertTrue($this->coreValidator->digits('name', 'value'));
    }

    /**
     *
     */
    public function testDigitsBetweenMethodWillReturned()
    {
        //TODO
        $this->assertTrue(true);
        /*$coreValidator = $this->getMockCoreValidator(['numeric', 'between']);
        $methods = ['numeric', 'between'];
        $this->chainMethodsWillReturnArguments($methods, $coreValidator);*/
    }


    /**
     *
     */
    public function testEmailMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'email', '', null]);
        $this->assertTrue($this->coreValidator->email('name'));
    }

    /**
     *
     */
    public function testStartsWithMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'addStringMethodRule', ['name', 'starts_with', 'data', '', null]);
        $this->assertTrue($this->coreValidator->startsWith('name', 'data'));
    }

    /**
     *
     */
    public function testEndsWithMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'addStringMethodRule', ['name', 'ends_with', 'data', '', null]);
        $this->assertTrue($this->coreValidator->endsWith('name', 'data'));
    }

    /**
     *
     */
    public function testIsMethodWillReturnedAndWhereMessageEmpty()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add');
        $this->assertTrue($this->coreValidator->is('name', 'pattern'));
    }

    /**
     *
     */
    public function testRegexMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'regex', 'regex', '', null]);
        $this->assertTrue($this->coreValidator->regex('name', 'regex'));
    }

    /**
     *
     */
    public function testConfirmedMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'confirmed', '', null]);
        $this->assertTrue($this->coreValidator->confirmed('name'));
    }

    /**
     *
     */
    public function testIsArrayMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'array', '', null]);
        $this->assertTrue($this->coreValidator->isArray('name'));
    }

    /**
     *
     */
    public function testInMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'in:one,two', '', null]);
        $this->assertTrue($this->coreValidator->in('name', ['one', 'two']));
    }

    /**
     *
     */
    public function testNoteInMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'note_in:one,two', '', null]);
        $this->assertTrue($this->coreValidator->notIn('name', ['one', 'two']));
    }

    /**
     *
     */
    public function testIsCheckboxMethodWillReturned()
    {
        $coreValidator = $this->getMockCoreValidator(['in']);
        $this->methodWillReturnTrue($coreValidator, 'in', ['name', [0, 1], '', null]);
        $this->assertTrue($coreValidator->isCheckbox('name'));
    }


    /**
     *
     */
    public function testInClassConstantMethodWillReturned()
    {
        $this->assertTrue(true);
        // ToDo
    }

    /**
     *
     */
    public function testDateMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'date', '', null]);
        $this->assertTrue($this->coreValidator->date('name'));
    }

    /**
     *
     */
    public function testDateFormatMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'date_format', 'format', '', null]);
        $this->assertTrue($this->coreValidator->dateFormat('name', 'format'));
    }

    /**
     *
     */
    public function testBeforeMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'before', 'data', '', null]);
        $this->assertTrue($this->coreValidator->before('name', 'data'));
    }

    /**
     *
     */
    public function testAfterMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'afterdata', '', null, null]);
        $this->assertTrue($this->coreValidator->after('name', 'data'));
    }

    /**
     *
     */
    public function testAfterOrEqualMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'after_or_equal', 'data', '', null]);
        $this->assertTrue($this->coreValidator->afterOrEqual('name', 'data'));
    }

    /**
     *
     */
    public function testFileMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'file', '', null]);
        $this->assertTrue($this->coreValidator->file('name'));
    }

    /**
     *
     */
    public function testMimesMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'mimes', 'data', '', null]);
        $this->assertTrue($this->coreValidator->mimes('name', 'data'));
    }

    /**
     *
     */
    public function testImageMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'add', ['name', 'image', '', null]);
        $this->assertTrue($this->coreValidator->image('name'));
    }

    /**
     *
     */
    public function testExistsMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'exists_db', [], 'Invalid argument is supplied', null]);
        $this->assertTrue($this->coreValidator->exists('name'));
    }

    /**
     *
     */
    public function testMultiExistsMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'multi_exists', [], 'Invalid argument is supplied', null]);
        $this->assertTrue($this->coreValidator->multiExists('name'));
    }

    /**
     *
     */
    public function testExistsIfMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixDbIfRuleStructure', ['name', 'exists_if', [], 'Invalid argument is supplied', null]);
        $this->assertTrue($this->coreValidator->existsIf('name'));
    }

    /**
     *
     */
    public function testMultiExistsIfMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixDbIfRuleStructure', ['name', 'multi_exists_if', [], 'Invalid argument is supplied', null]);
        $this->assertTrue($this->coreValidator->multiExistsIf('name'));
    }

    /**
     *
     */
    public function testUniqueMethodWillReturned()
    {
        $this->methodWillReturnTrue($this->coreValidator, 'fixRuleStructure', ['name', 'uniq', [], '', null]);
        $this->assertTrue($this->coreValidator->unique('name'));
    }

    /**
     * @throws \ReflectionException
     */
    public function testCheckWhenMethodWillReturnedAndWhereWhenEqualsIsset()
    {
//        $returned = $this->callProtectedMethod($this->coreValidator, 'checkWhen',
//        ['name', 'isset']);
//        // ToDo
        $this->assertTrue(true);
    }

    /**
     * @throws \ReflectionException
     */
    public function testCheckWhenMethodWillReturnedAndWhereWhenEqualsNotempty()
    {
//        // ToDo
        $this->assertTrue(true);
//        $returned = $this->callProtectedMethod($this->coreValidator, 'checkWhen',
//            ['name', 'notempty']);
        // ToDo
    }

    /**
     * @throws \ReflectionException
     */
    public function testCheckWhenMethodWillReturnedAndWhereWhenEqualsNull()
    {
        $returned = $this->callProtectedMethod($this->coreValidator, 'checkWhen', ['name']);
        $this->assertNull($returned);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFixMultiRuleStructureMethodWillReturnedAndWhereDataEqualsString()
    {
        $coreValidator = $this->getMockCoreValidator(['fixRuleStructure']);
        $this->methodWillReturnTrue($coreValidator, 'fixRuleStructure', ['name', 'rule', 'data', '', null]);
        $returned = $this->callProtectedMethod($coreValidator, 'fixMultiRuleStructure', ['name', 'rule', 'data']);
        $this->assertTrue($returned);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFixMultiRuleStructureMethodWillReturnedAndWhereDataArrayKeysEqualsNumeric()
    {
        $coreValidator = $this->getMockCoreValidator(['fixRuleStructure']);
        $this->methodWillReturnTrue($coreValidator, 'fixRuleStructure', ['name', 'rule', ['value'], '', null]);
        $returned = $this->callProtectedMethod($coreValidator, 'fixMultiRuleStructure',
            ['name', 'rule', ['value']]);
        $this->assertTrue($returned);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFixMultiRuleStructureMethodWillReturnedAndWhereDataEqualsArray()
    {
        $coreValidator = $this->getMockCoreValidator(['makeArray', 'fixRuleStructure']);
        $returned = $this->callProtectedMethod($coreValidator, 'fixMultiRuleStructure',
            ['name', 'rule', ['key' => ['value']]]);
        $this->assertEquals($coreValidator, $returned);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFixRuleStructureMethodWillReturned()
    {
        $coreValidator = $this->getMockCoreValidator(['makeArray', 'add']);
        $this->methodWillReturnTrue($coreValidator, 'add', ['name', 'rule:data', '', null]);
        $returned = $this->callProtectedMethod($coreValidator, 'fixRuleStructure', ['name', 'rule', ['data']]);
        $this->assertTrue($returned);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFixDbIfRuleStructureMethodWillReturnedWhereDataArrayKeyNumeric()
    {
        $coreValidator = $this->getMockCoreValidator(['makeArray', 'add']);
        $this->methodWillReturnTrue($coreValidator, 'add', ['name', 'rule:data', '', null]);
        $returned = $this->callProtectedMethod($coreValidator, 'fixDbIfRuleStructure', ['name', 'rule', ['data']]);
        $this->assertTrue($returned);
    }

    /**
     * @throws \ReflectionException
     */
    public function testFixDbIfRuleStructureMethodWillReturnedWhereDataArrayKeyNotNumeric()
    {
        $coreValidator = $this->getMockCoreValidator(['makeArray', 'add']);
        $this->methodWillReturnTrue($coreValidator, 'add', ['name', 'rule:key=>null', '', null]);
        $returned = $this->callProtectedMethod($coreValidator, 'fixDbIfRuleStructure', ['name', 'rule', [['key' => null]]]);
        $this->assertTrue($returned);
    }

    /**
     * @throws \ReflectionException
     */
    public function testAddStringMethodRuleMethodWillReturned()
    {
        $coreValidator = $this->getMockCoreValidator(['makeArray', 'add']);
        $this->methodWillReturnTrue($coreValidator, 'add');
        $returned = $this->callProtectedMethod($coreValidator, 'addStringMethodRule', ['name', 'rule', ['data']]);
        $this->assertTrue($returned);
    }

    /**
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockCoreValidator($methods = null) {
        return $this->getMockBuilder(CoreValidator::class)
            ->setMethods($methods)
            ->getMock();
    }

}
