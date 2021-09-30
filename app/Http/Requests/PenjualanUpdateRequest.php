<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjualanUpdateRequest extends FormRequest
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
            'id_user' => 'required|exists:users,id',
            'old_total_barang.*' => 'required|min:0',
            'id_barang.*' => 'required|exists:barangs,id',
            'total_barang.*' => 'required|min:1',
        ];
    }
}
