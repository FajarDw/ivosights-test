<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Responses\BaseResponse;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('get')) {
            return [
                // Validation for query parameter (GET /api/products)
                'search'   => 'nullable|string|max:255',
                'sort_by'  => 'nullable|in:name,price,created_at,stock',
                'sort_dir' => 'nullable|in:asc,desc',
                'limit' => 'nullable|integer|min:1|max:100',
                'page' => 'integer|min:1',
            ];
        }
        return [
            // Validation for input produk (Create & Update)
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',

        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(
    //         BaseResponse::error('Validation Error', 422, 'validation_failed', $validator->errors())
    //     );
    // }

    public function messages()
    {
        return [
            // Error message for validation product
            'name.required'    => 'Nama produk wajib diisi.',
            'name.string'      => 'Nama produk harus berupa teks.',
            'name.max'         => 'Nama produk maksimal 255 karakter.',
            'name.unique'      => 'Nama produk sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'price.required'   => 'Harga wajib diisi.',
            'price.numeric'    => 'Harga harus berupa angka.',
            'price.min'        => 'Harga tidak boleh kurang dari 0.',
            'stock.required'   => 'Stok wajib diisi.',
            'stock.integer'    => 'Stok harus berupa angka bulat.',
            'stock.min'        => 'Stok tidak boleh kurang dari 0.',

            // Error message for validation query parameter
            'sort_by.in'       => 'Kolom sort_by hanya boleh name, price, atau created_at.',
            'sort_dir.in'      => 'Arah sorting harus asc atau desc.',
            'per_page.integer' => 'Per page harus berupa angka.',
            'per_page.min'     => 'Minimal 1 item per halaman.',
            'per_page.max'     => 'Maksimal 100 item per halaman.',
        ];
    }
}
