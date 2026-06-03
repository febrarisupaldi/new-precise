<?php

namespace App\Repositories\Master\Packaging;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PackagingDetailRepository extends BaseRepository
{
    protected string $table = 'precise.packaging_dt';
    protected string $as = 'dt';
    protected string $primaryKey = 'dt.packaging_dt_id';

    protected array $columns = [
        'dt.packaging_dt_id',
        'dt.packaging_id',
        'dt.product_id',
        'dt.item_id',
        'dt.item_code',
        'dt.product_qty',
        'dt.priority',
        'dt.usage_per_unit',
        'dt.created_on',
        'dt.created_by',
        'dt.updated_on',
        'dt.updated_by'
    ];

    public function findByHeaderID(int $id): Builder{
        return DB::table($this->table)
            ->where("dt.packaging_id", $id);
    }

    public function bulkUpdateDetails(array $rows): void{
        if (empty($rows)) return;

        $ids = collect($rows)->pluck("packaging_dt_id")->implode(',');

        $productIdCases = '';
        $itemIdCases = '';
        $itemCodeCases = '';
        $productQtyCases = '';
        $priorityCases = '';
        $usagePerUnitCases = '';
        $updatedByCases = '';

        foreach($rows as $row){
            $itemId = $row['item_id'] != 0 ? $row['item_id'] : 'NULL';
            $productIdCases .= "WHEN packaging_dt_id = {$row['packaging_dt_id']} THEN {$row['product_id']} ";
            $itemIdCases .= "WHEN packaging_dt_id = {$row['packaging_dt_id']} THEN {$itemId} ";
            $itemCodeCases .= "WHEN packaging_dt_id = {$row['packaging_dt_id']} THEN '{$row['item_code']}' ";
            $productQtyCases .= "WHEN packaging_dt_id = {$row['packaging_dt_id']} THEN {$row['product_qty']} ";
            $priorityCases .= "WHEN packaging_dt_id = {$row['packaging_dt_id']} THEN {$row['priority']} ";
            $usagePerUnitCases .= "WHEN packaging_dt_id = {$row['packaging_dt_id']} THEN {$row['usage_per_unit']} ";
            $updatedByCases .= "WHEN packaging_dt_id = {$row['packaging_dt_id']} THEN '{$row['updated_by']}' ";
        }

        $sql = "
            UPDATE {$this->table} AS dt
            SET
                product_id = CASE {$productIdCases} END,
                item_id = CASE {$itemIdCases} END,
                item_code = CASE {$itemCodeCases} END,
                product_qty = CASE {$productQtyCases} END,
                priority = CASE {$priorityCases} END,
                usage_per_unit = CASE {$usagePerUnitCases} END,
                updated_by = CASE {$updatedByCases} END
            WHERE pd.packaging_dt_id IN ({$ids})";

        DB::update($sql);
    }

    public function bulkDeleteDetails(array $ids): void {
        if (empty($ids)) return;
        DB::table($this->table, $this->as)->whereIn('dt.packaging_dt_id', $ids)->delete();
    }
}
