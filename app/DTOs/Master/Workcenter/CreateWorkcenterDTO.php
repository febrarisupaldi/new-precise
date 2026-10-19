<?php

namespace App\DTOs\Master\Workcenter;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateWorkcenterDTO extends BaseDTO
{

    public function __construct(
        public readonly string $workcenter_code,
        public readonly string $workcenter_name,
        public readonly ?string $workcenter_description,
        public readonly ?int $default_warehouse,
        public readonly ?string $production_type,
        public readonly ?string $production_center,
        public readonly ?int $subprocess_level,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            workcenter_code: (string) strtoupper($request->input('workcenter_code')),
            workcenter_name: (string) $request->input('workcenter_name'),
            workcenter_description: (string) $request->input('workcenter_description'),
            default_warehouse: (int) $request->input('default_warehouse'),
            production_type: (string) $request->input('production_type'),
            production_center: (string) $request->input('production_center'),
            subprocess_level: (int) $request->input('subprocess_level'),
            is_active: (bool) $request->input('is_active'),
            created_by: (string) $request->input('created_by')
        );
    }
}
