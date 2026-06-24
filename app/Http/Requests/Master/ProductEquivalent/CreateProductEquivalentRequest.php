<?php

namespace App\Http\Requests\Master\ProductEquivalent\ProductEquivalent;

use App\Http\Requests\BaseApiRequest;

class CreateProductEquivalentRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_code'     => ['required','exists:product,product_code'],
            'uom_code'         => ['required','exists:uom,uom_code'],
            'qty_std'          => ['required', 'numeric'],
            'qty_conversion'   => ['required', 'numeric'],
        ];
    }

    
}
