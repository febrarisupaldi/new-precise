<?php

namespace App\Repositories\Master\CompanyType;

use App\Repositories\BaseRepository;

class CompanyTypeRepository extends BaseRepository
{
    protected string $table = "precise.company_type";
    protected string $as = "ct";
    protected string $primaryKey = "ct.company_type_id";
    protected array $columns = [
        "ct.company_type_id",
        "ct.company_type_name",
        "ct.company_type_description",
        "ct.created_by",
        "ct.created_on",
        "ct.updated_by",
        "ct.updated_on"
    ];
    protected array $allowedExistsColumns = [
        ["company_type_code"]
    ];
}
