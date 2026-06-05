<?php

namespace App\Repositories\Master\AddressType;

use App\Repositories\BaseRepository;

class AddressTypeRepository extends BaseRepository
{
    protected string $table = "precise.address_type";
    protected string $as = "at";
    protected string $primaryKey = "at.address_type_id";
    protected array $columns = [
        "at.address_type_id",
        "at.address_type_name",
        "at.address_type_description",
        "at.created_by",
        "at.created_on",
        "at.updated_by",
        "at.updated_on"
    ];
}
