<?php

namespace App\Repositories\Master\MoldPressing;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use App\Repositories\Master\MoldStatus\MoldStatusRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MoldPressingDetailRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'mold_pressing.detail');
    }

    public function findByMasterID(string|int $id): Builder
    {
        if (is_numeric($id)) {
            $query = parent::findByColumn([$this->table->column("mold_pressing_hd_id") => $id]);
        } else {

            $master = table("master", "mold_pressing.master");
            $query = parent::findByColumn([$master->column("mold_number") => $id]);

            JoinBuilder::join(
                $query,
                $master,
                $this->table->column('mold_pressing_hd_id'),
                '=',
                $master->column('mold_pressing_hd_id')
            );
        }

        return $query;
    }
    // Add custom repository methods here
}
