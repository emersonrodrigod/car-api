<?php

namespace App\Services\Car;

use App\Repositories\Car\CarRepositoryContract;

class DestroyCarService
{

    private CarRepositoryContract $carRepository;

    public function __construct(CarRepositoryContract $carRepository)
    {

        $this->carRepository = $carRepository;
    }

    public function __invoke(string $id)
    {
        $this->carRepository->destroy($id);
    }

}
