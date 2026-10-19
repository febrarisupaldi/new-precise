<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdatePackagingDTO extends UpdatePackagingMasterDTO
{

    public function __construct(
        public readonly UpdatePackagingMasterDTO $master,
        public readonly array $details
    ) {}


    public static function fromRequest(Request $request): static
    {
        $master = parent::fromArray($request->toArray());
        $details = collect(
            $request->input('details', [])
        )->map(fn(array $detail) => UpdatePackagingDetailDTO::fromArray($detail))->toArray();

        return new static($master, $details);
    }
}
