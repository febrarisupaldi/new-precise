<?php

namespace App\Http\Requests\Master\MoldPressing;

use App\Http\Requests\BaseApiRequest;

class IndexMoldPressingRequest extends BaseApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'number'    => ['nullable','string', 'prohibits:code,with'],
            'code'      => ['nullable','string', 'prohibits:number,with'],
            'with'      => ['nullable','string', 'in:details', 'prohibits:number,code']
        ];
    }
}
