<?php

namespace App\Repositories\Master\Vehicle;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class VehicleRepository extends BaseRepository
{
    protected string $table = 'precise.vehicle';
    protected string $primaryKey = 'vehicle_id';
    protected array $columns = [
        "vehicle_id",
        "vehicle_model",
        "license_number",
        "vehicle_description",
        "is_owned",
        "is_active",
        "created_on",
        "created_by",
        "updated_on",
        "updated_by"
    ];

    // Add custom repository methods here
    public function findByLicenseNumber(string $licenseNumber): Builder
    {
        return DB::table($this->table)->where('license_number', $licenseNumber)->select($this->columns);
    }
}
