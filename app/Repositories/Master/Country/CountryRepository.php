<?php

namespace App\Repositories\Master\Country;

use App\Repositories\BaseRepository;

class CountryRepository extends BaseRepository
{
    protected string $table = "precise.country";
    protected string $as = "c";
    protected string $primaryKey = "c.country_id";
    protected array $columns = [
        "c.country_id",
        "c.country_code",
        "c.country_name",
        "c.created_by",
        "c.created_on",
        "c.updated_by",
        "c.updated_on"
    ];
}
