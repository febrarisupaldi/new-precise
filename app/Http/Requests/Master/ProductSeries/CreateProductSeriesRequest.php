<?php

namespace App\Http\Requests\Master\ProductSeries;

use App\Http\Requests\BaseApiRequest;

class CreateProductSeriesRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'series_name' => ['required', 'string', 'max:50'],
            'series_description' => ['nullable', 'string', 'max:100'],
            'created_by' => ['required', 'string', 'max:100']
        ];
    }
}
