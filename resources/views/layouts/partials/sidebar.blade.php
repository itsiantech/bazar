<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-search-wrapper">
                <form class="sidebar-search  sidebar-search-bordered" action="page_general_search_3.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                             <a href="javascript:;" class="btn submit">
                                 <i class="icon-magnifier"></i>
                             </a>
                         </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            @if(\Illuminate\Support\Facades\Auth::user()->type=='admin')
                <li class="nav-item start ">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
            @endif

            @if(\Illuminate\Support\Facades\Auth::user()->type=='admin' ||\Illuminate\Support\Facades\Auth::user()->type=='delivery_man')
                <li class="nav-item  ">
                    <a href="{{ route('order.index') }}" class="nav-link">
                        <i class="icon-diamond"></i>
                        <span class="title">Orders</span>
                    </a>
                </li>
            @endif


            @if(\Illuminate\Support\Facades\Auth::user()->type=='admin')
                <li class="nav-item  ">
                    <a href="{{ route('slider.index') }}" class="nav-link">
                        <i class="fa fa-sliders"></i>
                        <span class="title">Sliders</span>
                    </a>
                </li>

                <li class="nav-item  ">
                    <a href="{{ route('brand.index') }}" class="nav-link">
                        <i class="fa fa-btc"></i>
                        <span class="title">Brands</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="fa fa-bars"></i>
                        <span class="title">Categories</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('coupon.index') }}" class="nav-link">
                        <i class="fa fa-bomb"></i>
                        <span class="title">Coupons</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('discount.index') }}" class="nav-link">
                        <i class="fa fa-sort-numeric-asc"></i>
                        <span class="title">Discounts</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('wallet.index') }}" class="nav-link">
                        <i class="fa fa-sort-numeric-asc"></i>
                        <span class="title">Wallets</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('deliveryCharge.index') }}" class="nav-link">
                        <i class="fa fa-bicycle"></i>
                        <span class="title">Delivery Charge</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('product.index') }}" class="nav-link">
                        <i class="fa fa-picture-o"></i>
                        <span class="title">Products</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('product.bundleList') }}" class="nav-link">
                        <i class="fa fa-picture-o"></i>
                        <span class="title">Bundles</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('product.deleted') }}" class="nav-link">
                        <i class="fa fa-photo"></i>
                        <span class="title">Deleted Products</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('product_request.index') }}" class="nav-link">
                        <i class="fa fa-opencart"></i>
                        <span class="title">Product Requests</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ route('topProduct.index') }}" class="nav-link">
                        <i class="fa fa-recycle"></i>
                        <span class="title">Update Top Products</span>
                    </a>
                </li>

                <li class="nav-item  ">
                    <a href="{{ route('customer.index') }}" class="nav-link">
                        <i class="fa fa-users"></i>
                        <span class="title">Customers</span>
                    </a>
                </li>

                <li class="nav-item  ">
                    <a href="{{ route('employee.index') }}" class="nav-link">
                        <i class="fa fa-users"></i>
                        <span class="title">Employee</span>
                    </a>
                </li>

                <li class="nav-item  ">
                    <a href="{{ route('refund.index') }}" class="nav-link">
                        <i class="fa fa-dollar"></i>
                        <span class="title">Refunds</span>
                    </a>
                </li>

                <li class="nav-item  ">
                    <a href="{{ route('chats.dashboard') }}" class="nav-link">
                        <i class="fa fa-dollar"></i>
                        <span class="title">Chats</span>
                    </a>
                </li>

                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-gear"></i>
                        <span class="title">Settings</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item  ">
                            <a href="{{ route('role.index') }}" class="nav-link ">
                                <span class="title">Roles</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="ui_general.html" class="nav-link ">
                                <span class="title">Permission</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="heading">
                    <h3 class="uppercase">Delivery Man Area</h3>
                </li>
            @endif



            @if(\Illuminate\Support\Facades\Auth::user()->type=='admin' ||\Illuminate\Support\Facades\Auth::user()->type=='moderator')

                <li class="nav-item  ">
                    <a href="{{ route('page.index') }}" class="nav-link">
                        <i class="fa fa-file"></i>
                        <span class="title">Pages</span>
                    </a>
                </li>
            @endif


            {{-- <li class="nav-item  ">--}}
            {{-- <a href="javascript:;" class="nav-link nav-toggle">--}}
            {{-- <i class="icon-diamond"></i>--}}
            {{-- <span class="title">UI Features</span>--}}
            {{-- <span class="arrow"></span>--}}
            {{-- </a>--}}
            {{-- <ul class="sub-menu">--}}
            {{-- <li class="nav-item  ">--}}
            {{-- <a href="ui_colors.html" class="nav-link ">--}}
            {{-- <span class="title">Color Library</span>--}}
            {{-- </a>--}}
            {{-- </li>--}}
            {{-- <li class="nav-item  ">--}}
            {{-- <a href="ui_general.html" class="nav-link ">--}}
            {{-- <span class="title">General Components</span>--}}
            {{-- </a>--}}
            {{-- </li>--}}
            {{-- </ul>--}}
            {{-- </li>--}}
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
