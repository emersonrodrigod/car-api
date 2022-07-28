<?php

namespace App\Services\User;


use App\Repositories\User\UserRepositoryContract;
use Illuminate\Support\Facades\Hash;

class UpdateUserService
{

    private UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function __invoke(string $id, array $data)
    {

        $user = $this->userRepository->findById($id);
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        return $this->userRepository->persist($user);
    }

}
