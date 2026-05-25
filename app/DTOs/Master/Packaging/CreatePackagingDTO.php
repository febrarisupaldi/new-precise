<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreatePackagingDTO extends CreatePackagingMasterDTO
{
    // Define properties here
    public CreatePackagingMasterDTO $master;

    /**
     * @var array<CreatePackagingDetailDTO>
     */
    public array $details = [];


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto = parent::fromArray($request->toArray());

        $dto->details = collect(
            $request->input('details', [])
        )->map(fn(array $detail) => CreatePackagingDetailDTO::fromArray($detail))->toArray();
        
        return $dto;
    }
}
