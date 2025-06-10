<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => 'required',
            'email'        => 'required|email|unique:users',
            'phone_number' => 'required',
            'password'     => 'required',
            'role'         => 'required|in:admin,customer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'email.email' => 'format penulisan email salah',
            'email.unique' => 'email sudah digunakan',
            'phone_number.required' => 'nomor handphone wajib diisi',
            'password.unique' => 'password wajib diisi',
            'role.required' => 'password wajib diisi',
            'role.in' => 'password harus diisi admin | customer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => [$errors]
        ], 400));
    }
}
