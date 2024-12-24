@php
    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';

@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros', ['width' => 25, 'withbg' => 'var(--bs-primary)'])</span>
            <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="app-brand justify-content-center">
            @if (Auth::user()->role == 'Admin')
                {{-- <h5 class="mt-3 text-dark fw-bold">Kerapatan Gereja Protestan Minahasa (KGPM)</h5> --}}
            @elseif(Auth::user()->role == 'Karyawan')
                <div class="navbar-nav align-items-center">
                    <div class="app-brand justify-content-center">
                        <nav class="navbar navbar-example navbar-expand-lg ">
                            <img src="logo.jpg" alt="" width="50" class="me-2">
                            <div class="container-fluid">
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbar-ex-2" aria-controls="navbar-ex-2" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbar-ex-2">
                                    <div class="navbar-nav me-auto">
                                        <a class="nav-item nav-link {{ request()->routeIs('barang-masuk.index') ? 'active text-primary' : 'text-dark' }} fw-semibold"
                                            href="{{ route('barang-masuk.index') }}">Barang Masuk</a>
                                        <a class="nav-item nav-link {{ request()->routeIs('beli-barang.index') ? 'active text-primary' : 'text-dark' }} fw-semibold"
                                            href="{{ route('beli-barang.index') }}">Beli Barang</a>
                                        <a class="nav-item nav-link {{ request()->routeIs('keranjang-pesanan.index') ? 'active text-primary' : 'text-dark' }} fw-semibold"
                                            href="{{ route('keranjang-pesanan.index') }}">Keranjang Pesanan</a>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- /Search -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                        @if (Auth::user()->role == 'Admin')
                            <span class="fw-bold d-block">{{ Auth::user()->email }}</span>
                        @else
                            <span class="fw-bold d-block">{{ Auth::user()->karyawan->nama_lengkap }}</span>
                        @endif
                        <small class="text-muted">{{ Auth::user()->role }}</small>
                    </div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                    class="w-px-40 h-auto rounded-circle">
                            </div>
                            <div class="flex-grow-1">
                                @if (Auth::user()->role == 'Admin')
                                    <span class="fw-bold d-block">{{ Auth::user()->email }}</span>
                                @else
                                    <span class="fw-bold d-block">{{ Auth::user()->karyawan->nama_lengkap }}</span>
                                @endif
                                <small class="text-muted">{{ Auth::user()->role }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <span class="align-middle">Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
