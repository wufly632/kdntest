<?php


namespace App\Http\Controllers\Finance;


use App\Services\Api\ApiResponse;
use App\Services\Finance\SupplierWithdrawService;
use App\Services\User\SupplierUserService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{

    protected $supplierWithdrawService;
    protected $supplierUserService;

    public function __construct(SupplierWithdrawService $supplierWithdrawService, SupplierUserService $supplierUserService)
    {
        $this->supplierWithdrawService = $supplierWithdrawService;
        $this->supplierUserService = $supplierUserService;
    }

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        request()->flash();
        $suppliers = $this->supplierUserService->getAll();
        $withdraws = $this->supplierWithdrawService->get();
        $allstatus = $this->supplierWithdrawService::STATUS;
        return view('finance.withdraw', compact('withdraws', 'suppliers', 'allstatus'));
    }

    public function passApply()
    {
        if (!request()->filled('withdrawId')) {
            return ApiResponse::failure(g_API_ERROR, '参数有误');
        }
        $note = request()->input('note');
        $id = request()->post('withdrawId');
        $withdraw = $this->supplierWithdrawService->find($id);
        if ($withdraw->status != 1) {
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
        try {
            $this->supplierWithdrawService->update(['status' => 2, 'note' => $note], $id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }

    public function rejectApply()
    {
        if (!request()->filled('withdrawId')) {
            return ApiResponse::failure(g_API_ERROR, '参数有误');
        }
        $note = request()->input('note');
        $id = request()->post('withdrawId');
        $withdraw = $this->supplierWithdrawService->find($id);
        if ($withdraw->status != 1) {
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
        try {
            DB::beginTransaction();
            $this->supplierUserService->backMoney($withdraw->supplier_id, $withdraw->amout);
            $this->supplierWithdrawService->update(['status' => 3, 'note' => $note], $id);
            DB::commit();
            return ApiResponse::success();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }

    public function confirmGiro()
    {
        if (!request()->filled('withdrawId')) {
            return ApiResponse::failure(g_API_ERROR, '参数有误');
        }
        $swift_number = request()->input('swift_number');
        $id = request()->post('withdrawId');
        $withdraw = $this->supplierWithdrawService->find($id);
        if ($withdraw->status != 2) {
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
        try {
            $this->supplierWithdrawService->update(['status' => 4, 'swift_number' => $swift_number], $id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }

    public function giroFailed()
    {
        if (!request()->filled('withdrawId')) {
            return ApiResponse::failure(g_API_ERROR, '参数有误');
        }
        $note = request()->input('note');
        $id = request()->post('withdrawId');
        $withdraw = $this->supplierWithdrawService->find($id);
        if ($withdraw->status != 2) {
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
        try {
            DB::beginTransaction();
            $this->supplierUserService->backMoney($withdraw->supplier_id, $withdraw->amout);
            $this->supplierWithdrawService->update(['status' => 5, 'note' => $note], $id);
            DB::commit();
            return ApiResponse::success();
        } catch (\Exception $e) {
            DB::rollback();
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }
}