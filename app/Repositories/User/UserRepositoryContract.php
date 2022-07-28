<?php

namespace App\Repositories\User;

use Exception;

interface UserRepositoryContract
{
    public function getAll(bool $paginate = true, int $limit = null);

    public function findById($id);

    /**
     * @throws Exception
     */
    public function persist($model);

    public function destroy(string $id);

    public function attachCar(string $id, string $carId);

    public function detachCar(string $id, string $carId);
}
