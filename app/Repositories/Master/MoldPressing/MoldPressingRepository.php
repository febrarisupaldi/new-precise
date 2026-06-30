<?php

namespace App\Repositories\Master\MoldPressing;

use App\Repositories\BaseRepository;
use App\Repositories\Master\MoldStatus\MoldStatusRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MoldPressingRepository extends BaseRepository
{
    private MoldStatusRepository $moldStatusRepo;
    private MoldPressingDetailRepository $moldPressingDetailRepo;
    
    protected string $table = 'precise.mold_pressing_hd'; 
    protected string $as = 'mphd';
    protected string $primaryKey = 'mphd.mold_pressing_hd_id';
    protected array $columns = [
        'mphd.mold_pressing_hd_id',
        'mphd.mold_number',
        'mphd.mold_code',
        'mphd.mold_group',
        'mphd.mold_rack',
        'mphd.mold_location',
        'mphd.item_code',
        'mphd.default_tonnage',
        'mphd.mold_description',
        'mphd.mold_status_code',
        'mphd.mold_parent_id',
        'mphd.production_date',
        'mphd.mold_making_id',
        'mphd.mold_maker',
        'mphd.created_on',
        'mphd.created_by',
        'mphd.updated_on',
        'mphd.updated_by'
    ];

    public function __construct(
        MoldStatusRepository $moldStatusRepo,
        MoldPressingDetailRepository $moldPressingDetailRepo
    ){
        $this->moldStatusRepo = $moldStatusRepo;
        $this->moldPressingDetailRepo = $moldPressingDetailRepo;
    }

    public function all(?array $filters = []): Builder{
        return parent::all()->addSelect(
            "ms.status_description"
        )
        ->leftJoin(
            $this->moldStatusRepo->table . ' as ' . $this->moldStatusRepo->as,
            'mphd.mold_status_code',
            '=',
            $this->moldStatusRepo->primaryKey
        )->when($filters['number'] ?? null, function($query) use($filters){
            return $query->where("mphd.mold_number", $filters['number']);
        })
        ->when($filters['with'] ?? null, function($query) use($filters){
            return $query->addSelect(
                "mpdt.mold_pressing_dt_id",
                "mpdt.cavity_number",
                "mpdt.product_weight",
                "mpdt.product_weight_uom",
                "mpdt.is_active"
            )
            ->leftJoin(
                $this->moldPressingDetailRepo->table . ' as ' . $this->moldPressingDetailRepo->as,
                $this->primaryKey,
                '=',
                'mpdt.mold_pressing_hd_id'
            );
        })
        ->when($filters['code'] ?? null, function($query) use($filters){
            return $query->addSelect(
                "mpdt.product_weight",
                "mpdt.product_weight_uom",
                DB::raw("group_concat(mpdt.cavity_number ORDER BY mpdt.cavity_number SEPARATOR ',') AS cavities"))
            ->leftJoin(
                $this->moldPressingDetailRepo->table . ' as ' . $this->moldPressingDetailRepo->as,
                $this->primaryKey,
                '=',
                'mpdt.mold_pressing_hd_id'
            )->where("mphd.mold_code", 'like' , '%'.$filters['code'].'%')
            ->groupBy("mphd.mold_pressing_hd_id", "mphd.mold_number", "mpdt.product_weight", "mpdt.product_weight_uom");
        });
        ;
    }

    public function find(int|string $id): Builder
    {
        if(is_int($id)){
            $query = parent::find($id);
        }else{
            $this->setPrimaryKey("mphd.mold_number");
            $query = parent::find($id);
        }

        return $query;
    }
    // Add custom repository methods here
}
