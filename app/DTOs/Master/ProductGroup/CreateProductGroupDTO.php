<?php

namespace App\DTOs\Master\ProductGroup;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductGroupDTO extends BaseDTO
{
    public function __construct(
        public readonly string $product_group_code,
        public readonly string $product_group_name,
        public readonly int $product_type_id,
        public readonly ?int $stock_coa_id,
        public readonly ?int $hpp_coa_id,
        public readonly ?int $sales_coa_id,
        public readonly ?int $sales_return_coa_id,
        public readonly ?int $discount_coa_id,
        public readonly ?string $invt_sub_ledger,
        public readonly ?string $invt_resp_code,
        public readonly ?int $unbilled_purchase_coa_id,
        public readonly ?int $unbilled_delivery_coa_id,
        public readonly ?string $created_by,
    ) {}



    public static function fromRequest(Request $request): static
    {
        return new static(
            product_group_code: (string) $request->input('product_group_code'),
            product_group_name: (string) $request->input('product_group_name'),
            product_type_id: (int) $request->input('product_type_id'),
            stock_coa_id: (int) $request->input('stock_coa_id'),
            hpp_coa_id: (int) $request->input('hpp_coa_id'),
            sales_coa_id: (int) $request->input('sales_coa_id'),
            sales_return_coa_id: (int) $request->input('sales_return_coa_id'),
            discount_coa_id: (int) $request->input('discount_coa_id'),
            invt_sub_ledger: (string) $request->input('invt_sub_ledger'),
            invt_resp_code: (string) $request->input('invt_resp_code'),
            unbilled_purchase_coa_id: (int) $request->input('unbilled_purchase_coa_id'),
            unbilled_delivery_coa_id: (int) $request->input('unbilled_delivery_coa_id'),
            created_by: (string) $request->input('created_by'),
        );
    }
}
