<?php

namespace App\Http\Requests;

class TaskUpdateRequest extends BaseRequest
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
            'name' => 'required',
            'image_desktop' => '',
            'image_mobile' => '',
            'status' => ['required', new \App\Rules\TaskStatusRule()],
        ];
    }
}
