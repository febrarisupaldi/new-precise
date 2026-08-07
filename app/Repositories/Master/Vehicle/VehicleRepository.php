<?php

namespace App\Repositories\Master\Vehicle;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class VehicleRepository extends BaseRepository
{
    protected Table $table;
    public function __construct()
    {
        $this->table = table("master", "vehicle");
    }

    public function all(?array $filters = null): Builder
    {
        return parent::all()
            ->when($filters['license_number'] ?? null, function ($query) use ($filters) {
                return $query->where($this->table->column('license_number'), $filters['license_number']);
            });
    }
}
