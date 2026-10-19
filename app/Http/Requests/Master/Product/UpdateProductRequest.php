<?php

namespace App\Http\Requests\Master\Product\Product;

use App\Http\Requests\BaseApiRequest;

class UpdateProductRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_code'          => ['required', 'string', 'max:50', 'unique:product,product_code'],
            'product_name'          => ['required', 'string', 'max:255'],
            'product_alias'         => ['nullable', 'string', 'max:255'],
            'product_group_id'      => ['nullable', 'exists:product_group,product_group_id'],
            'product_barcode'       => ['nullable', 'string', 'max:20'],
            'product_serial_number' => ['nullable', 'string', 'max:20'],
            'uom_code'              => ['required', 'exists:uom,uom_code'],
            'product_std_price'     => ['nullable', 'integer'],
            'stock_coa_id'          => ['nullable', 'exists:coa_old,coa_id'],
            'hpp_coa_id'            => ['nullable', 'exists:coa_old,coa_id'],
            'sales_coa_id'          => ['nullable', 'exists:coa_old,coa_id'],
            'sales_return_coa_id'   => ['nullable', 'exists:coa_old,coa_id'],
            'discount_coa_id'       => ['nullable', 'exists:coa_old,coa_id'],
            'unbilled_purchase_coa_id' => ['nullable', 'exists:coa_old,coa_id'],
            'unbilled_delivery_coa_id' => ['nullable', 'exists:coa,coa_id'],
            'min_stock_level_week'  => ['nullable', 'integer', 'min:0'],
            'max_stock_level_week'  => ['nullable', 'integer', 'min:0'],
            'purchase_lead_time'    => ['nullable', 'decimal:1', 'min:0'],
            'moq'                   => ['nullable', 'integer', 'min:0'],
            'is_included_in_mrp_ml' => ['nullable', 'boolean'],
            'is_included_in_mrp_pl' => ['nullable', 'boolean'],
            'is_active'             => ['nullable', 'boolean'],
            'product_article'       => ['nullable', 'string', 'max:100'],
            'product_sell_Price'    => ['nullable', 'integer'],
            'is_PPN'                => ['nullable', 'boolean'],
            'PPN'                   => ['nullable', 'decimal:1'],
            'is_PPNBM'              => ['nullable', 'boolean'],
            'PPNBM'                 => ['nullable', 'decimal:1'],
            'is_BOM'                => ['nullable', 'boolean'],
            'is_royalty'            => ['nullable', 'boolean'],
            'is_inventory'          => ['nullable', 'boolean'],
            'is_sold'               => ['nullable', 'boolean'],
            'is_buy'                => ['nullable', 'boolean'],
            'is_production'         => ['nullable', 'boolean'],
            'is_supplier'           => ['nullable', 'boolean'],
            'is_fixed_asset'        => ['nullable', 'boolean'],
            'is_expedition'         => ['nullable', 'boolean'],
            'updated_by' => ['required', 'string', 'max:255'],
            'reason'     => ['required', 'string', 'max:255']
        ];
    }
}
