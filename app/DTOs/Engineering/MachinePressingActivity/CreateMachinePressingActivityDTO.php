<?php

namespace App\DTOs\Engineering\MachinePressingActivity;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMachinePressingActivityDTO extends BaseDTO
{

    public function __construct(
        public readonly int $machine_pressing_id,
        public readonly ?int $mold_pressing_hd_id,
        public readonly ?string $trans_date,
        public readonly ?string $activity_date,
        public readonly ?string $machine_status_code,
        public readonly ?string $mold_status_code,
        public readonly ?string $setter_mold_nik,
        public readonly ?int $shift,
        public readonly ?string $location,
        public readonly ?string $description,
        public readonly string $created_by
    ) {}


    public static function fromRequest(Request $request): static
    {
        return new static(
            machine_pressing_id: (int) $request->input('machine_pressing_id'),
            mold_pressing_hd_id: (int) $request->input('mold_pressing_hd_id'),
            activity_date: (string) $request->input("activity_date"),
            trans_date: (string) $request->input('trans_date'),
            shift: (int) $request->input('shift'),
            location: (string) $request->input('location'),
            setter_mold_nik: (string) $request->input('setter_mold_nik'),
            machine_status_code: (string) $request->input('machine_status_code'),
            mold_status_code: (string) $request->input('mold_status_code'),
            description: (string) $request->input('description'),
            created_by: (string) $request->input('created_by')
        );
    }
}
