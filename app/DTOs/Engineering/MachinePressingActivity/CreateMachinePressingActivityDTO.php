<?php

namespace App\DTOs\Engineering\MachinePressingActivity;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMachinePressingActivityDTO extends BaseDTO
{
    public int $machine_pressing_id;
    public ?int $mold_pressing_hd_id;
    public string $trans_date;
    public string $activity_date;
    public ?string $machine_status_code;
    public ?string $mold_status_code;
    public ?string $setter_mold_nik;
    public int $shift;
    public string $activity_location;
    public string $description;
    public string $created_by;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->machine_pressing_id = $request->input('machine_pressing_id');
        $dto->mold_pressing_hd_id = $request->input('mold_pressing_hd_id');
        $dto->activity_date = $request->input("activity_date");
        $dto->trans_date = $request->input('trans_date');
        $dto->shift = (int) $request->input('shift');
        $dto->activity_location = $request->input('activity_location');
        $dto->setter_mold_nik = $request->input('setter_mold_nik');
        $dto->machine_status_code = $request->input('machine_status_code');
        $dto->mold_status_code = $request->input('mold_status_code');
        $dto->description = $request->input('description');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
