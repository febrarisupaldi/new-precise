<?php

namespace App\Services\Master;


use App\Repositories\Master\Customer\CustomerRepository;
use App\DTOs\Master\Customer\CreateCustomerDTO;
use App\DTOs\Master\Customer\UpdateCustomerDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    protected CustomerRepository $customerRepo;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function all(): object
    {
        return $this->customerRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->customerRepo->find($id)->first();
    }

    public function findWithAddresses(string $customerIDs): ?object
    {
        $customers = explode("-", $customerIDs);
        $data = $this->customerRepo->findAddressesByCustomerIDs($customers)->get();

        if ($data->isEmpty()) {
            throw new BadRequestException('Customer Address not found', code: 404);
        }
        return $data;
    }

    public function create(CreateCustomerDTO $dto): mixed
    {
        $id = $this->customerRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Customer');
        }

        return $id;
    }

    public function update(int $id, UpdateCustomerDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->customerRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Customer not found', code: 404);
            }
            // $this->customerRepo->setAuditSession($dto->toAuditArray());
            // $success = $this->customerRepo->update($id, $dto->withoutAuditArray());

            // if ($success === false) {
            //     throw new Exception('Failed to update Customer');
            // }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->customerRepo->exists($conditions);
    }
}
