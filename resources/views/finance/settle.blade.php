@section('css')
    <style>
        #settle-table > thead > tr > th, #settle-table > tbody > tr > td {
            vertical-align: middle;
            text-align: center;
        }

        #table-inside > thead > tr, #table-inside > tbody > tr, #table-inside > thead > tr > th, #table-inside > tbody > tr > td {
            border: none;
        }

        .btn-white {
            border: 1px solid #797979;
            background-color: #FFFFff;
            color: #000000;
        }

        input[type=checkbox] {
            cursor: pointer;
        }
    </style>
@stop
@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                财务管理
                <small>结算</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Layout</a></li>
                <li class="active">Fixed</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <form action="{{ secure_route('settles.index') }}" class="form-horizontal" id="search-form">
                                <div class="form-group col-sm-2">
                                    <label for="settle_code" class="control-label col-sm-6">结算单号：</label>
                                    <div class="col-sm-6">
                                        <input name="settle_code" id="settle_code" type="text" class="form-control"
                                               v-model="info.settle_code">
                                    </div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="status" class="control-label col-sm-4">状态：</label>
                                    <div class="col-sm-8">
                                        <select name="status" id="status" class="form-control" v-model="info.status">
                                            <option value="">选择状态</option>
                                            <option value="1">待确认</option>
                                            <option value="2">已结算</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="daterange2" class="control-label col-sm-6">创建时间：</label>
                                    <div class="col-sm-6">
                                        <input name="time" id="daterange2" type="text" class="form-control"
                                               autocomplete="off" v-model="info.time">
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="supplier_id_select" class="control-label col-sm-6">供应商：</label>
                                    <div class="col-sm-6">
                                        <select name="supplier_id" id="supplier_id_select" class="form-control select2"
                                                v-model="info.supplier_id">
                                            <option value="">请选择商家</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="supplier_id_input" class="control-label col-sm-6">供应商ID：</label>
                                    <div class="col-sm-6">
                                        <input name="supplier_id_input" id="supplier_id_input" type="text"
                                               class="form-control" v-model="info.supplier_id_input">
                                    </div>
                                </div>
                                <div class="col-sm-2" style="margin-top: 1em">
                                    <div class="col-sm-6">
                                        <input type="submit" class="btn btn-sm btn-primary" value="查找">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="button" class="btn btn-sm btn-white" value="导出明细"
                                               @click="exportExcel">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr style="margin-top: 1em">
                        <div class="box-body">
                            <table class="table table-bordered table-hover" id="settle-table">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" v-model="checked" @change="changeCheckedAll"></th>
                                    <th>创建时间</th>
                                    <th>结算单号</th>
                                    <th>供应商信息</th>
                                    <th>供货金额</th>
                                    <th>佣金</th>
                                    <th>退货物流费</th>
                                    <th>结算金额</th>
                                    <th>状态</th>
                                    <th>确认时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-for="(settle,index) in settles">
                                    <tr>
                                        <td class="sel_area">
                                            <input type="checkbox" class="whole-son" name="ids" :value="index"
                                                   v-model="checkedOrders">

                                        </td>
                                        <td>@{{ settle.created_at.split(' ')[0] }}</td>
                                        <td>@{{ settle.settle_code }}</td>
                                        <td>
                                            <p>@{{ settle.supplier_name }}</p>
                                            <p>@{{ settle.supplier_id }}</p>
                                        </td>
                                        <td class="table-text order-detail">
                                            @{{ settle.amount }}
                                        </td>
                                        <td class="table-text">@{{ settle.commision }}</td>
                                        <td class="table-text">@{{ settle.express_fee }}</td>
                                        <td class="table-text">@{{ settle.amount }}</td>
                                        <td class="table-text">@{{ settle.status==1?'待确认':'已结算' }}</td>
                                        <td class="table-text">@{{ settle.confirmed_at }}</td>
                                        <td class="table-text clearfix">
                                            <button class="btn btn-sm btn-primary" @click="toggleDetail"
                                                    :data-index="index"
                                                    :data-id="settle.id">详情
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="settle-detail" v-show="settle.showDetail">
                                        <td colspan="11">
                                            <div style="max-height: 300px;overflow-y: auto;width: 100%">
                                                <table style="width: 100%" class="table table-hover" id="table-inside">
                                                    <tbody>
                                                    <tr>
                                                        <td colspan="8" style="text-align: left">供货金额明细</td>
                                                    </tr>
                                                    <tr>
                                                        <td>时间</td>
                                                        <td>SKUID</td>
                                                        <td>商品ID</td>
                                                        <td>货号</td>
                                                        <td>商品信息</td>
                                                        <td>供货数量</td>
                                                        <td>供货价</td>
                                                        <td>供货金额</td>
                                                        <td>佣金</td>
                                                    </tr>
                                                    <tr v-for="item in settle.detail">
                                                        <td>@{{ item.created_at.split(' ')[0] }}</td>
                                                        <td>@{{ item.sku_id }}</td>
                                                        <td>@{{ item.good_id }}</td>
                                                        <td>@{{ item.good_code }}</td>
                                                        <td>@{{ item.good_attr }}</td>
                                                        <td>@{{ item.num }}</td>
                                                        <td>@{{ item.supply_price }}</td>
                                                        <td>@{{
                                                            (parseFloat(item.supply_price)*parseInt(item.num)).toFixed(2)
                                                            }}
                                                        </td>
                                                        <td>@{{ item.commision }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $settles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{cdn_asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script src="{{cdn_asset('/assets/admin/js/vue.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.0/xlsx.full.min.js"></script>
    <script>
        var searchForm = new Vue({
            el: '#search-form',
            data: {
                info: {
                    settle_code: '{{ old('settle_code') }}',
                    status: '{{ old('status') }}',
                    time: '{{ old('time') }}',
                    supplier_id: '{{ old('supplier_id') }}',
                    supplier_id_input: '{{ old('supplier_id_input') }}',
                }
            },
            methods: {
                exportExcel: function () {
                    let ids = [];
                    settleTable.checkedOrders.forEach(function (item, index) {
                        ids.push(settleTable.settles[item].id);
                    });
                    var exportData = [];
                    axios.get('{{ secure_route('settles.getalldailys') }}' + '?settleIds=' + ids).then(function (res) {
                        exportData = res.data;

                        exportData.unshift(["", "", "", "", "", "", '一级-二级-三级', '', '', '', '', '']);
                        exportData.unshift(["时间", "SKUID", "商品名称", "商品ID", "货号", "SKU信息", '分级', '供货数量', '供货价', '供货金额', '佣金比例', '佣金']);
                        exportData.unshift(["发货单明细"]);
                        const ws = XLSX.utils.aoa_to_sheet(exportData);
                        const wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, "SheetJS");
                        XLSX.writeFile(wb, "sheetjs.xlsx");
                    });
                },
                filterCheckedSettles: function () {
                    var ids = [];
                    settleTable.checkedOrders.forEach(function (item, index) {
                        if (settleTable.settles[item].status !== '1') {
                            return;
                        }
                        ids.push(settleTable.settles[item].id);
                    });
                    return ids;
                },
            }
        });
        var settleTable = new Vue({
            el: '#settle-table',
            data: {
                checked: false,
                checkedOrders: [],
                checkedArr: {!! json_encode(range(0,count(array_pluck($settles,'id'))-1)) !!},
                settles: [
                        @foreach($settles as $settle)
                    {
                        id: '{{ $settle->id }}',
                        created_at: '{{ $settle->created_at }}',
                        settle_code: '{{ $settle->settle_code }}',
                        amount: '{{ $settle->amount }}',
                        supplier_id: '{{ $settle->supplier_id }}',
                        supplier_name: '{{ $settle->supplier->name }}',
                        commision: '{{ $settle->commision }}',
                        express_fee: '{{ $settle->express_fee }}',
                        status: '{{ $settle->status }}',
                        confirmed_at: '{{ $settle->confirmed_at }}',
                        showDetail: false,
                        hasDetail: false,
                        detail: [{
                            created_at: "",
                            sku_id: '',
                            good_id: '',
                            good_code: '',
                            good_title: '',
                            good_attr: '',
                            num: '',
                            supply_price: '',
                            commision: '',
                            settle_code: ''
                        }]
                    },
                    @endforeach
                ]
            },
            methods: {
                changeCheckedAll: function () {
                    if (this.checked) {
                        this.checkedOrders = this.checkedArr;
                    } else {
                        this.checkedOrders = [];
                    }
                },
                toggleDetail: function (event) {
                    let _thisEl = event.currentTarget;
                    let index = _thisEl.getAttribute('data-index');
                    let _settle_id = _thisEl.getAttribute('data-id');
                    let self = this;
                    let _exactObj = self.settles[index];
                    if (_exactObj.hasDetail === false) {
                        axios.get("{{ secure_route('settles.getonedaily',['settle_code'=>1]) }}".replace(1, _settle_id)).then(function (res) {
                            console.log(res.data);
                            _exactObj.detail = res.data;
                            _exactObj.showDetail = true;
                            _exactObj.hasDetail = true;
                        })
                    } else {
                        _exactObj.showDetail = !_exactObj.showDetail;
                    }
                }
            },
            watch: {
                'checkedOrders': function () {
                    this.checked = this.checkedOrders.length === this.checkedArr.length;
                }
            }
        });
        addDateRangePicker($('#time'));
        $('#status').val('{{ old('status') }}');
    </script>
@endsection