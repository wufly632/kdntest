<?php

namespace App\Http\Controllers\User;


use App\Http\Requests\User\SupplierUserCreateRequest;
use App\Http\Requests\User\SupplierUserUpdateRequest;
use App\Services\Api\ApiResponse;
use App\Services\User\SupplierUserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierUserController extends Controller
{

    protected $supplierUserService;

    public function __construct(SupplierUserService $supplierUserService)
    {
        $this->supplierUserService = $supplierUserService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return view('supplierusers.index', ['users' => $this->supplierUserService->getUserList($request)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('supplierusers.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierUserCreateRequest $request)
    {
        $userRequest = $request->only(['name', 'mobile', 'email', 'password', 'password_confirmation', 'status']);
        $result = $this->supplierUserService->createUser($userRequest);
        if ($result['status'] != 200) {
            return ApiResponse::failure(g_API_ERROR, $result['msg']);
        }
        return ApiResponse::success('创建成功');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('supplierusers.show', ['user' => $this->supplierUserService->getUserById($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('supplierusers.edit', ['user' => $this->supplierUserService->getUserById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierUserUpdateRequest $request, $id)
    {
        $userRequest = $request->only(['name', 'mobile', 'email', 'password', 'password_confirmation', 'status']);

        $result = $this->supplierUserService->updateUser($userRequest, $id);
        if ($result['status'] != 200) {
            return ApiResponse::failure(g_API_ERROR, $result['msg']);
        }
        return ApiResponse::success('创建成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if ($this->supplierUserService->deleteUser($id)) {
            return ApiResponse::success('删除成功');
        }else{
            return ApiResponse::failure(g_API_ERROR, '删除失败');
        }
    }
}
