@extends('layouts.blank')
@section('css')
    <style>
        .table{
            width: 80%;
            margin: 50px auto;
        }
    </style>
@endsection
@section('content')
    <div class="modal-content">
        <div class="modal-body box-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td>创建时间</td>
                        <td>{{$good->created_at}}</td>
                    </tr>
                    <tr>
                        <td>提交时间</td>
                        <td>{{$good->submit_at }}</td>
                    </tr>
                    <tr>
                        <td>审核时间</td>
                        <td>{{$good->audit_at}}</td>
                    </tr>
                    <tr>
                        <td>编辑时间</td>
                        <td>{{$good->edited_at}}</td>
                    </tr>
                    <tr>
                        <td>首次上架时间</td>
                        <td>{{$good->getProduct->shelf_at ?? ''}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('script')
@stop