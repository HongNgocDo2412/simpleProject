<?php

namespace App\Modules\Employee\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\CommonRequest;

class UpdateRequest extends FormRequest
{
    /** @var CommonRequest $commonRequest */
    private CommonRequest $commonRequest;

    public function __construct(CommonRequest $commonRequest)
    {
        $this->commonRequest = $commonRequest;
    }
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
            'email' => 'required|string|email:rfc,dns',
            'name' => 'required|string|max:50',
            'position' => 'required|string|max:100',
            'company_id'=>'required|integer|exists:companies,id',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'please enter email',
            'email.string' => 'email in string form',
            'email.email' => 'email is valid',

            'name.required' => 'please enter name',
            'name.string' => 'name in string form',
            'name.max' => 'Maximum name is 50 characters',

            'position.required' => 'please enter position',
            'position.string' => 'position in string form',
            'position.max' => 'Maximum position is 100 characters',

            'company_id.required' => 'please enter company_id',
            'company_id.string' => 'company_id in integer form',
            'company_id.max' => 'Maximum company_id is exists companies',
        ];
    }
    /**
     *-------------------------------------------------------------------------------
     * Handle a failed validation attempt.
     *-------------------------------------------------------------------------------
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $this->commonRequest->validateCommonBadRequest($validator);
    }
}
