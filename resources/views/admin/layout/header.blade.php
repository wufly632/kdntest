@include('admin.layout.toplink')
<?php 
$current_url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
// 产生自增数
function getNum()
{
    static $a = 1;
    $a++;
    return $a;
}
?>
<div class="admin-bar clearfix bgstyle">
    <nav>
        <dl class="left-width">
            <dt>类目属性</dt>
        </dl>
        <dd>
            <a href="{{route('category.index')}}" key='<?php echo getNum();?>' >类目管理</a>
        </dd>
        <dd>
            <a href="{{route('attribute.index')}}" key='<?php echo getNum();?>'>属性管理</a>
        </dd>
        <dl class="left-width">
            <dt>商品管理</dt>
        </dl>
        <dd>
            <a href="{{route('good.index')}}" key='<?php echo getNum();?>' >商品列表</a>
        </dd>
    </nav>
</div>
<script>
    $('.bgstyle a').click(function(){
        that = $(this);
        sessionStorage.setItem("key", that.attr('key'));
    })
    if (sessionStorage.getItem("key")) {
        $('a[key='+sessionStorage.getItem("key")+']').parent('dd').addClass('active');
    }
</script>