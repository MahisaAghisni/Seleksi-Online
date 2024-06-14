<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image" style="background: #fafafa"></figure>
            <div class="user-info">
                <img src="{{ asset('assets/user-profile/' . $admin->avatar) }}" alt="avatar" class="bg-white">
                <h6 class="">{{ $admin->nama_admin }}</h6>
                <p class="">Admin BLK Sumenep</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ $menu['menu'] == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('/admin') }}" aria-expanded="{{ $menu['expanded'] == 'dashboard' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <span data-feather="airplay"></span>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-minus">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg><span>MASTER DATA</span></div>
            </li>
            <li class="menu {{ $menu['menu'] == 'master' ? 'active' : '' }}">
                <a href="#components" data-toggle="collapse"
                    aria-expanded="{{ $menu['expanded'] == 'master' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>User</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $menu['collapse'] == 'master' ? 'show' : '' }}"
                    id="components" data-parent="#accordionExample">
                    <li class="{{ $menu['sub'] == 'peserta' ? 'active' : '' }}">
                        <a href="{{ url('/admin/peserta') }}"> Peserta </a>
                    </li>
                    <li class="{{ $menu['sub'] == 'instruktur' ? 'active' : '' }}">
                        <a href="{{ url('/admin/instruktur') }}"> Instruktur </a>
                    </li>
                </ul>
            </li>
            <li class="menu {{ $menu['menu'] == 'pelatihan' ? 'active' : '' }}">
                <a href="{{ url('/admin/pelatihan') }}"
                    aria-expanded="{{ $menu['expanded'] == 'pelatihan' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Pelatihan</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ $menu['menu'] == 'gelombang' ? 'active' : '' }}">
                <a href="{{ url('/admin/gelombang') }}"
                    aria-expanded="{{ $menu['expanded'] == 'gelombang' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                        <span>Seleksi</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ $menu['menu'] == 'relasi' ? 'active' : '' }}">
                <a href="{{ url('/admin/relasi') }}"
                    aria-expanded="{{ $menu['expanded'] == 'relasi' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                            stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                            class="css-i6dzq1">
                            <line x1="6" y1="3" x2="6" y2="15"></line>
                            <circle cx="18" cy="6" r="3"></circle>
                            <circle cx="6" cy="18" r="3"></circle>
                            <path d="M18 9a9 9 0 0 1-9 9"></path>
                        </svg>
                        <span>Relasi</span>
                    </div>
                </a>
            </li>
            <li class="menu menu-heading">
                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg><span>USER MENU</span></div>
            </li>
            <li class="menu {{ $menu['menu'] == 'profile' ? 'active' : '' }}">
                <a href="{{ url('/admin/profile') }}"
                    aria-expanded="{{ $menu['expanded'] == 'profile' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                            stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                            class="css-i6dzq1">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Profile</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="{{ url('/logout') }}" aria-expanded="false" class="dropdown-toggle logout">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                            stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                            class="css-i6dzq1">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </div>
                </a>
            </li>
        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->
