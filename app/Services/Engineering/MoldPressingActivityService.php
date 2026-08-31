<?php

namespace App\Services\Engineering;


use App\Repositories\Engineering\MoldPressingActivity\MoldPressingActivityRepository;
use App\DTOs\Engineering\MoldPressingActivity\CreateMoldPressingActivityDTO;
use App\DTOs\Engineering\MoldPressingActivity\UpdateMoldPressingActivityDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class MoldPressingActivityService
{
    protected MoldPressingActivityRepository $moldPressingActivityRepo;

    public function __construct(MoldPressingActivityRepository $moldPressingActivityRepo)
    {
        $this->moldPressingActivityRepo = $moldPressingActivityRepo;
    }

    public function all(): object
    {
        return $this->moldPressingActivityRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->moldPressingActivityRepo->find($id)->first();
    }

    public function create(CreateMoldPressingActivityDTO $dto): mixed
    {
        $id = $this->moldPressingActivityRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MoldPressingActivity');
        }

        return $id;
    }

    public function update(int $id, UpdateMoldPressingActivityDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->moldPressingActivityRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MoldPressingActivity not found', code: 404);
            }
            $this->moldPressingActivityRepo->setAuditSession($dto->toAuditArray());
            $success = $this->moldPressingActivityRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MoldPressingActivity');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->moldPressingActivityRepo->exists($conditions);
    }
}
