<?php

namespace App\Repositories\Car;

use Exception;

interface CarRepositoryContract
{
    public function getAll(bool $paginate = true, int $limit = null);

    public function findById($id);

    /**
     * @throws Exception
     */
    public function persist($model);

    public function destroy(string $id);
}
