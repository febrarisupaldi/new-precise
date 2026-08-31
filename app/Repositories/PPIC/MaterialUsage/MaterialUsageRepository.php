<?php

namespace App\Repositories\PPIC\MaterialUsage;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Override;

class MaterialUsageRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("ppic", "material_usage");
    }

    #[Override]
    public function all(?array $filters = null): Builder
    {
        if ($filters) {
        }
        return parent::all();
    }
}
