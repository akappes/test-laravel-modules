<?php

namespace Modules\Bucket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BucketRequest
 */
class BucketRequest extends FormRequest
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
            'capacity' => 'required|integer',
        ];
    }
}
