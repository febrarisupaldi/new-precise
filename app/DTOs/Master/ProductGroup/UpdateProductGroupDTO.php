<?php

namespace App\DTOs\Master\ProductGroup;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use Override;

class UpdateProductGroupDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly string $product_group_code,
        public readonly string $product_group_name,
        public readonly int $product_type_id,
        public readonly ?int $stock_coa_id,
        public readonly ?int $hpp_coa_id,
        public readonly ?int $sales_coa_id,
        public readonly ?int $sales_return_coa_id,
        public readonly ?int $discount_coa_id,
        public readonly string $invt_sub_ledger,
        public readonly string $invt_resp_code,
        public readonly ?int $unbilled_purchase_coa_id,
        public readonly ?int $unbilled_delivery_coa_id,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}


    #[Override]
    public static function fromArray(array $data): static
    {
        return new static(
            product_group_code: (string) $data['product_group_code'],
            product_group_name: (string) $data['product_group_name'],
            product_type_id: (int) $data['product_type_id'],
            stock_coa_id: (int) $data['stock_coa_id'] ?? null,
            hpp_coa_id: (int) $data['hpp_coa_id'] ?? null,
            sales_coa_id: (int) $data['sales_coa_id'] ?? null,
            sales_return_coa_id: (int) $data['sales_return_coa_id'] ?? null,
            discount_coa_id: (int) $data['discount_coa_id'] ?? null,
            invt_sub_ledger: (string) $data['invt_sub_ledger'],
            invt_resp_code: (string) $data['invt_resp_code'],
            unbilled_purchase_coa_id: (int) $data['unbilled_purchase_coa_id'] ?? null,
            unbilled_delivery_coa_id: (int) $data['unbilled_delivery_coa_id'] ?? null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
