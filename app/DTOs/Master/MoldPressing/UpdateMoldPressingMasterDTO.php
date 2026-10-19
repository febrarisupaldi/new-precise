<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateMoldPressingMasterDTO extends BaseDTO
{

    use AuditDTO;

    public function __construct(
        public readonly string $mold_number,
        public readonly string $mold_code,
        public readonly string $mold_group,
        public readonly ?string $mold_rack,
        public readonly ?string $mold_location,
        public readonly string $item_code,
        public readonly int $default_tonnage,
        public readonly ?string $mold_description,
        public readonly string $mold_status_code,
        public readonly ?int $mold_parent_id,
        public readonly string $production_date,
        public readonly ?int $mold_making_id,
        public readonly ?string $mold_maker,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}


    public static function fromRequest(Request $request): static
    {
        return new static(
            mold_number: (string) $request->input('mold_number'),
            mold_code: (string) $request->input('mold_code'),
            mold_group: (string) $request->input('mold_group'),
            mold_rack: (string) $request->input('mold_rack'),
            mold_location: (string) $request->input('mold_location'),
            item_code: (string) $request->input('item_code'),
            default_tonnage: (int) $request->input('default_tonnage'),
            mold_description: (string) $request->input('mold_description'),
            mold_status_code: (string) $request->input('mold_status_code'),
            mold_parent_id: (int) $request->input('mold_parent_id'),
            production_date: (string) $request->input('production_date'),
            mold_making_id: (int) $request->input('mold_making_id'),
            mold_maker: (string) $request->input('mold_maker'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
