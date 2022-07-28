<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryContract;
use Illuminate\Support\Facades\Hash;

class CreateUserService
{

    private UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(array $data)
    {

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        return $this->userRepository->persist($user);
    }

}
