<?php

namespace Abd\User\Tests\Unit;

use Abd\User\Rules\ValidMobile;
use PHPUnit\Framework\TestCase;

class MobileValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_mobile_can_not_be_less_than_10_character()
    {
        $result = (new ValidMobile())->passes('', '912345678');
        $this->assertEquals(0, $result);
    }

    public function test_mobile_can_not_be_more_than_10_character()
    {
        $result = (new ValidMobile())->passes('', '9123456789011');
        $this->assertEquals(0, $result);
    }

    public function test_mobile_should_start_with_9()
    {
        $result = (new ValidMobile())->passes('', '2123456789');
        $this->assertEquals(0, $result);
    }
}
