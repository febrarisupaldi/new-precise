<?php

namespace App\Services\Master;


use App\Repositories\Master\MoldStatus\MoldStatusRepository;
use App\DTOs\Master\MoldStatus\CreateMoldStatusDTO;
use App\DTOs\Master\MoldStatus\UpdateMoldStatusDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class MoldStatusService
{
    protected MoldStatusRepository $moldStatusRepo;

    public function __construct(MoldStatusRepository $moldStatusRepo)
    {
        $this->moldStatusRepo = $moldStatusRepo;
    }

    public function all(): object
    {
        return $this->moldStatusRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->moldStatusRepo->find($id)->first();
    }

    public function create(CreateMoldStatusDTO $dto): mixed
    {
        $id = $this->moldStatusRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MoldStatus');
        }

        return $id;
    }

    public function update(int $id, UpdateMoldStatusDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->moldStatusRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MoldStatus not found', code: 404);
            }
            $this->moldStatusRepo->setAuditSession($dto->toAuditArray());
            $success = $this->moldStatusRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MoldStatus');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->moldStatusRepo->exists($dto->columns, $dto->values);
    }
}
