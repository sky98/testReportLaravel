<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
    public function rules()
    {
        return [
            'nit'           => 'required|exists:users,nit',
            'password'      => 'required',
            'device_name'   => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
     public function messages(){
        return [
            'nit.required'          => 'The :attribute is required',
            'nit.exists'            => 'The :attribute must exist',
            'password.required'     => 'The :attribute is required',
            'device_name.required'  => 'The :attribute is required',
        ];
    }

     /**
    * Handle a failed validation attempt.
    *
    * @param \Illuminate\Contracts\Validation\Validator $validator
    * @return void
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function response(){
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }
    }

}