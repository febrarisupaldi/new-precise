<?php

namespace App\Repositories\Master\Country;

use App\Repositories\BaseRepository;

class CountryRepository extends BaseRepository
{
    protected string $table = "precise.country";
    protected string $primaryKey = "country_id";
    protected array $columns = [
        "country_id",
        "country_code",
        "country_name",
        "created_by",
        "created_on",
        "updated_by",
        "updated_on"
    ];
}
