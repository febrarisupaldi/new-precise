<?php

namespace App\Http\Requests\Master\ProductEquivalent\ProductEquivalen;

use App\Http\Requests\BaseApiRequest;

class UpdateProductEquivalentRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'product_code'      => ['required','exists:product,product_code'],
            'uom_code'          => ['required','exists:uom,uom_code'],
            'qty_std'           => ['required', 'numeric'],
            'qty_conversion'    => ['required', 'numeric'],
            'updated_by'        => ['required', 'string', 'max:255'],
            'reason'            => ['required', 'string', 'max:255'],
        ];
    }
}
