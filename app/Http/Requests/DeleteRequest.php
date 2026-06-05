<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseApiRequest;

class DeleteRequest extends BaseApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array{string}>
     */
    public function rules(): array
    {
        return [
            'reason' => ['required', 'string'],
            'updated_by' => ['required', 'string'],
        ];
    }
}
