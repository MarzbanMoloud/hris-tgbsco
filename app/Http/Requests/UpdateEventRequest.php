<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


/**
 * Class UpdateEventRequest
 * @package App\Http\Requests
 */
class UpdateEventRequest extends FormRequest
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
            'title' => 'required',
            'alert_date' => 'required',
        ];
    }
}
