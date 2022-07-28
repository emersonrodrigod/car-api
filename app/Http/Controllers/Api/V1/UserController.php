<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\User\UserRepositoryContract;
use App\Services\User\CreateUserService;
use App\Services\User\DestroyUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    private UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return UserResource::collection($this->userRepository->getAll());
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request, CreateUserService $service)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);
        $user = $this->execute($service, $data);
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * @throws ValidationException
     */
    public function update(string $id, Request $request, UpdateUserService $service): UserResource
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

        $user = $this->execute($service, $id, $data);
        return new UserResource($user);
    }

    public function destroy(string $id, DestroyUserService $service)
    {
        $this->execute($service, $id);
        return response('', 204);
    }

    public function show(string $id)
    {
        return new UserResource($this->userRepository->findById($id));
    }

    public function attachCar($id, Request $request): UserResource
    {
        $data = $this->validate($request, [
            'car_id' => ['required', 'uuid']
        ]);

        $user = $this->userRepository->attachCar($id, $data['car_id']);
        return new UserResource($user);
    }

    public function detachCar($id, Request $request): UserResource
    {
        $data = $this->validate($request, [
            'car_id' => ['required', 'uuid']
        ]);

        $user = $this->userRepository->detachCar($id, $data['car_id']);
        return new UserResource($user);
    }

}
