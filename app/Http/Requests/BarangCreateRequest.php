<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangCreateRequest extends FormRequest
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
            'kode_barang' => 'required|string|unique:barangs|min:2|max:100',
            'nama_barang' => 'required|string|unique:barangs|max:255',
            'gambar_barang' => 'image|max:2048|mimes:jpg,jpeg,png,gif',

        ];
    }
}
