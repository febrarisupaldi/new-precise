<?php

namespace App\Services\Master;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\MoldPressing\MoldPressingRepository;
use App\DTOs\Master\MoldPressing\CreateMoldPressingDTO;
use App\DTOs\Master\MoldPressing\UpdateMoldPressingDTO;
use App\Exceptions\BadRequestException;
use App\Repositories\Master\MoldPressing\MoldPressingDetailRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class MoldPressingService
{
    private MoldPressingRepository $moldPressingRepo;
    private MoldPressingDetailRepository $moldPressingDetailRepo;

    public function __construct(MoldPressingRepository $moldPressingRepo, MoldPressingDetailRepository $moldPressingDetailRepo)
    {
        $this->moldPressingRepo = $moldPressingRepo;
        $this->moldPressingDetailRepo = $moldPressingDetailRepo;
    }

    public function all(?array $filters = []): object
    {
        return $this->moldPressingRepo->all($filters)->get();
    }

    public function find(mixed $id): ?object
    {
        $data = $this->moldPressingRepo->find($id)->first();  
        if (!$data) {
            throw new BadRequestException('Mold Pressing data not found.', code: 404);
        }

        $details = $this->moldPressingDetailRepo->findByMasterID($id)->get();
        $data->details = $details;
        return $data;
    }

    public function create(CreateMoldPressingDTO $dto): mixed
    {
        $id = $this->moldPressingRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MoldPressing');
        }

        return $id;
    }

    public function update(int $id, UpdateMoldPressingDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->moldPressingRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MoldPressing not found', code: 404);
            }
            $this->moldPressingRepo->setAuditSession($dto->toAuditArray());
            $success = $this->moldPressingRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MoldPressing');
            }
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->moldPressingRepo->exists($dto->columns, $dto->values);
    }
}
