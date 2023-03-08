<!-- Top Bar Start -->
<div class="topbar">

    <nav class="navbar-custom">

        <ul class="d-flex justify-content-end align-items-center mb-0 px-4">
            <!-- language-->

            <li class="list-inline-item notification-list">
                <a href="#" class="nav-link waves-effect nav-user" style="text-transform:capitalize;">
                    {{ Auth::user()->role }}
                </a>
            </li>
            {{-- <li class="list-inline-item notification-list">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn">Logout</button>
                </form>
            </li> --}}
            <li class="profile_area list-inline-item">
                <div class="profile_dropdown_area">
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span>
                                <?= Auth::user()->name?>
                            </span>
                            <img src="{{asset('public/uploads/default.png')}}" alt="" class="rounded-circle">
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('users.profile',['id' =>Auth::user()->id ])}}">
                                <i class="fas fa-user"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{route('logout')}}">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
        </ul>

        <div class="clearfix"></div>

    </nav>

</div>
<!-- Top Bar End -->