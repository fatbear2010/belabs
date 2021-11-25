<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
       
        <!-- Brand -->
        <a class="navbar-brand pt-0" >
            <img src="{{ asset('argon') }}/img/BL6.png" class="navbar-brand-img" alt="...">
        </a>
        
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        @if(auth()->user()->jabatan1()->nama == "Mahasiswa")
                        <img alt="" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/mhs/{{auth()->user()->nrpnpk}}_m.jpg">
                        @else
                        <img alt="" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/krywn/{{auth()->user()->nrpnpk}}_m.jpg">
                        @endif
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    @if(1==2)
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
            
        </ul>
        @if(!isset($lihat)) 
        <button type="button" onclick="cekkeranjang();" class="btn btn-fik d-md-none" data-toggle="dropdown" id="buka2" style="width: 100%; margin-top:10px;">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang <span id="keranjang2" class="badge badge-pill badge-dark text-light">{{ count((array) session('cart')) }}</span>
        </button>
       @endif
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/BL6.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            
            
            <!-- Form -->
           
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="icofont-home text-fik"></i> Beranda
                    </a>
                </li>
              

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/barang/all') }}">
                        <i class="icofont-fix-tools text-fik"></i> Peminjaman Barang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/lab/all') }}">
                        <i class="icofont-computer text-fik"></i> Penggunaan Laboratorium
                    </a>
                </li>
               @if(auth()->user()->jabatan != 1)
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('/order/all') }}">
                        <i class="icofont-heart-alt" style="color: #f4645f;"></i> Pesanan
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('/item/out') }}">
                        <i class="icofont-paperclip" style="color: #f4645f;"></i> Barang Keluar / Bermasalah
                    </a>
                </li>
               @endif 
               <li class="nav-item">
                <a class="nav-link " href="#navbar-examples1" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples1">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                    <span class="nav-link-text" style="color: #f4645f;">Pengaturan Laboratorium</span>
                </a>

                <div class="collapse " id="navbar-examples1">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/kategori') }}">
                                {{ __('Kategori Barang') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('barang.index') }}">
                                {{ __('Barang') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('barangdetail.index') }}">
                                {{ __('Barang Detail') }}
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('jabatan.index') }}">
                                {{ __('Jabatan') }}
                            </a>
                        </li> -->
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('perbaikan.index') }}">
                                {{ __('Perbaikan') }}
                            </a>
                        </li> --}}
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('status.index') }}">
                                {{ __('Status') }}
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('lab.index') }}">
                                {{ __('Lab') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                {{ __('User') }}
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </li>


               
               <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="icofont-code" style="color: #f4645f;"></i> About Developer
                    </a>
                </li>
<!-- 
                 <li class="nav-item">
                    <a class="nav-link " href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Laravel Examples') }}</span>
                    </a>

                    <div class="collapse show" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile.edit') }}">
                                    {{ __('User profile') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">
                                    {{ __('User Management') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->

                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('icons') }}">
                        <i class="ni ni-planet text-blue"></i> {{ __('Icons') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('map') }}">
                        <i class="ni ni-pin-3 text-orange"></i> {{ __('Maps') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('table') }}">
                      <i class="ni ni-bullet-list-67 text-default"></i>
                      <span class="nav-link-text">Tables</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-circle-08 text-pink"></i> {{ __('Register') }}
                    </a>
                </li> -->
                
            <!-- Divider
            <hr class="my-3">
             Heading 
             <h6 class="navbar-heading text-muted">Documentation</h6>
             Navigation 
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="https://argon-dashboard-laravel.creative-tim.com/docs/getting-started/overview.html">
                        <i class="ni ni-spaceship"></i> Getting started
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://argon-dashboard-laravel.creative-tim.com/docs/foundation/colors.html">
                        <i class="ni ni-palette"></i> Foundation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://argon-dashboard-laravel.creative-tim.com/docs/components/alerts.html">
                        <i class="ni ni-ui-04"></i> Components
                    </a>
                </li>-->
            </ul> 
        </div>
    </div>
</nav>
