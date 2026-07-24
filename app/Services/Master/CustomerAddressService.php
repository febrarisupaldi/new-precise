<?php

namespace App\Services\Master;


use App\Repositories\Master\CustomerAddress\CustomerAddressRepository;
use App\DTOs\Master\CustomerAddress\CreateCustomerAddressDTO;
use App\DTOs\Master\CustomerAddress\UpdateCustomerAddressDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerAddressService
{
    protected CustomerAddressRepository $customerAddressRepo;

    public function __construct(CustomerAddressRepository $customerAddressRepo)
    {
        $this->customerAddressRepo = $customerAddressRepo;
    }

    public function index(callable $callback): void
    {
        $this->customerAddressRepo->index($callback);
    }

    public function show(int $id): ?object
    {
        $data = $this->customerAddressRepo->find($id)->first();
        if (!$data) {
            throw new BadRequestException('Customer Address not found.', code: 404);
        }

        return $data;
    }

    public function create(CreateCustomerAddressDTO $dto): mixed
    {
        $id = $this->customerAddressRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create CustomerAddress');
        }

        return $id;
    }

    public function update(int $id, UpdateCustomerAddressDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->customerAddressRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('CustomerAddress not found', code: 404);
            }
            $this->customerAddressRepo->setAuditSession($dto->toAuditArray());
            $success = $this->customerAddressRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update CustomerAddress');
            }
        });
    }

    public function delete(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $exists = $this->customerAddressRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('CustomerAddress not found', code: 404);
            }
            $this->customerAddressRepo->setAuditSession($data);
            $success = $this->customerAddressRepo->delete($id, $data);

            if ($success === false) {
                throw new Exception('Failed to delete CustomerAddress');
            }
        });
    }
}
