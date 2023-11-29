<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreInvoiceRequest extends FormRequest
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
            '*.customer_id' => 'required|integer|exists:customers,id',
            '*.amount' => 'required|numeric',
            '*.status' => 'required|in:P,B,V,p,b,v',
            '*.billed_date' => 'required|date_format:Y-m-d H:i:s',
            '*.paid_date' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    protected function prepareForValidation(): void
    {
        $reqData = $this->all();

        $transformedReqData = collect($reqData)->map(function ($item) {
            return collect($item)->merge([
                'customer_id' => $item['customerId'] ?? null,
                'billed_date' => $item['billedDate'] ?? null,
                'paid_date' => $item['paidDate'] ?? null,
            ])->all();
        })->toArray();

        $this->replace($transformedReqData);
    }
}
