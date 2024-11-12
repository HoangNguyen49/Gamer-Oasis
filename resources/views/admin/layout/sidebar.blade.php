<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="{{ asset('asset/images/favicon.png') }}" width="50px" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><b>GAMER-OASIS</b></p>
            <p class="app-sidebar__user-designation">Welcome Back</p>
        </div>
    </div>
    <hr>
    <ul class="app-menu">
        <!-- Dashboard -->
        <li><a class="app-menu__item {{ Request::is('admin') ? 'active' : '' }}" href="/admin"><i class='app-menu__icon bx bx-tachometer'></i><span class="app-menu__label">Dashboard</span></a></li>
        
        <!-- Customer Management -->
        <li><a class="app-menu__item {{ Request::is('admin/quanlikhachhang') ? 'active' : '' }}" href="/admin/quanlikhachhang"><i class='app-menu__icon bx bx-user'></i><span class="app-menu__label">Customer Management</span></a></li>
        
        <!-- Product Management -->
        <li><a class="app-menu__item {{ Request::is('admin/quanlisanpham') ? 'active' : '' }}" href="/admin/quanlisanpham"><i class='app-menu__icon bx bx-package'></i><span class="app-menu__label">Product Management</span></a></li>
        
        <!-- Category Management -->
        <li><a class="app-menu__item {{ Request::is('admin/category/management') ? 'active' : '' }}" href="{{ route('category.management') }}"><i class='app-menu__icon bx bx-category'></i><span class="app-menu__label">Category Management</span></a></li>
        
        <!-- Brand Management -->
        <li><a class="app-menu__item {{ Request::is('admin/brand/management') ? 'active' : '' }}" href="{{ route('brand.management') }}"><i class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Brand Management</span></a></li>
        
        <!-- Order Management -->
        <li><a class="app-menu__item {{ Request::is('admin/orders') ? 'active' : '' }}" href="/admin/orders"><i class='app-menu__icon bx bx-task'></i><span class="app-menu__label">Order Management</span></a></li>
        
        <!-- Transaction Verification -->
        <li><a class="app-menu__item {{ Request::is('admin/trans_verifi') ? 'active' : '' }}" href="/admin/trans_verifi"><i class='app-menu__icon bx bx-task'></i><span class="app-menu__label">Transaction Verification</span></a></li>

        <!-- Coupon Management -->
        <li><a class="app-menu__item {{ Request::is('admin/quanlimagiamgia') ? 'active' : '' }}" href="/admin/quanlimagiamgia"><i class='app-menu__icon bx bxs-coupon'></i><span class="app-menu__label">Coupon Management</span></a></li>
        
        <!-- Blog Management -->
        <li><a class="app-menu__item {{ Request::is('admin/quanliblog') ? 'active' : '' }}" href="/admin/quanliblog"><i class='app-menu__icon bx bx-calendar-check'></i><span class="app-menu__label">Blog Management</span></a></li>

        <!-- Contact Management -->
        <li><a class="app-menu__item {{ Request::is('admin/contacts') ? 'active' : '' }}" href="/admin/contacts"><i class='app-menu__icon bx bxs-contact'></i><span class="app-menu__label">Contact Management</span></a></li>
    </ul>
</aside>
