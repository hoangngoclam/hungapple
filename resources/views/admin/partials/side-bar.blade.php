<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item selected">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false">
                        <i class="mdi mdi-cellphone"></i>
                        <span class="hide-menu sidebar-item-text">Quản lý sản phẩm</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item active">
                            <a href="{{ route('admin.product') }}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Danh sách sản phẩm</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.addProductGet') }}" class="sidebar-link">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu">Thêm sản phẩm</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item selected">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu sidebar-item-text">Danh mục sản phẩm</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item active">
                            <a href="{{route('admin.category')}}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Danh sách danh mục</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.addCategoryGet') }}" class="sidebar-link">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu">Thêm danh mục</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item selected">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu sidebar-item-text">Quản lý người dùng</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item active">
                            <a href="{{route('admin.user')}}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Danh sách người dùng</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item selected">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-apple"></i>
                        <span class="hide-menu sidebar-item-text">Quản lý thương hiệu</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item active">
                            <a href="{{route('admin.brand')}}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Danh sách thương hiệu</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.addBrandGet') }}" class="sidebar-link">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu">Thêm thương hiệu</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item selected">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-play-box-outline"></i>
                        <span class="hide-menu sidebar-item-text">Quản lý slider</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item active">
                            <a href="{{route('admin.slider')}}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Danh sách slider</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.addSliderGet') }}" class="sidebar-link">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu">Thêm slider</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item selected">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-wallet-giftcard"></i>
                        <span class="hide-menu sidebar-item-text">Quản lý đơn hàng</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item active">
                            <a href="{{route('admin.order')}}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Danh sách đơn hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.addOrderGet') }}" class="sidebar-link">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu">Thêm đơn hàng</span>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
