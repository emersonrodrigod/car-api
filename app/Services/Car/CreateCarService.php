<?php

namespace App\Services\Car;

use App\Models\Car;
use App\Repositories\Car\CarRepositoryContract;

class CreateCarService
{

    private CarRepositoryContract $carRepository;

    public function __construct(CarRepositoryContract $carRepository)
    {

        $this->carRepository = $carRepository;
    }

    public function __invoke(array $data)
    {

        $car = new Car();
        $car->model = $data['model'];
        $car->license_plate = $data['license_plate'];
        $car->manufacturing_year = $data['manufacturing_year'];

        return $this->carRepository->persist($car);
    }

}
