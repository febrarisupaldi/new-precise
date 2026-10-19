<?php

namespace App\DTOs\Engineering\MoldPressingActivity;


use App\DTOs\Traits\AuditDTO;
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateMoldPressingActivityDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly int $mold_pressing_hd_id,
        public readonly string $activity_date,
        public readonly string $activity_type,
        public readonly string $location,
        public readonly ?string $description,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}


    public static function fromRequest(Request $request): static
    {
        return new static(
            mold_pressing_hd_id: (int) $request->input('mold_pressing_hd_id'),
            activity_date: (string) $request->input('activity_date') ?? $request->input('trans_date'),
            activity_type: (string) $request->input('mold_status_code'),
            location: (string) $request->input('location'),
            description: (string) $request->input('description'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
