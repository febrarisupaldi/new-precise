<?php

namespace App\DTOs\Traits;

use Illuminate\Support\Arr;

trait AuditDTO
{
    public function toAuditArray(): array
    {
        return Arr::only($this->toArray(), ['updated_by', 'reason']);
    }

    public function withoutAuditArray(): array
    {
        return Arr::except($this->toArray(), ['reason']);
    }
}
