<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Dictionaries\TransactionTypeDictionary;
use App\Rules\ValidCallbackParametersRule;
use App\Rules\ValidColumnNamesRule;
use App\Rules\ValidTableNameRule;
use App\Rules\ValidTransactionType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateDataRequest extends FormRequest
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
            'table_name' => ['required', 'string', new ValidTableNameRule()],

            'data' => ['required', 'array', 'min:1', new ValidColumnNamesRule($this->get('table_name'))],
            'data.created_by' => ['exists:users,id'],

            'transaction_type' => [
                'required',
                'string',
                Rule::in(TransactionTypeDictionary::getValidTransactionTypes()),
                new ValidTransactionType($this->get('data'), $this->get('table_name'))
            ],

            'dispatch_transaction_completed_event' => ['boolean'],

            'callback_function' => ['array', new ValidCallbackParametersRule()],
        ];
    }

    /**
     * @inheritDoc
     */
    public function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(['data' => [],
            'meta' => [
                'message' => 'The given data is invalid',
                'errors' => $validator->errors()
            ]], Response::HTTP_BAD_REQUEST);

        throw new ValidationException($validator, $response);
    }
}
