<?php

namespace App\Services\Master;


use App\Repositories\Master\CoolingMethod\CoolingMethodRepository;
use App\DTOs\Master\CoolingMethod\{CreateCoolingMethodDTO, UpdateCoolingMethodDTO};
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class CoolingMethodService
{
    protected CoolingMethodRepository $coolingMethodRepo;

    public function __construct(CoolingMethodRepository $coolingMethodRepo)
    {
        $this->coolingMethodRepo = $coolingMethodRepo;
    }

    public function all(): object
    {
        return $this->coolingMethodRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->coolingMethodRepo->find($id)->first();
    }

    public function create(CreateCoolingMethodDTO $dto): mixed
    {
        $id = $this->coolingMethodRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Cooling Method');
        }

        return $id;
    }

    public function update(int $id, UpdateCoolingMethodDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->coolingMethodRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('CoolingMethod not found', code: 404);
            }
            $this->coolingMethodRepo->setAuditSession($dto->toAuditArray());
            $success = $this->coolingMethodRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update CoolingMethod');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->coolingMethodRepo->exists($conditions);
    }
}
