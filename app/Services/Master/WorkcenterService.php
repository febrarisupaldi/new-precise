<?php

namespace App\Services\Master;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\Workcenter\WorkcenterRepository;
use App\DTOs\Master\Workcenter\CreateWorkcenterDTO;
use App\DTOs\Master\Workcenter\UpdateWorkcenterDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class WorkcenterService
{
    protected WorkcenterRepository $workcenterRepo;

    public function __construct(WorkcenterRepository $workcenterRepo)
    {
        $this->workcenterRepo = $workcenterRepo;
    }

    public function all(): object
    {
        return $this->workcenterRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->workcenterRepo->find($id)->first();
    }

    public function create(CreateWorkcenterDTO $dto): mixed
    {
        $id = $this->workcenterRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Workcenter');
        }

        return $id;
    }

    public function update(int $id, UpdateWorkcenterDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->workcenterRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Workcenter not found', code: 404);
            }
            $this->workcenterRepo->setAuditSession($dto->toAuditArray());
            $success = $this->workcenterRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Workcenter');
            }
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->workcenterRepo->exists($dto->columns, $dto->values);
    }
}
