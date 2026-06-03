<?php

namespace App\Repositories\Master\State;

use App\Repositories\BaseRepository;
use App\Repositories\Master\Country\CountryRepository;
use Illuminate\Database\Query\Builder;

class StateRepository extends BaseRepository
{
    private CountryRepository $countryRepo;
    protected string $table = "precise.state";
    protected string $as = "s";
    protected string $primaryKey = "s.state_id";
    protected array $columns = [
        "s.state_id",   
        "s.state_code",
        "s.state_name",
        "s.country_id",
        "s.created_by",
        "s.created_on",
        "s.updated_by",
        "s.updated_on"
    ];

    public function __construct(CountryRepository $countryRepo)
    {
        $this->countryRepo = $countryRepo;
    }

    public function all(): Builder
    {
        return parent::all()    
            ->addSelect("c.country_name")
            ->join($this->countryRepo->getTable()." as ".$this->countryRepo->getAlias(),
                $this->countryRepo->getPrimaryKey(),
                "=",
                "s.country_id"
            );
    }

    public function find(mixed $id): Builder
    {
        return parent::find($id)->addSelect("c.country_name")
            ->join($this->countryRepo->getTable()." as ".$this->countryRepo->getAlias(),
                $this->countryRepo->getPrimaryKey(),
                "=",
                "s.country_id");
    }
}
