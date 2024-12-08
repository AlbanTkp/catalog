@extends('layouts.master')
{{-- @section('sidebar')
@endsection
@section('navbar')
@endsection --}}
@section('script')
    <script>
      $('main').addClass('m-5')
    </script>
@endsection
@section('content')
      <!-- ========== signin-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title mb-30">
                  <h1 class="text-primary display-1">{{env('APP_NAME')}}</h1>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->

          <div class="row g-0 auth-row">
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    @isset($page_title)
                    <h1 class="text-primary mb-10">{{$page_title}}</h1>
                    @endisset
                    @isset($page_subtitle)
                    <p class="text-medium">
                        {{$page_subtitle}}
                    </p>
                    @endisset
                  </div>
                  <div class="cover-image">
                    <img src="{{asset('assets/images/auth/signin-image.svg')}}" alt="" />
                  </div>
                  <div class="shape-image">
                    <img src="{{asset('assets/images/auth/shape.svg')}}" alt="" />
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signup-wrapper">
                <div class="form-wrapper">
                  {{-- <h6 class="mb-15">Sign Up Form</h6>
                  <p class="text-sm mb-25">
                    Start creating the best possible user experience for you
                    customers.
                  </p> --}}
                  @yield('form-content')
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signin-section end ========== -->
@endsection
