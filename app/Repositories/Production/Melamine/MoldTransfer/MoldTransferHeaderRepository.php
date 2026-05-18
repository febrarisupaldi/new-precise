<?php

namespace App\Repositories\Production\Melamine\MoldTransfer;

use App\Repositories\BaseRepository;

class MoldTransferHeaderRepository extends BaseRepository
{
    protected string $table = 'precise.mold_transfer_hd as mth';
    protected string $primaryKey = 'mold_transfer_hd_id';
    protected array $columns = [
        "mth.mold_transfer_hd_id",
        "mth.transfer_number",
        "mth.transfer_date",
        "mth.sender",
        "mth.receiver",
        "mth.transfer_from",
        "mth.transfer_to",
        "mth.transfer_status",
        "mth.created_on",
        "mth.created_by",
        "mth.updated_on",
        "mth.updated_by"
    ];

    // Add custom repository methods here
}
