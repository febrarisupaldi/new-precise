<?php

namespace App\Services\Master;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\State\StateRepository;
use App\DTOs\Master\State\CreateStateDTO;
use App\DTOs\Master\State\UpdateStateDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class StateService
{
    protected StateRepository $stateRepo;

    public function __construct(StateRepository $stateRepo)
    {
        $this->stateRepo = $stateRepo;
    }

    public function all(): object
    {
        return $this->stateRepo->all()->get();
    }

    public function find(int $id): object
    {
        $result = $this->stateRepo->find($id)->first();

        if (!$result) {
            throw new BadRequestException('Data not found', code: 404);
        }

        return $result;
    }

    public function create(CreateStateDTO $dto): int
    {
        $id = $this->stateRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create state');
        }

        return $id;
    }

    public function update(mixed $id, UpdateStateDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->stateRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('State not found', code: 404);
            }
            $this->stateRepo->setAuditSession($dto->toAuditArray());
            $success = $this->stateRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update state');
            }
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->stateRepo->exists($dto->columns, $dto->values);
    }
}
