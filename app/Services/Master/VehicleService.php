<?php

namespace App\Services\Master;


use App\Repositories\Master\Vehicle\VehicleRepository;
use App\DTOs\Master\Vehicle\CreateVehicleDTO;
use App\DTOs\Master\Vehicle\UpdateVehicleDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class VehicleService
{
    protected VehicleRepository $vehicleRepo;

    public function __construct(VehicleRepository $vehicleRepo)
    {
        $this->vehicleRepo = $vehicleRepo;
    }

    public function all(?array $filters = null)
    {
        return $this->vehicleRepo->all($filters)->get();
    }

    public function find(int $id): ?object
    {
        $result = $this->vehicleRepo->find($id)->first();

        if (!$result) {
            throw new BadRequestException('Vehicle not found', code: 404);
        }
        return $result;
    }

    public function create(CreateVehicleDTO $dto): int
    {
        $id = $this->vehicleRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create vehicle');
        }

        return $id;
    }

    public function update(int $id, UpdateVehicleDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->vehicleRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Vehicle not found', code: 404);
            }
            $this->vehicleRepo->setAuditSession($dto->toAuditArray());
            $success = $this->vehicleRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update vehicle');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->vehicleRepo->exists($conditions);
    }
}
