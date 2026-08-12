<?php

namespace App\Services\Master;


use App\Repositories\Master\MoldMaking\MoldMakingRepository;
use App\DTOs\Master\MoldMaking\{CreateMoldMakingDTO, UpdateMoldMakingDTO};
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class MoldMakingService
{
    protected MoldMakingRepository $moldMakingRepo;

    public function __construct(MoldMakingRepository $moldMakingRepo)
    {
        $this->moldMakingRepo = $moldMakingRepo;
    }

    public function all(): object
    {
        return $this->moldMakingRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->moldMakingRepo->find($id)->first();
    }

    public function create(CreateMoldMakingDTO $dto): mixed
    {
        $id = $this->moldMakingRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MoldMaking');
        }

        return $id;
    }

    public function update(int $id, UpdateMoldMakingDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->moldMakingRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MoldMaking not found', code: 404);
            }
            $this->moldMakingRepo->setAuditSession($dto->toAuditArray());
            $success = $this->moldMakingRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MoldMaking');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->moldMakingRepo->exists($conditions);
    }
}
