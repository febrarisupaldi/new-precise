<?php

namespace App\DTOs\Engineering\MoldPressingActivity;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldPressingActivityDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public int $mold_pressing_hd_id;
    public string $activity_date;
    public string $activity_type;
    public string $location;
    public ?string $description;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->mold_pressing_hd_id = (int) $request->input('mold_pressing_hd_id');
        $dto->activity_date = $request->input('activity_date');
        $dto->activity_type = $request->input('mold_status_code');
        $dto->location = $request->input('activity_location');
        $dto->description = $request->input('description');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
