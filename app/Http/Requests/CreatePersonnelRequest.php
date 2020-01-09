<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


/**
 * Class CreatePersonnelRequest
 * @package App\Http\Requests
 */
class CreatePersonnelRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'father_name' => 'required',
            'mobile_number' => 'nullable|iran_mobile',
            'national_code' => 'nullable|melli_code',
            'personnel_code' => 'required|unique:personnels',
        ];
    }
}
