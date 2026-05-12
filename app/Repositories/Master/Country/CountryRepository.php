<?php

namespace App\Repositories\Master\Country;

use App\Repositories\BaseRepository;

class CountryRepository extends BaseRepository
{
    protected string $table = "precise.country";
    protected string $primaryKey = "country_id";
    protected array $columns = [
        "precise.country.country_id",
        "precise.country.country_code",
        "precise.country.country_name",
        "precise.country.created_by",
        "precise.country.created_on",
        "precise.country.updated_by",
        "precise.country.updated_on"
    ];
}
