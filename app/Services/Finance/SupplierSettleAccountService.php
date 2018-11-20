<?php


namespace App\Services\Finance;


use App\Repositories\Finance\SupplierSettleAccountRepository;
use App\Services\CateAttr\AttributeService;
use App\Services\CateAttr\AttrValueService;
use App\Services\CateAttr\CategoryService;
use App\Services\User\SupplierUserService;

class SupplierSettleAccountService
{
    protected $supplierSettleAccountRepository;
    protected $supplierUserService;
    protected $attrValueService;
    protected $categoryService;

    public function __construct(SupplierSettleAccountRepository $supplierSettleAccountRepository, SupplierUserService $supplierUserService, AttrValueService $attrValueService, CategoryService $categoryService)
    {
        $this->supplierSettleAccountRepository = $supplierSettleAccountRepository;
        $this->supplierUserService = $supplierUserService;
        $this->attrValueService = $attrValueService;
        $this->categoryService = $categoryService;
    }

    public function get()
    {
        $query = $this->supplierSettleAccountRepository->model()::orderByDesc('id');
        if ($this->parseQuery()) {
            foreach ($this->parseQuery() as $option) {
                $query = $query->where($option);
            }
        }

        if ($this->parseQueryBetween()) {
            $query = $query->whereBetween($this->parseQueryBetween()[0], $this->parseQueryBetween()[1]);
        }
        $queryResult = $query->paginate(request()->filled('length') ? request()->input('length') : 20)->appends(request()->all());
        return $queryResult;
    }

    public function parseQuery()
    {
        $option = [];

        if (request()->filled('settle_code')) {
            array_push($option, ['settle_code' => request()->input('settle_code')]);
        }
        if (request()->filled('status')) {
            array_push($option, ['status' => request()->input('status')]);
        }
        if (request()->filled('supplier_id')) {
            array_push($option, ['supplier_id' => request()->input('supplier_id')]);
        }
        if (request()->filled('supplier_id_input')) {
            array_push($option, ['supplier_id' => request()->input('supplier_id_input')]);
        }
        return $option;
    }

    public function parseQueryBetween()
    {
        $betweenOption = [];
        if (request()->filled('time')) {
            $timebetweent = explode('~', request()->query('time'));
            $betweenOption = ['created_at', [$timebetweent[0], $timebetweent[1]]];
        }
        return $betweenOption;
    }

    /**
     * 获取单条结算单详情
     * @param $settleId
     * @return array
     */
    public function getReceiveDailyById($settleId)
    {
        $dailys = $this->supplierSettleAccountRepository->model()::find($settleId)->settleReceiveRelate;
        $data = [];
        foreach ($dailys as $k => $daily) {
            $dailyObj = $daily->receiveDaily;
            $data[$k] = $dailyObj->toArray();
            $data[$k]['good_title'] = $dailyObj->good->good_title;
            $data[$k]['created_at'] = $dailyObj->created_at->toDateTimeString();
            $data[$k]['good_code'] = $dailyObj->good->good_code;
            $data[$k]['good_attr'] = $this->attrValueService->getAttriButeByIds($dailyObj->sku->value_ids);
        }
        return $data;
    }

    /**
     * 批量获取结算单详情
     * @param $settleIds
     * @return array
     */
    public function getReceiveDailyByIds($settleIds)
    {
        $allDailys = $this->supplierSettleAccountRepository->model()::whereIn('id', $settleIds)->get();
        $bigData = [];
        $data = [];
        foreach ($allDailys as $allDaily) {
            $dailys = $allDaily->settleReceiveRelate;
            foreach ($dailys as $k => $daily) {
                $dailyObj = $daily->receiveDaily;
                $data[$k] = $dailyObj->toArray();
                $data[$k]['good_title'] = $dailyObj->good->good_title;
                $data[$k]['created_at'] = $dailyObj->created_at->toDateTimeString();
                $data[$k]['good_code'] = $dailyObj->good->good_code;
                $data[$k]['catagorys'] = $this->categoryService->getCateNameByIds($dailyObj->good->category_path);
                $data[$k]['good_attr'] = $this->attrValueService->getAttriButeByIds($dailyObj->sku->value_ids);
                unset($data[$k]['updated_at']);
                $itemIn = [];
                $itemIn['created_at'] = $data[$k]['created_at'];
                $itemIn['sku_id'] = $data[$k]['sku_id'];
                $itemIn['good_title'] = $data[$k]['good_title'];
                $itemIn['good_id'] = $data[$k]['good_id'];
                $itemIn['good_code'] = $data[$k]['good_code'];
                $itemIn['good_attr'] = $data[$k]['good_attr'];
                $itemIn['catagorys'] = $data[$k]['catagorys'];
                $itemIn['num'] = $data[$k]['num'];
                $itemIn['supply_price'] = $data[$k]['supply_price'];
                $itemIn['total_price'] = $data[$k]['supply_price'] * $data[$k]['num'];
                $itemIn['commision_proportion'] = 0;//TODO 佣金比例待做
                $itemIn['commision'] = $data[$k]['commision'];
                array_push($bigData, array_values($itemIn));
            }

        }
        return $bigData;
    }
}