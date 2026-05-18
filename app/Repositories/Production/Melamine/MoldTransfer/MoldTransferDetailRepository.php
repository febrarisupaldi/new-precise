<?php

namespace App\Repositories\Production\Melamine\MoldTransfer;

use App\Repositories\BaseRepository;

class MoldTransferDetailRepository extends BaseRepository
{
    protected string $table = 'precise.mold_transfer_dt as mtd';
    protected string $primaryKey = 'mtd.mold_transfer_dt_id';
    protected array $columns = [
        "mtd.mold_transfer_dt_id",
        "mtd.mold_transfer_hd_id",
        "mtd.mold_pressing_hd_id",
        "mtd.transfer_type",
        "mtd.transfer_description",
        "mtd.created_on",
        "mtd.created_by",
        "mtd.updated_on",
        "mtd.updated_by"
    ];

    // Add custom repository methods here
}
