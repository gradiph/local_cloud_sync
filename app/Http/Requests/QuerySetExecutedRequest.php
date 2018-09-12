<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuerySetExecutedRequest extends FormRequest
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
            'cloud_query_id' => 'required|exists:cloud_queries,id',
        ];
    }
}
