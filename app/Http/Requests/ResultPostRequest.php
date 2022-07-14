<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'party_id' => 'required|numeric',
            'lga_id' => 'required|numeric',
            'ward_id' => 'required|numeric',
            'pu_id' => 'required|numeric',
            'vote_count' => 'required|numeric',
        ];
    }
}
