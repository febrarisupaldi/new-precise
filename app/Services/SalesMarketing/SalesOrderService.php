<?php

namespace App\Services\SalesMarketing;

use App\DTOs\ExistsDTO;
use App\Repositories\SalesMarketing\SalesOrderRepository;
use App\DTOs\SalesMarketing\CreateSalesOrderDTO;
use App\DTOs\SalesMarketing\UpdateSalesOrderDTO;

class SalesOrderService
{
    protected $salesOrderRepo;

    public function __construct(SalesOrderRepository $salesOrderRepo)
    {
        $this->salesOrderRepo = $salesOrderRepo;
    }

    public function all()
    {
        return $this->salesOrderRepo->all();
    }

    public function find($id)
    {
        return $this->salesOrderRepo->find($id);
    }

    public function create(CreateSalesOrderDTO $dto): array
    {
        $success = $this->salesOrderRepo->create($dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'SalesOrder created successfully.' : 'Failed to create SalesOrder.',
        ];
    }

    public function update($id, UpdateSalesOrderDTO $dto): array
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
        return $this->salesOrderRepo->checkExists($dto->columns, $dto->values);
    }
}
