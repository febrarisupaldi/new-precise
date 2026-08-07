<?php

namespace App\Repositories\Master\MoldInjection;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class MoldInjectionRepository extends BaseRepository
{
    protected Table $customer;
    protected Table $moldStatus;
    protected Table $steelType;
    protected Table $table;
    protected Table $moldInjectionDetail;
    protected Table $moldInjectionDetailCavity;
    protected Table $coolingMethod;
    protected Table $moldMaking;

    public function __construct()
    {
        $this->customer = table('master', 'customer');
        $this->moldStatus = table('master', 'mold_status');
        $this->steelType = table('master', 'steel_type');
        $this->table = table('master', 'mold_injection.master');
        $this->coolingMethod = table("master", "cooling_method");
        $this->moldMaking = table("master", "mold_making");
        $this->moldInjectionDetail = table("master", "mold_injection.detail");
        $this->moldInjectionDetailCavity = table("master", "mold_injection.detail.cavity");
    }

    private function baseQuery(Builder $query): void
    {
        JoinBuilder::join(
            $query,
            $this->moldInjectionDetail,
            $this->moldInjectionDetail->column("mold_injection_hd_id"),
            '=',
            $this->table->pk()
        );

        JoinBuilder::leftJoin(
            $query,
            $this->moldInjectionDetailCavity,
            $this->moldInjectionDetailCavity->column("mold_injection_dt_id"),
            '=',
            $this->moldInjectionDetail->pk()
        );

        JoinBuilder::leftJoin(
            $query,
            $this->moldMaking,
            $this->moldMaking->pk(),
            '=',
            $this->table->column("mold_making_id")
        );

        JoinBuilder::leftJoin(
            $query,
            $this->coolingMethod,
            $this->coolingMethod->pk(),
            '=',
            $this->table->column("cooling_method_id")
        );

        JoinBuilder::leftJoin(
            $query,
            $this->customer,
            $this->table->column("customer_id"),
            '=',
            $this->customer->pk()
        );

        JoinBuilder::leftJoin(
            $query,
            $this->moldStatus,
            $this->table->column("status_code"),
            '=',
            $this->moldStatus->pk()
        );

        JoinBuilder::leftJoin(
            $query,
            $this->steelType,
            $this->table->column("steel_type_id"),
            '=',
            $this->steelType->pk()
        );
    }

    public function all(): Builder
    {
        $query = parent::all();
        $this->baseQuery($query);

        return $query->addSelect(
            $this->moldInjectionDetailCavity->column("mold_injection_cavity_id"),
            $this->moldInjectionDetail->column("mold_group"),
            $this->moldInjectionDetail->column("item_code"),
            $this->moldInjectionDetail->column("item_description"),
            $this->steelType->column("steel_type_name"),
            $this->customer->column("customer_code"),
            $this->customer->column("customer_name"),
            $this->moldInjectionDetailCavity->column("cavity_number"),
            $this->moldInjectionDetailCavity->column("product_weight"),
            $this->moldInjectionDetailCavity->column("product_weight_uom"),
            $this->coolingMethod->column("cooling_method_name"),
            $this->moldStatus->column("status_description"),
            $this->moldMaking->column("estimation_number")
        );
    }
}
