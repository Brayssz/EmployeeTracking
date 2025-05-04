<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Tracking</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- NProgress CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">

    @vite(['resources/css/mdb.min.css', 'resources/css/mdb.rtl.min.css'])

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .nav-link:hover span,
        .nav-link:hover i {
            color: white !important;
        }
    </style>

</head>

<body>
    <div class="d-flex justify-content-between align-items-center mr-2 bg-light">
        <div></div>
        <div id="datetime" class="text-muted"></div>
    </div>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-body-tertiary vh-100% p-3" style="width: 250px;">
            <div class="text-center mb-4">
                <img src="{{asset('img/logo.png')}}" height="135px" alt="Logo"
                    loading="lazy" />
                <i class="d-flex text-center justify-content-center font-fira-sans">CHEDROXII</i>
            </div>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 @if (Route::currentRouteName() == 'dashboard') active @endif"
                        href="dashboard">
                        <i class="fa fa-th-large me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 @if (Route::currentRouteName() == 'tracking') active @endif"
                        href="tracking">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span>Location</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 @if (Route::currentRouteName() == 'users') active @endif"
                        href="users"><i class="fas fa-users me-2"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 @if (Route::currentRouteName() == 'departments') active @endif"
                        href="departments">
                        <i class="fas fa-building me-2"></i>
                        <span>Departments</span></a>
                </li>
                <hr>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 @if (Route::currentRouteName() == 'travels') active @endif"
                        href="travels">
                        <i class="fas fa-plane me-2"></i>
                        <span>Travels</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 @if (Route::currentRouteName() == 'travel-users') active @endif"
                        href="travel-users">
                        <i class="fas fa-users me-2"></i>
                        <span>Travel Participants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 @if (Route::currentRouteName() == 'travel-attendance') active @endif"
                        href="travel-attendance">
                        <i class="far fa-calendar-check me-2"></i>
                        <span>Travel Attendance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 @if (Route::currentRouteName() == 'daily-attendance') active @endif"
                        href="daily-attendance">
                        <i class="far fa-calendar-check me-2"></i>
                        <span>Daily Attendance</span>
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-primary m-2 d-flex align-items-center justify-content-start border border-b-blue-700 w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
            {{-- <hr>
            <div class="position-fixed bottom-0 end-0 p-3">
                <div class="dropdown">
                    @php
                        $user = Auth::user();
                        $initials = strtoupper(substr($user->name, 0, 1)) . strtoupper(substr(strrchr($user->name, ' '), 1, 1));
                    @endphp
                    <a data-mdb-dropdown-init
                        class="dropdown-toggle d-flex align-items-center hidden-arrow rounded-circle overflow-hidden"
                        href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false"
                        style="width: 40px; height: 40px;">
                        <div class="rounded-circle text-white d-flex justify-content-center align-items-center border border-white"
                            style="width: 40px; height: 40px; background-color: #007bff; font-weight: bold; font-size: 0.75rem;">
                            {{ $initials }}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <li><a class="dropdown-item" href="#">My profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div> --}}

        </nav>
        <!-- Sidebar -->

        <!-- Content Area -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
    {{-- <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <!-- Container wrapper -->
        <div class="container-fluid mx-5">
            <!-- Toggle button -->
            <button data-mdb-collapse-init class="navbar-toggler" type="button"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar brand -->
                <a class="navbar-brand mt-2 mt-lg-0" href="#">
                    <img src="{{ asset('img/logo.png') }}" height="40" alt="MDB Logo" loading="lazy" />
                </a>
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link @if (Route::currentRouteName() == 'tracking') active @endif" href="tracking"
                            aria-current="page">Tracking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (Route::currentRouteName() == 'users') active @endif" href="users"
                            aria-current="page">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (Route::currentRouteName() == 'departments') active @endif" href="departments"
                            aria-current="page">Departments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (Route::currentRouteName() == 'travels') active @endif" href="travels"
                            aria-current="page">Travels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (Route::currentRouteName() == 'travel-users') active @endif" href="travel-users"
                            aria-current="page">Travel Participants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (Route::currentRouteName() == 'travel-attendance') active @endif" href="travel-attendance"
                            aria-current="page">Travel Attendance</a>
                    </li>
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->

            <!-- Right elements -->
            <div class="d-flex align-items-center">

                <div class="dropdown">
                    <a data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow"
                        href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                        @php
                            $user = Auth::user();
                            $initials =
                                strtoupper(substr($user->name, 0, 1)) .
                                strtoupper(substr(strrchr($user->name, ' '), 1, 1));
                        @endphp
                        <div class="rounded-circle text-white d-flex justify-content-center align-items-center"
                            style="width: 32px; height: 32px; background-color: #007bff; font-weight: bold; font-size: 0.75rem;">
                            {{ $initials }}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <li><a class="dropdown-item" href="#">My profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="page-wrapper">
        @yield('content')
    </div> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.all.min.js"></script>
    <!-- NProgress JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>

    @vite(['resources/js/bootstrap.js', 'resources/js/mdb.es.min.js', 'resources/js/mdb.umd.min.js'])
    @livewireScripts
    @stack('scripts')
    <script>
        $(document).ready(function() {
            NProgress.start();
            NProgress.done();

            $(window).on("load", function() {
                NProgress.done();
            });

            $(document).ajaxStart(function() {
                NProgress.start();
            });

            $(document).ajaxStop(function() {
                NProgress.done();
            });

            setTimeout(function() {
                if (NProgress.isStarted()) {
                    NProgress.done();
                }
            }, 1000);
        });
    </script>
</body>

</html>
