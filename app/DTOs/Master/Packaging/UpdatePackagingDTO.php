<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdatePackagingDTO extends UpdatePackagingMasterDTO
{
    // Define properties here
    public UpdatePackagingMasterDTO $master;

    /**
     * @var array<UpdatePackagingDetailDTO>
     */
    public array $details = [];


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto = parent::fromArray($request->toArray());
        $dto->details = collect(
            $request->input('details', [])
        )->map(fn(array $detail) => UpdatePackagingDetailDTO::fromArray($detail))->toArray();
        
        return $dto;
    }
}
