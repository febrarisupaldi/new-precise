<?php

namespace App\Repositories\Master\SteelType;

use App\Repositories\BaseRepository;

class SteelTypeRepository extends BaseRepository
{
    protected string $table = "precise.steel_type";
    protected string $as = "st";
    protected string $primaryKey = "st.steel_type_id";
    protected array $columns = [
        "st.steel_type_id",
        "st.steel_type_name",
        "st.is_active",
        "st.created_by",
        "st.created_on",
        "st.updated_by",
        "st.updated_on"
    ];
}
