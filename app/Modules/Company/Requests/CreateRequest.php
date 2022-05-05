<?php

namespace App\Modules\Company\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\CommonRequest;

class CreateRequest extends FormRequest
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
            'name' => 'required|string|max:15',
            'address' => 'required|string|max:100'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'please enter name',
            'name.string' => 'name in string form',
            'name.max' => 'Maximum name is 15 characters',

            'address.required' => 'please enter address',
            'address.string' => 'address in string form',
            'address.max' => 'Maximum address is 100 characters',
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
