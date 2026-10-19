<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateMoldPressingDTO extends UpdateMoldPressingMasterDTO
{

    public function __construct(
        public readonly UpdateMoldPressingMasterDTO $master,
        public readonly array $details
    ) {}

    public static function fromRequest(Request $request): static
    {
        $master = parent::fromArray($request->toArray());
        $details = collect(
            $request->input('details', [])
        )->map(fn(array $detail) => UpdateMoldPressingDetailDTO::fromArray($detail))->toArray();

        return new static($master, $details);
    }
}
