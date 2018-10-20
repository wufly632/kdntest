<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('assets/admin-lte//dist/img/user2-160x160.jpg')}}" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>类目属性</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a data-target-url="category" href="{{secure_route('category.index')}}"><i
                                    class="fa fa-circle-o"></i> 类目管理</a></li>
                    <li><a data-target-url="attribute" href="{{secure_route('attribute.index')}}"><i
                                    class="fa fa-circle-o"></i> 属性管理</a></li>
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>商品管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a data-target-url="good" href="{{secure_route('good.index')}}"><i class="fa fa-circle-o"></i>商品列表</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>营销管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a data-target-url="promotion" href="{{secure_route('promotion.index')}}"><i
                                    class="fa fa-circle-o"></i>促销活动</a></li>
                    <li><a data-target-url="coupon" href="{{secure_route('coupon.index')}}"><i
                                    class="fa fa-circle-o"></i>优惠券</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>用户管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a data-target-url="users" href="{{secure_route('users.index')}}"><i
                                    class="fa fa-circle-o"></i>会员管理</a></li>
                    <li><a data-target-url="supplierusers" href="{{secure_route('supplierusers.index')}}"><i
                                    class="fa fa-circle-o"></i>商家管理</a></li>
                    <li><a data-target-url="adminusers" href="{{secure_route('adminusers.index')}}"><i
                                    class="fa fa-circle-o"></i>用户管理</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-th-list"></i>
                    <span>订单管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a data-target-url="orders" href="{{secure_route('orders.index')}}"><i
                                    class="fa fa-circle-o"></i>订单列表</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-th-list"></i>
                    <span>发货管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a data-target-url="preShipOrder" href="{{secure_route('shipOrder.prelist')}}"><i
                                    class="fa fa-circle-o"></i>待发货商品</a></li>
                    <li><a data-target-url="shipOrder" href="{{secure_route('shipOrder.list')}}"><i
                                    class="fa fa-circle-o"></i>发货单列表</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-sitemap"></i>
                    <span>网站设置</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a data-target-url="banners" href="{{secure_route('banners.index')}}"><i
                                    class="fa fa-circle-o"></i>banner设置</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<script>
    let urlPathname = document.location.pathname;
    urlPathnameParse = urlPathname.split('/');
    let urlLink = $('[data-target-url=' + urlPathnameParse[1] + ']');
    // urlLink.parents('.treeview').removeClass('active').removeClass('menu-open');
    urlLink.parents('.treeview').siblings().removeClass('active menu-open').removeClass('menu-open');
    urlLink.parents('.treeview').addClass('active menu-open');
    urlLink.parent('li').addClass('active');
</script>