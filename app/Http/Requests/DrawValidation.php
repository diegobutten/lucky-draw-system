<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Rules\DrawValidationRule;

class DrawValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'prizeType' => 'required|unique:members,prize_type',
            'generateRandomly' => 'required',
            'winningNumber' => ($request->has('winningNumber') ? ['required', 'numeric', 'exists:winning_numbers,winning_number', 'min:0', new DrawValidationRule] : '')
            // 'digits_between:4,4',
        ];
    }

    public function messages()
    {
        return [
            'prizeType.unique' => ':attribute already have a winner.',
        ];
    }

    public function attributes()
    {
        return [
            'prizeType' => 'Prize Type',
            'generateRandomly' => 'Generate Randomly',
            'winningNumber' => 'Winning Number',
        ];
    }
}
