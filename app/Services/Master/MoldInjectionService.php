<?php

namespace App\Services\Master;


use App\Repositories\Master\MoldInjection\MoldInjectionRepository;
use App\DTOs\Master\MoldInjection\CreateMoldInjectionDTO;
use App\DTOs\Master\MoldInjection\UpdateMoldInjectionDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class MoldInjectionService
{
    protected MoldInjectionRepository $moldInjectionRepo;

    public function __construct(MoldInjectionRepository $moldInjectionRepo)
    {
        $this->moldInjectionRepo = $moldInjectionRepo;
    }

    public function all(): object
    {
        return $this->moldInjectionRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->moldInjectionRepo->find($id)->first();
    }

    public function create(CreateMoldInjectionDTO $dto): mixed
    {
        $id = $this->moldInjectionRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MoldInjection');
        }

        return $id;
    }

    public function update(int $id, UpdateMoldInjectionDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->moldInjectionRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MoldInjection not found', code: 404);
            }
            $this->moldInjectionRepo->setAuditSession($dto->toAuditArray());
            $success = $this->moldInjectionRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MoldInjection');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->moldInjectionRepo->exists($conditions);
    }
}
