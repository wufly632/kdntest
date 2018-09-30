<?php

namespace App\Services\User;


use App\Repositories\User\UserRepository;
use App\Validators\User\UserValidator;

class UserService
{
    protected $userRepository;
    protected $userValidator;

    public function __construct(UserRepository $userRepository, UserValidator $userValidator)
    {
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
    }

    public function getUserList()
    {
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        return $this->userRepository->orderBy($orderBy, $sort)->paginate($length);
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }
}