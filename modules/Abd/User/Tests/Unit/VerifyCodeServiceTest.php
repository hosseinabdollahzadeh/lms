<?php

namespace Abd\User\Tests\Unit;

use Abd\User\Services\VerifyCodeService;
use Tests\TestCase;

class VerifyCodeServiceTest extends TestCase
{
    public function test_generated_code_is_6_digit()
    {
        $code = VerifyCodeService::generate();

        $this->assertIsNumeric($code, 'Generated code is not numeric');
        $this->assertLessThanOrEqual(999999, $code, 'Generated code is greater than 999999');
        $this->assertGreaterThanOrEqual(100000, $code, 'Generated code is less than 100000');
    }

    public function test_verify_code_can_store()
    {
        $code = VerifyCodeService::generate();
        VerifyCodeService::store(1, $code);

        $this->assertEquals($code, cache()->get('verify_mail_1'));
    }
}
