<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <title>{{ env('APP_NAME') }} | {{$page_title}}</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    @yield('style')
</head>

<body>
    @auth
        @include('partials.sidebar')
    @endauth
    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper ">
        <!-- ========== header start ========== -->
        @auth
            @include('partials.navbar')
        @endauth
        <!-- ========== header end ========== -->
        @if (auth()->user())
            <section class="section">
                <div class="container-fluid">
                    <!-- ========== title-wrapper start ========== -->
                    <div class="title-wrapper card p-3 my-2 border-0">
                        <div class="row">
                            <div class="col-md-6">
                                @isset($page_title)
                                    <div class="title">
                                        <h2>
                                            {{ $page_title }}
                                            @yield('btn-plus')
                                        </h2>
                                    </div>
                                @endisset
                            </div>
                            <!-- end col -->
                            @yield('title-right')
                            {{-- <div class="col-md-6">
                        <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                eCommerce
                            </li>
                            </ol>
                        </nav>
                        </div>
                    </div> --}}
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- ========== title-wrapper end ========== -->
                    @yield('content')
                </div>
            </section>
        @else
            @yield('content')
        @endif
        <!-- ========== footer start =========== -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 order-last order-md-first">
                        <div class="copyright text-center text-md-start">
                            <p class="text-sm">
                                Designed and Developed by
                                <a href="https://plainadmin.com" rel="nofollow" target="_blank">
                                    PlainAdmin
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6">
                        <div
                            class="
                  terms
                  d-flex
                  justify-content-center justify-content-md-end
                ">
                            <a href="#0" class="text-sm">Term & Conditions</a>
                            <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </footer>
        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/dynamic-pie-chart.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/js/jvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/world-merc.js') }}"></script>
    <script src="{{ asset('assets/js/polyfill.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('script')

    @if (auth()->check())
        <script>
            $(".logout").click(function(e) {
                e.preventDefault();
                document.getElementById('logout-form').submit()
            });
        </script>
    @endif
    @if ($alert = session()->get("alert"))
        <script>
            alert("{{$alert['message']}}");
        </script>
    @endif
    <script>
        $('.sidebar-nav .nav-item').toArray().forEach((li)=>{
            if($(li).find('a').attr('href') == location.href){
                $(li).addClass('active')
            }
        })
    </script>
</body>

</html>
