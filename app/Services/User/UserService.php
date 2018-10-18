<?php

namespace App\Services\User;


use App\Repositories\User\UserRepository;
use App\Validators\User\UserValidator;

class UserService
{
    protected $userRepository;
    protected $userValidator;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserValidator $userValidator
     */
    public function __construct(UserRepository $userRepository, UserValidator $userValidator)
    {
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
    }

    /**
     * 获取用户列表
     * @return mixed
     */
    public function getUserList()
    {
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        return $this->userRepository->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * 获取用户信息
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser($request)
    {
        $this->userRepository->create($request->all());
    }

    public function transform($request)
    {

    }

    public function updateUser($id, $option)
    {
        $this->userRepository->update($option, $id);
    }

}