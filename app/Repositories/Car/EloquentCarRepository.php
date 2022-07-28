<?php

namespace App\Repositories\Car;

use App\Models\Car;
use App\Repositories\Shared\EloquentAbstractRepository;
use Illuminate\Support\Facades\DB;

class EloquentCarRepository extends EloquentAbstractRepository implements CarRepositoryContract
{
    public function __construct(Car $entity)
    {

        $this->entity = $entity;
    }

    /**
     * @throws \Throwable
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $car = $this->findById($id);
            $car->owners()->sync([]);
            $car->delete();
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

    }
}
