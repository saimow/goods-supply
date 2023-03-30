<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            'details.name' => 'required|max:255',
            'details.slug' => ['required', 'unique:products,slug,'.$this->route('product')->id, 'max:255'],
            'details.description' => 'nullable|max:9000',
            'details.thumbnail' => 'nullable|max:255',
            'details.price' => ['required', 'numeric', 'min:1', 'max:99999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'details.compare_at_price' => ['nullable', 'numeric', 'min:1', 'max:99999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'details.quantity' => 'nullable|numeric|max_digits:8',
            'details.sku' => 'nullable|max:255',
            'details.barcode' => 'nullable|max:255',
            'details.weight' => ['nullable', 'numeric', 'min:0', 'max:9999999.999', 'regex:/^\d+(\.\d{1,3})?$/'],
            'details.vendor' => 'nullable|max:255',
            'details.has_variants' => 'nullable|boolean',
            'details.visibility' => 'nullable|boolean',

            'options.*.name' => 'required|max:255',

            'options.*.values.*.name' => 'required|max:255',

            'variants.*.is_default' => 'boolean',
            'variants.*.image' => 'max:255',
            'variants.*.price' => ['nullable', 'numeric', 'min:1', 'max:99999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'variants.*.compare_at_price' => ['nullable', 'numeric', 'min:1', 'max:99999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'variants.*.quantity' => 'nullable|numeric|max_digits:8',
            'variants.*.sku' => 'nullable|max:255',
            'variants.*.barcode' => 'nullable|max:255',
            'variants.*.weight' => ['nullable', 'numeric', 'min:0', 'max:9999999.999', 'regex:/^\d+(\.\d{1,3})?$/'],

            'media.added.*.name' => 'required|max:255',
            'media.added.*.size' => 'required|max:255',
            'media.added.*.type' => 'required|max:255',
            'media.removed.*.name' => 'required|max:255',
            'media.removed.*.size' => 'required|max:255',
            'media.removed.*.type' => 'required|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'details.name' => 'name',
            'details.slug' => 'slug',
            'details.description' => 'description',
            'details.price' => 'price',
            'details.compare_at_price' => 'compare at price',
            'details.quantity' => 'quantity',
            'details.sku' => 'sku',
            'details.barcode' => 'barcode',
            'details.weight' => 'weight',
            'details.vendor' => 'vendor',
            'details.has_variants' => 'variants',
            'details.visibility' => 'visibility',

            'options.*.name' => 'option',

            'options.*.values.name' => 'option value',


            'variants.*.is_default' => 'is_default',
            'variants.*.image' => 'variant image',
            'variants.*.price' => 'variant price',
            'variants.*.compare_at_price' => 'variant compare at price',
            'variants.*.quantity' => 'variant quantity',
            'variants.*.sku' => 'variant sku',
            'variants.*.barcode' => 'variant barcode',
            'variants.*.weight' => 'variant weight',
        ];
    }

    protected $stopOnFirstFailure = true;
}
