<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        $method = $this->method();

        return $method == 'PUT' ? [
            'name' => 'required',
            'type' => 'required|in:I,B,i,b',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required'
        ] : [
            'name' => 'sometimes|required',
            'type' => 'sometimes|required|in:I,B,i,b',
            'email' => 'sometimes|required|email',
            'address' => 'sometimes|required',
            'city' => 'sometimes|required',
            'state' => 'sometimes|required',
            'postal_code' => 'sometimes|required'
        ];
    }

    protected function prepareForValidation(): void
    {
        $method = $this->method();

        if ($method == 'PUT' || $this->postalCode) {
            $this->merge([
                'postal_code' => $this->postalCode ?? null
            ]);
        }
    }
}
