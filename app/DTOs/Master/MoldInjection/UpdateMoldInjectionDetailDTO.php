<?php

namespace App\DTOs\Master\MoldInjection;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateMoldInjectionDetailDTO extends BaseDTO
{
    use AuditDTO;
    // Define properties here

    public function __construct(
        public readonly ?int $mold_injection_hd_id,
        public readonly ?int $mold_group,
        public readonly ?int $item_id,
        public readonly ?string $item_code,
        public readonly ?string $item_description,
        public readonly string $updated_by,
        public readonly ?array $deleted_mold_detail_id,
        public readonly array $cavities
    ) {}

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }

    public static function fromArray(array $data): static
    {
        $cavities = collect(
            $data['cavities'] ?? []
        )->map(fn(array $cavity) => UpdateMoldInjectionDetailCavityDTO::fromArray($cavity))->toArray();

        return new static(
            mold_injection_hd_id: (int) $data['mold_injection_hd_id'],
            mold_group: (int) $data['mold_group'],
            item_id: (int) $data['item_id'],
            item_code: (string) $data['item_code'],
            item_description: (string) $data['item_description'],
            updated_by: (string) $data['updated_by'],
            deleted_mold_detail_id: (array) $data['deleted_mold_detail_id'],
            cavities: $cavities
        );
    }
}
