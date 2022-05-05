<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\CommonRequest;

class UserLoginRequest extends FormRequest
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
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'please enter email',
            'email.string' => 'email in string form',

            'password.required' => 'please enter password',
            'password.string' => 'password in string form',
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
