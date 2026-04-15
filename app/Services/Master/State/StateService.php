<?php

namespace App\Services\Master\State;

use App\Repositories\Master\State\StateRepository;
use App\DTOs\Master\State\CreateStateDTO;
use App\DTOs\Master\State\UpdateStateDTO;

class StateService
{
    protected StateRepository $stateRepo;

    public function __construct(StateRepository $stateRepo)
    {
        $this->stateRepo = $stateRepo;
    }

    public function getAll()
    {
        return $this->stateRepo->all();
    }

    public function getById($id)
    {
        return $this->stateRepo->findById($id);
    }

    public function create(CreateStateDTO $dto): array
    {
        $success = $this->stateRepo->create($dto);

        return [
            'success' => $success,
            'message' => $success ? 'State created successfully.' : 'Failed to create state.',
        ];
    }

    public function update($id, UpdateStateDTO $dto): array
    {
        $exists = $this->stateRepo->findById($id);

        if (!$exists) {
            return ['success' => false, 'message' => 'State not found.'];
        }

        $affected = $this->stateRepo->update($id, $dto);

        return [
            'success' => $affected >= 0,
            'message' => 'State updated successfully.',
        ];
    }

    public function checkExist(string $column, mixed $value): bool
    {
        return $this->stateRepo->checkExists($column, $value);
    }
}
