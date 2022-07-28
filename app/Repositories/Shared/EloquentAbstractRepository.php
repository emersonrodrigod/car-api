<?php

namespace App\Repositories\Shared;

use Exception;
use Illuminate\Database\Eloquent\Model;


abstract class EloquentAbstractRepository
{
    /**
     * @var Model|null
     */
    protected ?Model $entity = null;

    public function getAll(bool $paginate = true, int $limit = null)
    {
        $query = $this->entity::query();

        if ($limit !== null) {
            $query->limit($limit);
        }

        if ($paginate === true) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

    public function findById($id)
    {
        return $this->entity::findOrFail($id);
    }

    /**
     * @throws Exception
     */
    public function persist($model)
    {
        try {
            $model->save();

            return $model;
        } catch (Exception $e) {
            throw new Exception(sprintf('It was not possible to persist given. An error has occurred %s', $e->getMessage()));
        }
    }

    public function destroy(string $id)
    {
        return $this->entity->findOrFail($id)->delete();
    }
}
