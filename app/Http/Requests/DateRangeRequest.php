<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseApiRequest;

class DateRangeRequest extends BaseApiRequest
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
            'from'  => ['required', 'date_format:Y-m-d'],
            'to'    => ['required', 'date_format:Y-m-d', 'gte:from'],
        ];
    }
}
