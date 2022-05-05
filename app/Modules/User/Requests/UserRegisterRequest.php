<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\CommonRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|confirmed',
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'please enter name',
            'name.string' => 'name in string form',

            'email.required' => 'please enter email',
            'email.string' => 'email in string form',
            'email.unique' => 'email is only',

            'password.required' => 'please enter password',
            'password.string' => 'password in string form',
            'password.confirmed' => 'password confirmed password',
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
