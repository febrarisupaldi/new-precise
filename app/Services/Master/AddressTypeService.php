<?php

namespace App\Services\Master;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\AddressType\AddressTypeRepository;
use App\DTOs\Master\AddressType\CreateAddressTypeDTO;
use App\DTOs\Master\AddressType\UpdateAddressTypeDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class AddressTypeService
{
    protected AddressTypeRepository $addressTypeRepo;

    public function __construct(AddressTypeRepository $addressTypeRepo)
    {
        $this->addressTypeRepo = $addressTypeRepo;
    }

    public function all(): object
    {
        return $this->addressTypeRepo->all()->get();
    }

    public function find(mixed $id): object
    {
        $data = $this->addressTypeRepo->find($id)->first();
        if (!$data) {
            throw new BadRequestException('Address Type not found.', code: 404);
        }

        return $data;
    }

    public function create(CreateAddressTypeDTO $dto): int
    {
        $id = $this->addressTypeRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Address Type', code: 400);
        }

        return $id;
    }

    public function update(mixed $id, UpdateAddressTypeDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->addressTypeRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Address Type not found', code: 404);
            }
            $this->addressTypeRepo->setAuditSession($dto->toAuditArray());
            $success = $this->addressTypeRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Address Type');
            }
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->addressTypeRepo->exists($dto->columns, $dto->values);
    }
}
