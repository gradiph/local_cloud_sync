<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuerySetUploadedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'local_query_id' => 'required|exists:local_queries,id',
        ];
    }
}
