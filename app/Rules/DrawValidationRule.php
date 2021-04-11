<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\WinningNumber;

class DrawValidationRule implements Rule
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
        $wn = WinningNumber::where('winning_number', $value)->first();
        if($wn){
            if($wn->member->won_prize != 1){
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // return 'The validation error message.';
        return 'The owner of this winning number have already won.';
    }
}
