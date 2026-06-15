<?php

namespace App\DTOs\Master\MoldStatus;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldStatusDTO extends BaseDTO
{
    public string $status_code;
    public string $status_description;
    public bool $is_active;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->status_code = $request->input('status_code');
        $dto->status_description = $request->input('status_description');
        $dto->is_active = $request->input('is_active');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
