<?php

namespace Tests\Unit;

use Abd\User\Rules\ValidPassword;
use PHPUnit\Framework\TestCase;

class PasswordValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_password_should_not_be_less_than_6_character()
    {
        $result = (new ValidPassword())->passes('', 'Aa!23');
        $this->assertEquals(0, $result);
    }
    public function test_password_should_include_sign_character()
    {
        $result = (new ValidPassword())->passes('', 'Aa123assa');
        $this->assertEquals(0, $result);
    }

    public function test_password_should_include_capital_character()
    {
        $result = (new ValidPassword())->passes('', 'jhgjhg@a!23');
        $this->assertEquals(0, $result);
    }
    public function test_password_should_include_digit_character()
    {
        $result = (new ValidPassword())->passes('', 'Aa!jhhjg@#jhGHFH');
        $this->assertEquals(0, $result);
    }
    public function test_password_should_include_small_character()
    {
        $result = (new ValidPassword())->passes('', '@JHGJHG#!6664');
        $this->assertEquals(0, $result);
    }
}
