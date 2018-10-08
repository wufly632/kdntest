<?php

namespace App\Services\User;

use App\Repositories\User\SupplierUserRepository;
use App\Services\Api\ApiResponse;
use App\Validators\User\SupplierUserValidator;

class SupplierUserService
{
    protected $supplierUserRepository;
    protected $supplierUserValidator;

    /**
     * UserService constructor.
     * @param SupplierUserRepository $supplierUserRepository
     * @param SupplierUserValidator $supplierUserValidator
     */
    public function __construct(SupplierUserRepository $supplierUserRepository, SupplierUserValidator $supplierUserValidator)
    {
        $this->supplierUserRepository = $supplierUserRepository;
        $this->supplierUserValidator = $supplierUserValidator;
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
        return $this->supplierUserRepository->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * 获取用户信息
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        return $this->supplierUserRepository->find($id);
    }

    public function createUser($request)
    {
        $userRequest = $request->only(['name', 'mobile', 'password', 'password_confirmation', 'email']);
        try {
            $this->supplierUserRepository->create($userRequest);
            return ApiResponse::success('创建成功');
        } catch (\Exception $e) {

            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    public function updateUser($request, $id)
    {
        $userRequest = $request->only(['name', 'mobile', 'password', 'password_confirmation', 'email', 'status']);
        try {
            $this->supplierUserRepository->update($userRequest,$id);
            return ApiResponse::success('创建成功');
        } catch (\Exception $e) {

            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

}