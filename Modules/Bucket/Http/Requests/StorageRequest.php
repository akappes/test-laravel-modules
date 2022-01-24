<?php

namespace Modules\Bucket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StorageRequest
 */
class StorageRequest extends FormRequest
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
            'bucket_id' => 'required|integer',
            'fruit_id' => 'required|integer',
        ];
    }
}
