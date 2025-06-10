<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class requestCar extends FormRequest
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
            'name'        => 'required',
            'price'       => 'required|numeric',
            'color'       => 'required',
            'status'      => 'required|in:available,unavailable',
            'seat'        => 'required|integer',
            'cc'          => 'required|integer',
            'top_speed'   => 'required|integer',
            'description' => 'nullable|string',
            'location'    => 'required|string',
            'imageUrl'    => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'nama wajib diisi',
            'price.required' => 'harga wajib diisi',
            'price.numeric' => 'nilai harus angka',
            'color' => 'warna harus diisi',
            'status.required' => 'status harus diisi',
            'status.in' => 'status harus diisi available | unavailable',
            'seat.required' => 'jumlah tempat duduk harus diisi',
            'seat.integer' => 'jumlah tempat duduk harus diisi bilangan bulat',
            'cc.required' => 'CC dari mobil harus diisi',
            'cc.integer' => 'CC harus diisi dengan bilangan bulat',
            'top_speed.required' => 'top speed dari mobil harus diisi',
            'top_speed.integer' => 'top speed harus diisi dengan bilangan bulat',
            'location.required' => 'lokasi dari mobil harus diisi',
            'category_id.required' => 'id kategori harus diisi',
            'category_id.exists' => 'tidak ada id kategori yang cocok'
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
