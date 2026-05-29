<?php

namespace App\Services\SalesMarketing;

use App\DTOs\ExistsDTO;
use App\DTOs\SalesMarketing\SalesOrder\CreateSalesOrderDTO;
use App\DTOs\SalesMarketing\SalesOrder\UpdateSalesOrderDTO;
use App\Repositories\SalesMarketing\SalesOrder\SalesOrderRepository;
use Illuminate\Support\Facades\DB;

class SalesOrderService
{
    protected SalesOrderRepository $salesOrderRepo;

    public function __construct(SalesOrderRepository $salesOrderRepo)
    {
        $this->salesOrderRepo = $salesOrderRepo;
    }

    public function all(string $start, string $end): object
    {
        return $this->salesOrderRepo->allWithFilter([
            'start' => $start,
            'end' => $end
        ])->get();
    }

    public function find(int $id)
    {
        return $this->salesOrderRepo->find($id);
    }

    public function create(CreateSalesOrderDTO $dto): array
    {
        $success = $this->salesOrderRepo->insert($dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'SalesOrder created successfully.' : 'Failed to create SalesOrder.',
        ];
    }

    public function update(int $id, UpdateSalesOrderDTO $dto): array
    {
        return DB::transaction(function () use ($id, $dto) {
            $exists = $this->salesOrderRepo->find($id);

            if (!$exists) {
                return ['success' => false, 'message' => 'SalesOrder not found.'];
            }

            $affected = $this->salesOrderRepo->update($id, $dto->toArray());

            return [
                'success' => $affected >= 0,
                'message' => 'SalesOrder updated successfully.',
            ];
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->salesOrderRepo->exists($dto->columns, $dto->values);
    }
}
