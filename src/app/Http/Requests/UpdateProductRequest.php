<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('product'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'name' => 'required|string|max:255',
            'sku'  => 'required|string|max:100|unique:products,sku,' . $productId . ',id,tenant_id,' . app('tenant')->id,
            'price'=> 'required|numeric|min:0',
            'stock'=> 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ];
    }
}
