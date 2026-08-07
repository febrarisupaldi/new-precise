<?php

namespace App\Services\Master;


use App\Repositories\Master\CompanyType\CompanyTypeRepository;
use App\DTOs\Master\CompanyType\CreateCompanyTypeDTO;
use App\DTOs\Master\CompanyType\UpdateCompanyTypeDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class CompanyTypeService
{
    protected CompanyTypeRepository $companyTypeRepo;

    public function __construct(CompanyTypeRepository $companyTypeRepo)
    {
        $this->companyTypeRepo = $companyTypeRepo;
    }

    public function all(): object
    {
        return $this->companyTypeRepo->all()->get();
    }

    public function find(mixed $id): object
    {
        $data = $this->companyTypeRepo->find($id)->first();
        if (!$data) {
            throw new BadRequestException('Company Type not found.', code: 404);
        }

        return $data;
    }

    public function create(CreateCompanyTypeDTO $dto): int
    {
        $id = $this->companyTypeRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Company Type', code: 400);
        }

        return $id;
    }

    public function update(mixed $id, UpdateCompanyTypeDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->companyTypeRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Company Type not found', code: 404);
            }
            $this->companyTypeRepo->setAuditSession($dto->toAuditArray());
            $success = $this->companyTypeRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Company Type');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->companyTypeRepo->exists($conditions);
    }
}
