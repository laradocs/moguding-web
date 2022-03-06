<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item no-arrow mx-1">
            <a class="nav-link" href="https://www.github.com/laradocs" title="">
                <i class="fa-brands fa-github fa-xl"></i>
            </a>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{ $user->avatar }}" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">{{ $user->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a id="logout" class="dropdown-item" href="javascript:void(0);">
                    <i class="fas fa-power-off"></i>
                    <span>安全退出</span>
                </a>
            </div>
        </li>
    </ul>
</nav>
