<?php


namespace App\Services\Finance;


use App\Repositories\Finance\SupplierWithdrawRepository;

class SupplierWithdrawService
{
    const STATUS = [
        1 => '等待审核',
        2 => '等待打款',
        3 => '审核驳回',
        4 => '打款完成',
        5 => '打款失败'
    ];

    protected $supplierWithdrawRepository;

    public function __construct(SupplierWithdrawRepository $supplierWithdrawRepository)
    {
        $this->supplierWithdrawRepository = $supplierWithdrawRepository;
    }

    public function get()
    {

        $query = $this->supplierWithdrawRepository->model()::orderByDesc('id');

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

        if (request()->filled('withdraw_code')) {
            array_push($option, ['withdraw_code' => request()->input('withdraw_code')]);
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

    public function update(array $array, $id)
    {
        $this->supplierWithdrawRepository->update($array, $id);
    }

    public function find($id)
    {
        return $this->supplierWithdrawRepository->find($id);
    }
}