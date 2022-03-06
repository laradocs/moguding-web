<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route ( 'dashboard' ) }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset ( 'images/logo.png' ) }}" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">蘑菇云</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route ( 'dashboard' ) }}" title="">
            <i class="fa-solid fa-fw fa-gauge-high"></i>
            <span>控制面板</span>
        </a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="{{ route ( 'accounts.index' ) }}" title="">
            <i class="fa-solid fa-fw fa-user"></i>
            <span>账户管理</span>
        </a>
    </li>
</ul>
