<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


/**
 * Class CreateGaranteeRequest
 * @package App\Http\Requests
 */
class CreateGaranteeRequest extends FormRequest
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
            'personnelId' =>'required',
            'amount' =>'required',
            'receive_date' =>'required',
        ];
    }
}
