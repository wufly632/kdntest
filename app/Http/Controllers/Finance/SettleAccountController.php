<?php


namespace App\Http\Controllers\Finance;


use App\Entities\Finance\SupplierSettleAccount;
use App\Services\Finance\SupplierSettleAccountService;
use App\Services\User\SupplierUserService;
use Illuminate\Routing\Controller;

class SettleAccountController extends Controller
{
    protected $supplierSettleAccountService;
    protected $supplierUserService;

    public function __construct(SupplierSettleAccountService $supplierSettleAccountService, SupplierUserService $supplierUserService)
    {
        $this->supplierSettleAccountService = $supplierSettleAccountService;
        $this->supplierUserService = $supplierUserService;
    }

    public function index()
    {
        request()->flash();
        $settles = $this->supplierSettleAccountService->get();
        $suppliers = $this->supplierUserService->getAll();
        return view('finance.settle', compact('settles', 'suppliers'));
    }

    /**
     * 获取一条结算详情
     * @param $settleCode
     * @return mixed
     */
    public function getOneDailySettleDetail($settleId)
    {
        return $this->supplierSettleAccountService->getReceiveDailyById($settleId);
    }

    /**
     * 批量获取结算详情
     * @return array
     */
    public function getAllDailySettleDetail()
    {
        $settleIds = request()->input('settleIds');
        $settleIds = explode(',', $settleIds);

        $dailys = $this->supplierSettleAccountService->getReceiveDailyByIds($settleIds);
        return $dailys;
    }
}