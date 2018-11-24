<?php

namespace App\Services\User;

use App\Repositories\User\SupplierUserRepository;
use App\Services\Api\ApiResponse;
use App\Validators\User\SupplierUserValidator;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function getUserList($request)
    {
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        if ($request->hasAny('name', 'email', 'user_id')) {
            $option = [];

            if ($request->filled('name')) {
                $option = array_merge($option, [['name', 'like', '%' . $request->get('name') . '%']]);
            }
            if ($request->filled('email')) {
                $option = array_merge($option, [['email', 'like', '%' . $request->get('email') . '%']]);
            }
            if ($request->filled('user_id')) {
                $option = array_merge($option, ['id' => $request->get('user_id')]);
            }
            $total = $this->supplierUserRepository->findWhere($option);
            $count = count($total);
            $person = new LengthAwarePaginator($total, $count, 15);
            $person->withPath('supplierusers');
            $person->appends($request->all());
            return $person;
        } else {
            return $this->supplierUserRepository->orderBy($orderBy, $sort)->paginate($length);
        }
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
        try {
            $this->supplierUserRepository->create($request);
            return ApiResponse::success('创建成功');
        } catch (\Exception $e) {

            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    public function updateUser($request, $id)
    {
        try {
            $this->supplierUserRepository->update($request, $id);
            return ApiResponse::success('修改成功');
        } catch (\Exception $e) {

            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        if ($this->supplierUserRepository->delete($id)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        return $this->supplierUserRepository->all(['id', 'name']);
    }

    public function backMoney($supplier_id, $count)
    {
        $this->supplierUserRepository->model()::where('id', $supplier_id)->increment('amount_money', $count);
    }
}