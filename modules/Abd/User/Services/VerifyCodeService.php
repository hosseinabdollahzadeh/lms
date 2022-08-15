<?php

namespace Abd\User\Services;

class VerifyCodeService
{
    private static  $min = 100000;
    private static  $max = 999999;
    private static  $prefix = 'verify_mail_';

    public static function generate()
    {
        return random_int(100000, 999999);
    }

    public static function store($id, $code, $time)
    {
        cache()->set(
            self::$prefix . $id,
            $code,
            $time
        );
    }

    public static function get($id)
    {
        return cache()->get(self::$prefix . $id);
    }

    public static function has($id)
    {
        return cache()->has(self::$prefix . $id);
    }
    public static function delete($id)
    {
        return cache()->delete(self::$prefix . $id);
    }

    public static function getRul()
    {
        return 'required|numeric|between:'.self::$min.','.self::$max;
    }

    public static function check($id, $code)
    {
        if(self::get($id) != $code) return false;

        self::delete($id);
        return  true;
    }
}
