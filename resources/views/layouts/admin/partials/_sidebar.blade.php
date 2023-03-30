<style>
.side-logo {
      background-color: #ffffff;
  }
</style>
<div id="sidebarMain" class="d-none">
    <aside class="aside-back js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container text-capitalize">
            <div class="navbar-vertical-footer-offset">
                <div class="navbar-brand-wrapper justify-content-between nav-brand-back side-logo">
                    <!-- Logo -->
                    @php($shop_logo=\App\Models\BusinessSetting::where(['key'=>'shop_logo'])->first()->value)
                    <a class="navbar-brand" href="{{route('admin.dashboard')}}" aria-label="Front">
                        <img class="navbar-brand-logo"
                             onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                             src="{{asset('storage/app/public/shop')}}/{{ $shop_logo }}"
                             alt="{{\App\CPU\translate('logo')}}">
                    </a>
                    <!-- End Logo -->
                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                            class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li class="nav-item">
                            <small
                                class="nav-subtitle">{{\App\CPU\translate('dashboard_section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.dashboard')}}" title="{{\App\CPU\translate('dashboards')}}">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('dashboard')}}
                                </span>
                            </a>
                        </li>
                        <!-- End Dashboards -->
                        <li class="nav-item">
                            <small
                                class="nav-subtitle">{{\App\CPU\translate('pos_section')}}</small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>


                        <li class="navbar-vertical-aside-has-menu 
                        {{Request::is('admin/customer*')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.customer.list')}}" title="{{\App\CPU\translate('customer')}}">
                                <i class="tio-poi-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\translate('Customer')}}
                                </span>
                            </a>
                        </li>

                        @php($orders = \App\Models\Order::get()->count())
                        <li class="navbar-vertical-aside-has-menu 
                        {{Request::is('admin/pos*')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.pos.orders')}}" title="{{\App\CPU\translate('orders')}}">
                                <i class="tio-shopping nav-icon"></i>
                                <span class="text-truncate">{{\App\CPU\translate('orders')}}
                                    <span class="badge badge-success ml-2">{{ $orders }} </span>
                                </span>
                            </a>
                        </li>
                        <!-- Pos Pages -->

                  
                        <!-- Product Pages -->
                        <li class="navbar-vertical-aside-has-menu 
                             {{Request::is('admin/product*')?'active':''}}
                             {{-- {{Request::is('admin/supplier*')?'active':''}} --}}
                             {{Request::is('admin/category*')?'active':''}}
                             {{Request::is('admin/unit*')?'active':''}}
                             {{Request::is('admin/brand*')?'active':''}}
                             {{Request::is('admin/stock*')?'active':''}}
                           ">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            > <i class="tio-premium-outlined nav-icon"></i>
                             <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('product')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub 
                                {{Request::is('admin/product*')?'d-block':''}}
                                {{-- {{Request::is('admin/supplier*')?'d-block':''}} --}}
                                {{Request::is('admin/category*')?'d-block':''}}
                                {{Request::is('admin/unit*')?'d-block':''}}
                                {{Request::is('admin/brand*')?'d-block':''}}
                                {{Request::is('admin/stock*')?'d-block':''}}
                              ">
                                <li class="nav-item {{Request::is('admin/supplier*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.supplier.list')}}"
                                       title="{{\App\CPU\translate('list_of_products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('suppliers')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/product/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.product.list')}}"
                                       title="{{\App\CPU\translate('list_of_products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('all_products')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item 
                                    {{Request::is('admin/category/add')?'active':''}}
                                    {{Request::is('admin/category/edit*')?'active':''}}
                                    ">
                                    <a class="nav-link " href="{{route('admin.category.add')}}"
                                       title="{{\App\CPU\translate('list_of_products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('categories')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item 
                                   {{Request::is('admin/category/add-sub-category')?'active':''}}
                                   {{Request::is('admin/category/sub-edit*')?'active':''}}
                                ">
                                    <a class="nav-link " href="{{route('admin.category.add-sub-category')}}"
                                       title="{{\App\CPU\translate('add_new_sub_category')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('sub_category')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/unit*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.unit.index')}}"
                                       title="{{\App\CPU\translate('list_of_products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('units')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/brand*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.brand.add')}}"
                                       title="{{\App\CPU\translate('list_of_products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('brands')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/stock*')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.stock.stock-limit')}}"
                                       title="{{\App\CPU\translate('list_of_products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('stock_limit_products')}}</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item {{Request::is('admin/product/bulk-import')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.product.bulk-import')}}"
                                       title="{{\App\CPU\translate('bulk_import')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('bulk_import')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/product/bulk-export')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.product.bulk-export')}}"
                                       title="{{\App\CPU\translate('bulk_export')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('bulk_export')}}</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                        <!-- Product Pages -->

                        
                 
                
                        <!-- Account start pages -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/account*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-wallet nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('account_management')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/account*')?'d-block':''}}">
                                <li class="nav-item {{Request::is('admin/account/add')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.account.add')}}"
                                       title="{{\App\CPU\translate('add_new_account')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('add_new_account')}}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{Request::is('admin/account/list')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.account.list')}}"
                                       title="{{\App\CPU\translate('account_list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('accounts')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/account/add-expense')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.account.add-expense')}}"
                                       title="{{\App\CPU\translate('add_new_expense')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('new_expense')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/account/add-income')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.account.add-income')}}"
                                       title="{{\App\CPU\translate('add_new_income')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('new_income')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/account/add-transfer')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.account.add-transfer')}}"
                                       title="{{\App\CPU\translate('add_new_transfer')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('new_transfer')}}</span>
                                    </a>
                                </li>
                            
                                <li class="nav-item {{Request::is('admin/account/list-transection')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.account.list-transection')}}"
                                       title="{{\App\CPU\translate('list_of_transection')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\translate('transection_list')}}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                            >
                                <i class="tio-settings nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{\App\CPU\translate('settings')}}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub {{Request::is('admin/business-settings*')?'d-block':''}}">
                                <li class="nav-item {{Request::is('admin/business-settings/shop-setup')?'active':''}}">
                                    <a class="nav-link " href="{{route('admin.business-settings.shop-setup')}}"
                                    >
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate">{{\App\CPU\translate('shop')}} {{\App\CPU\translate('setup')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>
