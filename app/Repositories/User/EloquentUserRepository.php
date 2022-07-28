<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Shared\EloquentAbstractRepository;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class EloquentUserRepository extends EloquentAbstractRepository implements UserRepositoryContract
{
    public function __construct(User $entity)
    {

        $this->entity = $entity;
    }

    public function attachCar(string $id, string $carId)
    {
        $user = $this->findById($id);
        $user->cars()->attach($carId);
        return $user;
    }

    public function detachCar(string $id, string $carId)
    {
        $user = $this->findById($id);
        $car = $user->cars()->find($carId);

        if(!$car) {
            throw new InvalidArgumentException('The car with id ' . $carId . ' does not belongs to this user');
        }

        $user->cars()->detach($carId);
        return $user;
    }

    /**
     * @throws \Throwable
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $user = $this->findById($id);
            $user->cars()->sync([]);
            $user->delete();
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

    }
}
