<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryContract;

class DestroyUserService
{

    private UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function __invoke(string $id)
    {

        return $this->userRepository->destroy($id);
    }

}
