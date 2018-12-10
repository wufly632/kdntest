@extends('layouts.default')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Fixed Layout
                <small>Blank example to the fixed layout</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Layout</a></li>
                <li class="active">Fixed</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <form action="" method="post">
                物流单号：<input type="text" name=""><br>
                物流公司:
                <select name="">
                    <option value="">请选择</option>
                </select>
                <br>
                <button type="submit">提交</button>
            </form>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop