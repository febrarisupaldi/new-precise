<?php

namespace App\Services\SalesMarketing;


use App\DTOs\SalesMarketing\SalesOrder\CreateSalesOrderDTO;
use App\DTOs\SalesMarketing\SalesOrder\UpdateSalesOrderDTO;
use App\Exceptions\BadRequestException;
use App\Repositories\SalesMarketing\SalesOrder\SalesOrderDetailRepository;
use App\Repositories\SalesMarketing\SalesOrder\SalesOrderRepository;
use Illuminate\Support\Facades\DB;

class SalesOrderService
{
    private SalesOrderRepository $salesOrderRepo;
    private SalesOrderDetailRepository $salesOrderDetailRepo;

    public function __construct(
        SalesOrderRepository $salesOrderRepo,
        SalesOrderDetailRepository $salesOrderDetailRepo
    ) {
        $this->salesOrderRepo = $salesOrderRepo;
        $this->salesOrderDetailRepo = $salesOrderDetailRepo;
    }

    public function all(string $start, string $end): object
    {
        return $this->salesOrderRepo->allWithFilter([
            'start' => $start,
            'end' => $end
        ])->get();
    }

    public function find(int $id): ?object
    {
        $data = $this->salesOrderRepo->find($id)->first();
        if (!$data) {
            throw new BadRequestException('Sales Order data not found.', code: 404);
        }

        $details = $this->salesOrderDetailRepo->findByMasterID($id)->get();
        $data->details = $details;
        return $data;
    }

    public function findBySalesNumber(string $number): ?object
    {
        $data = $this->salesOrderRepo->allWithFilter(['number' => $number])->first();
        if (!$data) {
            throw new BadRequestException('Sales Order data not found.', code: 404);
        }

        $details = $this->salesOrderDetailRepo->findByMasterID($number)->get();
        $data->details = $details;
        return $data;
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

    public function checkExist(array $conditions): bool
    {
        return $this->salesOrderRepo->exists($dto->columns, $dto->values);
    }
}
