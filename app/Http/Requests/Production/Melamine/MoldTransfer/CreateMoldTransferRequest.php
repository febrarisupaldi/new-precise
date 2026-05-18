<?php

namespace App\Http\Requests\Production/Melamine\MoldTransfer;

use App\Http\Requests\BaseApiRequest;

class CreateMoldTransferRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
        ];
    }
}
