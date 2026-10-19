<?php

namespace App\DTOs\Master\MoldInjection;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldInjectionDetailDTO extends BaseDTO
{

    public function __construct(
        public readonly ?int $mold_injection_hd_id,
        public readonly ?int $mold_group,
        public readonly ?int $item_id,
        public readonly ?string $item_code,
        public readonly ?string $item_description,
        public readonly string $created_by,
        public readonly array $cavities
    ) {}


    public static function fromArray(array $data): static
    {
        $cavities = collect(
            $data['cavities'] ?? []
        )->map(fn(array $cavity) => CreateMoldInjectionDetailCavityDTO::fromArray($cavity))->toArray();

        return new static(
            mold_injection_hd_id: null,
            mold_group: (int) $data['mold_group'],
            item_id: (int) $data['item_id'],
            item_code: (string) $data['item_code'],
            item_description: (string) $data['item_description'],
            created_by: (string) $data['created_by'],
            cavities: $cavities
        );
    }

    public function withMoldInjectionId(int $moldId): static
    {
        return new static(
            mold_injection_hd_id: $moldId,
            mold_group: $this->mold_group,
            item_id: $this->item_id,
            item_code: $this->item_code,
            item_description: $this->item_description,
            created_by: $this->created_by,
            cavities: $this->cavities
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
