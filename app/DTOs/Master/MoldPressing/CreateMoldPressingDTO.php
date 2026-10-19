<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldPressingDTO extends CreateMoldPressingMasterDTO
{
    public function __construct(
        public readonly CreateMoldPressingMasterDTO $master,
        public readonly array $details
    ) {}

    public static function fromRequest(Request $request): static
    {
        $master = parent::fromArray($request->toArray());
        $details = collect(
            $request->input('details', [])
        )->map(fn(array $detail) => CreateMoldPressingDetailDTO::fromArray($detail))->toArray();

        return new static($master, $details);
    }
}
