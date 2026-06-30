<?php

namespace App\Repositories\Master\MoldInjection;

use App\Repositories\BaseRepository;
use App\Repositories\Master\Customer\CustomerRepository;
use App\Repositories\Master\MoldStatus\MoldStatusRepository;
use App\Repositories\Master\SteelType\SteelTypeRepository;
use Illuminate\Database\Query\Builder;

class MoldInjectionRepository extends BaseRepository
{
    private SteelTypeRepository $steelTypeRepo;
    private CustomerRepository $customerRepo;
    private MoldStatusRepository $moldStatusRepo;

    protected string $table = 'precise.mold_injection_hd';
    protected string $as = 'mihd';
    protected string $primaryKey = 'mihd.mold_injection_hd_id';
    protected array $columns = [
        'mihd.mold_injection_hd_id',
        'mihd.mold_number',
        'mihd.mmit_code_dont_use',
        'mihd.mold_name',
        'mihd.is_family_mold',
        'mihd.customer_id',
        'mihd.status_code',
        'mihd.remake_from',
        'mihd.production_date',
        'mihd.tonnage_std',
        'mihd.tonnage_min',
        'mihd.tonnage_max',
        'mihd.steel_type_id',
        'mihd.mold_making_id',
        'mihd.mold_maker',
        'mihd.cooling_method_id',
        'mihd.mold_description',
        'mihd.length',
        'mihd.width',
        'mihd.height',
        'mihd.dimension_uom',
        'mihd.plate_size_length',
        'mihd.plate_size_width',
        'mihd.plate_size_uom',
        'mihd.created_on',
        'mihd.created_by',
        'mihd.updated_on',
        'mihd.updated_by',
    ];

    public function __construct(
        SteelTypeRepository $steelTypeRepo, 
        CustomerRepository $customerRepo,
        MoldStatusRepository $moldStatusRepo
        )
    {
        $this->steelTypeRepo = $steelTypeRepo;
        $this->customerRepo = $customerRepo;
        $this->moldStatusRepo = $moldStatusRepo;
    }

    public function all(): Builder
    {
        return parent::all()->addSelect(
            'midt.mold_group',
            'midt.item_code',
            'st.steel_type_name',
            'c.customer_code',
            'c.customer_name',
            'ms.status_description'
        )
        ->leftJoin('precise.mold_injection_dt as midt', 'mihd.mold_injection_hd_id', '=', 'midt.mold_injection_hd_id')
        ->leftJoin($this->customerRepo->table . ' as ' . $this->customerRepo->as, 
            'mihd.customer_id', 
            '=', 
            $this->customerRepo->primaryKey
        )->leftJoin(
            $this->steelTypeRepo->table . ' as ' . $this->steelTypeRepo->as, 
            'mihd.steel_type_id', 
            '=', 
            $this->steelTypeRepo->primaryKey
        )->leftJoin(
            $this->moldStatusRepo->table . ' as ' . $this->moldStatusRepo->as, 
            'mihd.status_code', 
            '=', 
            $this->moldStatusRepo->primaryKey
        );
    }
}
