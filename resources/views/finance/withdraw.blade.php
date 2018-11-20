@section('css')
    <style>
        #withdraw-table > thead > tr > th, #withdraw-table > tbody > tr > td {
            vertical-align: middle;
            text-align: center;
        }

        input[type=checkbox] {
            cursor: pointer;
        }

        .btn-white {
            border: 1px solid #797979;
            background-color: #FFFFff;
            color: #000000;
        }

        #withdraw-table .btn-width {
            width: 6em;
        }

        [v-cloak] {
            display: none;
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
                <small>提现</small>
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
                            <form action="{{ secure_route('withdraws.index') }}" class="form-horizontal"
                                  id="search-form">
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
                                            <option value="1">等待审核</option>
                                            <option value="2">等待打款</option>
                                            <option value="3">审核驳回</option>
                                            <option value="4">打款完成</option>
                                            <option value="5">打款失败</option>
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
                                </div>
                            </form>
                        </div>
                        <hr style="margin-top: 1em">
                        <div class="box-body">
                            <table class="table table-bordered table-hover" id="withdraw-table">
                                <thead>
                                <tr>
                                    <th>提现编号</th>
                                    <th>提现金额</th>
                                    <th>提现手续费</th>
                                    <th>实际金额</th>
                                    <th>状态</th>
                                    <th>收款信息</th>
                                    <th>供应商名称</th>
                                    <th>备注</th>
                                    <th>申请时间</th>
                                    <th>银行流水号</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="withdraw in withdraws" v-cloak>
                                    <td>@{{ withdraw.withdraw_code }}</td>
                                    <td>@{{ withdraw.amout }}</td>
                                    <td>@{{ withdraw.charge }}</td>
                                    <td>@{{ withdraw.amout - withdraw.charge }}</td>
                                    <td>@{{ allstatus[withdraw.status] }}</td>
                                    <td class="text-left">
                                        <p class="text-left">收款人：@{{ withdraw.account_name }}</p>
                                        <p class="text-left">帐号：@{{ withdraw.account_number }}</p>
                                        <p class="text-left">开户行：
                                            @{{ withdraw.bank_name+' '+withdraw.bank_province+' '+withdraw.bank_city+
                                            ' '+withdraw.bank_branch }}
                                        </p>
                                    </td>
                                    <td>@{{ withdraw.supplier_name }}</td>
                                    <td>@{{ withdraw.note }}</td>
                                    <td>@{{ withdraw.created_at }}</td>
                                    <td>@{{ withdraw.swift_number }}</td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <template v-if="withdraw.status==='1'">
                                                <div class="">
                                                    <button class="btn btn-sm btn-primary btn-width"
                                                            :data-id="withdraw.id"
                                                            @click="passApply">通过
                                                    </button>
                                                    <div class="">
                                                    </div>
                                                    <button style="margin-top: 10px;"
                                                            class="btn btn-sm btn-white btn-width"
                                                            :data-id="withdraw.id"
                                                            @click="rejectApply">
                                                        驳回
                                                    </button>
                                                </div>
                                            </template>
                                            <template v-else-if="withdraw.status==='2'">
                                                <div class="">
                                                    <button class="btn btn-sm btn-primary btn-width"
                                                            :data-id="withdraw.id"
                                                            @click="confirmGiro">
                                                        确认打款
                                                    </button>
                                                </div>
                                                <div class="">
                                                    <button style="margin-top: 10px;"
                                                            class="btn btn-sm btn-white btn-width"
                                                            :data-id="withdraw.id"
                                                            @click="giroFailed">
                                                        打款失败
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $withdraws->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('script')
    <script src="{{asset('/assets/js/bower_components/axios/dist/axios.min.js')}}"></script>
    <script src="{{asset('/assets/admin/js/vue.min.js')}}"></script>
    <script src="{{ asset('/assets/js/plugincommon.js') }}"></script>
    <script>
        var searchForm = new Vue({
            el: '#search-form',
            data: {
                info: {
                    settle_code: '{{ old('withdraw_code') }}',
                    status: '{{ old('status') }}',
                    time: '{{ old('time') }}',
                    supplier_id: '{{ old('supplier_id') }}',
                    supplier_id_input: '{{ old('supplier_id_input') }}',
                }
            }
        });
        var withdrawTable = new Vue({
            el: '#withdraw-table',
            data: {
                withdraws: [
                        @foreach($withdraws as $withdraw){
                        id: '{{ $withdraw->id }}',
                        withdraw_code: '{{ $withdraw->withdraw_code }}',
                        charge: '{{ $withdraw->charge }}',
                        amout: '{{ $withdraw->amout }}',
                        status: '{{ $withdraw->status }}',
                        note: '{{ $withdraw->note }}',
                        created_at: '{{ $withdraw->created_at }}',
                        swift_number: '{{ $withdraw->swift_number }}',
                        account_name: '{{ $withdraw->supplier->SupplierAccount->account_name }}',
                        account_number: '{{ $withdraw->supplier->SupplierAccount->account_number }}',
                        bank_name: '{{ $withdraw->supplier->SupplierAccount->bank_name }}',
                        bank_province: '{{ $withdraw->supplier->SupplierAccount->bank_province }}',
                        bank_city: '{{ $withdraw->supplier->SupplierAccount->bank_city }}',
                        bank_branch: '{{ $withdraw->supplier->SupplierAccount->bank_branch }}',
                        supplier_name: '{{ $withdraw->supplier->name }}',
                    },
                    @endforeach
                ],
                allstatus:{!! json_encode($allstatus) !!}
            },
            methods: {
                passApply: function (event) {
                    let apiUri = '{{ secure_route('withdraws.passapply') }}';
                    let _thisEl = event.currentTarget;
                    let withdrawId = _thisEl.getAttribute('data-id');
                    this.alertWindowOne('确认通过', '备注');
                    var submitBox = new Vue({
                        el: '#submit-box',
                        data: {
                            note: '',
                            canSubmit: true
                        },
                        methods: {
                            submitNote: function () {
                                this.canSubmit = false;
                                axios.post(apiUri, {withdrawId: withdrawId, note: this.note}).then(function (res) {
                                    if (res.data.status === 200) {
                                        toastr.options.timeOut = 0.5;
                                        toastr.options.onHidden = function () {
                                            top.location.reload();
                                        };
                                        toastr.success('操作成功');
                                    } else {
                                        toastr.error('操作失败');
                                    }
                                })
                            }
                        }
                    });
                },
                rejectApply: function (event) {
                    let apiUri = '{{ secure_route('withdraws.rejectapply') }}';
                    let _thisEl = event.currentTarget;
                    let withdrawId = _thisEl.getAttribute('data-id');
                    this.alertWindowOne('确认驳回', '驳回原因');
                    var submitBox = new Vue({
                        el: '#submit-box',
                        data: {
                            note: '',
                            canSubmit: true
                        },
                        methods: {
                            submitNote: function () {
                                this.canSubmit = false;
                                axios.post(apiUri, {withdrawId: withdrawId, note: this.note}).then(function (res) {
                                    if (res.data.status === 200) {
                                        toastr.options.timeOut = 0.5;
                                        toastr.options.onHidden = function () {
                                            top.location.reload();
                                        };
                                        toastr.success('操作成功');
                                    } else {
                                        toastr.error('操作失败');
                                    }
                                })
                            }
                        }
                    });
                },
                confirmGiro: function (event) {
                    let apiUri = '{{ secure_route('withdraws.confirmgiro') }}';
                    let _thisEl = event.currentTarget;
                    let withdrawId = _thisEl.getAttribute('data-id');
                    this.alertWindowTwo();
                    var submitBox = new Vue({
                        el: '#submit-box',
                        data: {
                            swift_number: '',
                            canSubmit: true
                        },
                        methods: {
                            submitNote: function () {
                                this.canSubmit = false;
                                axios.post(apiUri, {
                                    withdrawId: withdrawId,
                                    swift_number: this.swift_number
                                }).then(function (res) {
                                    if (res.data.status === 200) {
                                        toastr.options.timeOut = 0.5;
                                        toastr.options.onHidden = function () {
                                            top.location.reload();
                                        };
                                        toastr.success('操作成功');
                                    } else {
                                        toastr.error('操作失败');
                                    }
                                })
                            }
                        }
                    })
                },
                giroFailed: function (event) {
                    let apiUri = '{{ secure_route('withdraws.girofailed') }}';
                    let _thisEl = event.currentTarget;
                    let withdrawId = _thisEl.getAttribute('data-id');
                    this.alertWindowOne('打款失败', '驳回原因');
                    var submitBox = new Vue({
                        el: '#submit-box',
                        data: {
                            note: '',
                            canSubmit: true
                        },
                        methods: {
                            submitNote: function () {
                                this.canSubmit = false;
                                axios.post(apiUri, {withdrawId: withdrawId, note: this.note}).then(function (res) {
                                    if (res.data.status === 200) {
                                        toastr.options.timeOut = 0.5;
                                        toastr.options.onHidden = function () {
                                            top.location.reload();
                                        };
                                        toastr.success('操作成功');
                                    } else {
                                        toastr.error('操作失败');
                                    }
                                })
                            }
                        }
                    })
                },
                //样式1,普通样式
                alertWindowOne: function (title, tip) {
                    let content = '<div class="" style="width: 500px;padding: 20px;" id="submit-box">\n' +
                        '                                <div class="">\n' +
                        '                                    <p class="text-center" style="height: 80px;line-height: 80px;">\n' +
                        '                                        <span class="h3" style="font-weight: bold">' + title + '</span>\n' +
                        '                                    </p>\n' +
                        '                                    <p style="height: 30px;line-height: 30px;">' + tip + '</p>\n' +
                        '                                    <p>\n' +
                        '                                        <textarea class="form-control" name="" v-model="note" cols="20" rows="3"></textarea>\n' +
                        '                                    </p>\n' +
                        '                                    <p style="margin-top: 40px;">\n' +
                        '                                        <input type="button" id="confirm" class="btn btn-sm btn-primary col-sm-offset-4" v-if="canSubmit" @click="submitNote" value="确认">\n' +
                        '                                        <input type="button" id="confirm" class="btn btn-sm btn-primary col-sm-offset-4" v-else value="确认中">\n' +
                        '                                        <input type="button" id="cancel" class="btn btn-sm col-sm-offset-2" @click="withdrawTable.closeLayer" value="取消">\n' +
                        '                                    </p>\n' +
                        '                                </div>\n' +
                        '                            </div>';
                    showContent(['title', 'display:none'], content, ['500px', '350px']);
                },
                //样式2,流水号类型
                alertWindowTwo: function () {
                    let content = '<div class="" style="overflow-x: hidden" id="submit-box">\n' +
                        '                                <div class="form-horizontal">\n' +
                        '                                    <p class="text-center" style="height: 80px;line-height: 80px;">\n' +
                        '                                        <span class="h3" style="font-weight: bold">确认打款</span>\n' +
                        '                                    </p>\n' +
                        '                                    <div class="form-group">\n' +
                        '                                        <label for="swift-number" class="control-label col-sm-3">银行流水号</label>\n' +
                        '                                        <div class="col-sm-8">\n' +
                        '                                            <input type="text" v-model="swift_number" class="form-control">\n' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                    <p style="margin-top: 30px;">\n' +
                        '                                        <input type="button" class="btn btn-sm btn-primary col-sm-offset-4" v-if="canSubmit" @click="submitNote" value="确认">\n' +
                        '                                        <input type="button" id="confirm" class="btn btn-sm btn-primary col-sm-offset-4" v-else value="确认中">\n' +
                        '                                        <input type="button" class="btn btn-sm col-sm-offset-2" @click="withdrawTable.closeLayer" value="取消">\n' +
                        '                                    </p>\n' +
                        '                                </div>\n' +
                        '                            </div>';
                    showContent(['title', 'display:none'], content, ['500px', '250px']);
                },
                closeLayer: function () {
                    layer.closeAll();
                }


            }
        })
    </script>
@endsection