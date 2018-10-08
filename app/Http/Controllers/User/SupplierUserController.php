<?php

namespace App\Http\Controllers\User;


use App\Exceptions\CustomException;
use App\Services\Api\ApiResponse;
use App\Services\User\SupplierUserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
    public function index()
    {
        //
        return view('supplierusers.index', ['users' => $this->supplierUserService->getUserList()]);
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
    public function store(Request $request)
    {
        $userRequest = $request->only(['name', 'mobile', 'email', 'password', 'password_confirmation', 'status']);
        try {
            $this->makeValidate($userRequest, $this->createValidateRules(), $this->validateMsg());
        } catch (CustomException $e) {
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
        //
        $result = $this->supplierUserService->createUser($request);
        if ($result['status'] != 200) {
            return ApiResponse::failure(g_API_ERROR, $result['msg']);
        }
        return ApiResponse::success('创建成功');

    }

    /**
     * @param $request
     * @return bool
     * @throws CustomException
     */
    public function makeValidate($request, $rules)
    {

        $rules = $this->createValidateRules();
        $validator = Validator::make($request, $rules, $this->validateMsg());
        if ($validator->fails()) {
            throw new CustomException($validator->errors()->all()[0]);
        } else {
            return true;
        }
    }

    public function createValidateRules()
    {
        return [
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function updateValidateRules()
    {
        return [
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'password' => 'required_if',
            'password_confirmation' => 'required_if|confirmed'
        ];
    }

    public function validateMsg()
    {
        return [
            'required' => ':attribute 必须',
            'numeric' => ':attribute 必须为数字',
            'email' => ':attribute 必须为邮箱',
            'in' => ':attribute 不正确',
            'required_if' => '缺少 :attribute',
        ];
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
    public function update(Request $request, $id)
    {
        $userRequest = $request->only(['name', 'mobile', 'email', 'password', 'password_confirmation', 'status']);
        try {
            $this->makeValidate($userRequest);
        } catch (CustomException $e) {
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
        //
        $result = $this->supplierUserService->updateUser($request, $id);
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

    }
}
