<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Member;

class AddValidationRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $count = Member::find($value)->winningNumbers->count();
        if($count < 5){
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You cannot add anymore winning numbers, maximum of 5.';
    }
}
