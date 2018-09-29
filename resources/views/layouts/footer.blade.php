<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
</footer>
<script>
    function cat_info() {
        layer.open({
            type: 2,
            skin: 'layui-layer-rim', //加上边框
            area: ['60%','600px'],
            fix: false, //不固定
            shadeClose: true,
            maxmin: true,
            shade:0.4,
            title: '个人信息',
            content: "{{secure_route('personal.index')}}",
            end: function(layero, index){
            }
        });
    }
</script>