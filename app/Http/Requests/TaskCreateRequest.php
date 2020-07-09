<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Validation\Rule;
class TaskCreateRequest extends BaseRequest
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
            'image' => 'mimes:jpeg,jpg,png|required',
            'status' => Rule::in(Task::STATUS_ARRAY),
            'board_id' => 'required|exists:boards,id'
        ];
    }
}
