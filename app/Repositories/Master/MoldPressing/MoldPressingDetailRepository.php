<?php

namespace App\Repositories\Master\MoldPressing;

use App\Repositories\BaseRepository;
use App\Repositories\Master\MoldStatus\MoldStatusRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MoldPressingDetailRepository extends BaseRepository
{
    private MoldStatusRepository $moldStatusRepo;
    
    protected string $table = 'precise.mold_pressing_dt'; 
    protected string $as = 'mpdt';
    protected string $primaryKey = 'mphd.mold_pressing_dt_id';
    protected array $columns = [
        'mpdt.mold_pressing_dt_id',
        'mpdt.mold_pressing_hd_id',
        'mpdt.mold_code',
        'mpdt.cavity_number',
        'mpdt.product_weight',
        'mpdt.product_weight_uom',
        'mpdt.is_active',
        'mpdt.created_on',
        'mpdt.created_by',
        'mpdt.updated_on',
        'mpdt.updated_by'
    ];

    public function __construct(
        MoldStatusRepository $moldStatusRepo
    ){
        $this->moldStatusRepo = $moldStatusRepo;
    }

    public function findByMasterID(string|int $id): Builder{
        $query = DB::table("precise.mold_pressing_dt as mpdt")
            ->select(
                'mpdt.mold_pressing_dt_id',
                'mpdt.mold_pressing_hd_id',
                'mpdt.mold_code',
                'mpdt.cavity_number',
                'mpdt.product_weight',
                'mpdt.product_weight_uom',
                'mpdt.is_active',
                'mpdt.created_on',
                'mpdt.created_by',
                'mpdt.updated_on',
                'mpdt.updated_by'
            );
        if(is_int($id)){
            $query->where("mpdt.mold_pressing_hd_id", $id);
        }else{
            $query->leftJoin(
                "precise.mold_pressing_hd as mphd",
                'mpdt.mold_pressing_hd_id',
                '=',
                "mphd.mold_pressing_hd_id"
            )
            ->where("mphd.mold_number", $id);
        }

        return $query;
    }
    // Add custom repository methods here
}
