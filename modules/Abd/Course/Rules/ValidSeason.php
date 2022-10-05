<?php

namespace Abd\Course\Rules;

use Abd\Course\Repositories\SeasonRepo;
use Abd\User\Models\User;
use Abd\User\Repositories\UserRepo;
use Illuminate\Contracts\Validation\Rule;

class ValidSeason implements Rule
{
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $season = resolve(SeasonRepo::class)->findByIdandCourseId($value, request()->route('course'));
        if ($season) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'سرفصل انتخاب شده معتبر نمی باشد!';
    }
}
