<?php

namespace App\Services\Production\Melamine\MoldTransfer;

use App\DTOs\ExistsDTO;
use App\Repositories\Production\Melamine\MoldTransfer\MoldTransferHeaderRepository;
use App\DTOs\Production\Melamine\MoldTransfer\CreateMoldTransferDTO;
use App\DTOs\Production\Melamine\MoldTransfer\UpdateMoldTransferDTO;
use Illuminate\Support\Facades\DB;

class MoldTransferService
{
    protected $moldTransferRepo;

    public function __construct(MoldTransferHeaderRepository $moldTransferRepo)
    {
        $this->moldTransferRepo = $moldTransferRepo;
    }

    public function all()
    {
        return $this->moldTransferRepo->all();
    }

    public function find($id)
    {
        return $this->moldTransferRepo->find($id);
    }

    public function create(CreateMoldTransferDTO $dto): array
    {
        $success = $this->moldTransferRepo->create($dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'MoldTransfer created successfully.' : 'Failed to create MoldTransfer.',
        ];
    }

    public function update($id, UpdateMoldTransferDTO $dto): array
    {
        return DB::transaction(function () use ($id, $dto) {
            $exists = $this->moldTransferRepo->find($id);

            if (!$exists) {
                return ['success' => false, 'message' => 'MoldTransfer not found.'];
            }

            $affected = $this->moldTransferRepo->update($id, $dto->toArray());

            return [
                'success' => $affected >= 0,
                'message' => 'MoldTransfer updated successfully.',
            ];
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->moldTransferRepo->exists($dto->columns, $dto->values);
    }
}
