<?php

namespace App\Http\Requests;

use App\Rules\ChangeDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Event extends FormRequest
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
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        $event_id = $request->route('event', 0);
        return [
            'title' => 'required',
            'cost' => 'required|numeric|between:1,100000000',
            'type' => 'required',
            'responsible' => 'required',
            'company_name' => 'required',
            'date' => 'required|date',
            'change_id' => ['numeric', new ChangeDate($request->all(), $event_id)]
        ];
    }
}
