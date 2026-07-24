<?php

namespace App\Repositories\Master\City;

use App\Repositories\BaseRepository;
use App\Repositories\Master\State\StateRepository;
use Illuminate\Database\Query\Builder;

class CityRepository extends BaseRepository
{
    private StateRepository $stateRepo;
    protected string $table = 'precise.city';
    protected string $as = "c";
    protected string $primaryKey = "c.city_id";
    protected array $columns = [
        "c.city_id",
        "c.city_name",
        "c.state_id",
        "c.created_by",
        "c.created_on",
        "c.updated_by",
        "c.updated_on"
    ];
    protected array $allowedExistsColumns = [
        ["city_name"],
        ["city_code"]
    ];

    public function __construct(StateRepository $stateRepo)
    {
        $this->stateRepo = $stateRepo;
    }

    public function all(): Builder
    {
        return parent::all()
            ->addSelect("s.state_name")
            ->join(
                $this->stateRepo->getTable() . " as " . $this->stateRepo->getAlias(),
                $this->stateRepo->getPrimaryKey(),
                "=",
                "c.state_id"
            );
    }

    public function find(mixed $id): Builder
    {
        return parent::find($id)->addSelect("s.state_name")
            ->join(
                $this->stateRepo->getTable() . " as " . $this->stateRepo->getAlias(),
                $this->stateRepo->getPrimaryKey(),
                "=",
                "c.state_id"
            );
    }
}
