<?php

namespace Modules\Fruit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FruitRequest
 */
class FruitRequest extends FormRequest
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
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'expiration_at' => 'required|date_format:Y-m-d',
        ];
    }
}
