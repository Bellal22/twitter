<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;



class CreateFollowRequest extends FormRequest
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
            // 'following_id' => ['required|exists:users,id',
            //     Rule::unique('follows')
            //     ->where('following_id', $this->following_id)
            // ],

            'following_id' => 'required|exists:users,id'
        ];
    }
}
