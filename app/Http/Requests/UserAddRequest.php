<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Rules\PhoneNumber;
use App\Rules\BirthDayShouldBe;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphabetAndUnderLineCharactersOnly;

class UserAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    // public function prepareForValidation()
    // {
    //     $this->merge([
    //         'dateOfBirth' => Carbon::createFromFormat('d/m/Y H:i:s', $this->dateOfBirth)->format('Y-m-d'),
    //     ]);
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:App\Models\User,email',
            'username' => ['required', 'string', 'max:25', 'unique:App\Models\User,username', new AlphabetAndUnderLineCharactersOnly],
            'password' => 'required|confirmed|min:6',
            'name' => 'required|string|max:255|min:3',
            'mobile' => ['unique:App\Models\User,mobile', new PhoneNumber],
            'dateOfBirth' => ['nullable', new BirthDayShouldBe],
            'roles' => 'required',
            'cabor' => 'required_if:roles.id,3'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'cabor.required_if' => ':attribute can not be empty.',
        ];
    }
}
