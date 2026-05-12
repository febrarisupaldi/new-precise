<?php

namespace App\Services\Master\State;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\State\StateRepository;
use App\DTOs\Master\State\CreateStateDTO;
use App\DTOs\Master\State\UpdateStateDTO;
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

    public function find($id): ?object
    {
        return $this->stateRepo->find($id)->first();
    }

    public function create(CreateStateDTO $dto): array
    {
        $success = $this->stateRepo->create($dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'State created successfully.' : 'Failed to create state.',
        ];
    }

    public function update($id, UpdateStateDTO $dto): array
    {
        return DB::transaction(function () use ($id, $dto) {
            $exists = $this->stateRepo->find($id)->first();

            if (!$exists) {
                return ['success' => false, 'message' => 'State not found.'];
            }
            $this->stateRepo->setAuditSession($dto->toAuditArray());
            $affected = $this->stateRepo->update($id, $dto->withoutAuditArray());

            return [
                'success' => $affected >= 0,
                'message' => 'State updated successfully.',
            ];
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->stateRepo->exists($dto->columns, $dto->values);
    }
}
