<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Repositories\Car\CarRepositoryContract;
use App\Services\Car\CreateCarService;
use App\Services\Car\DestroyCarService;
use App\Services\Car\UpdateCarService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CarController extends Controller
{
    const RULES = [
        'model' => ['required', 'string', 'max:200'],
        'license_plate' => ['required', 'string', 'max:8'],
        'manufacturing_year' => ['required', 'string', 'max:9']
    ];

    private CarRepositoryContract $carRepository;

    public function __construct(CarRepositoryContract $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function index()
    {
        return CarResource::collection($this->carRepository->getAll());
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request, CreateCarService $service)
    {
        $data = $this->validate($request, self::RULES);
        $car = $this->execute($service, $data);
        return (new CarResource($car))->response()->setStatusCode(201);
    }

    /**
     * @throws ValidationException
     */
    public function update(string $id, Request $request, UpdateCarService $service): CarResource
    {
        $data = $this->validate($request, self::RULES);
        $car = $this->execute($service, $id, $data);
        return new CarResource($car);
    }

    public function destroy(string $id, DestroyCarService $service)
    {
        $this->execute($service, $id);
        return response('', 204);
    }

}
