@section('title', 'Forgot Password')
@include('layout.head')
@include('layout.css')

<body>
<div class="app-wrapper d-block">
    <div class="">
        <main class="w-100 p-0">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12 p-0">
                        <div class="login-form-container">
                            <div class="mb-4">
                                <a class="logo d-inline-block" href="{{route('main.homepage')}}">
                                    <img src="{{asset('../assets/images/logo/SS_Header_1.png')}}" width="250" alt="#">
                                </a>
                            </div>
                            <div class="form_container">

                                {{-- Success Message Alert --}}
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="app-form" method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    
                                    <div class="mb-4 text-center">
                                        <h3>Forgot Password?</h3>
                                        <p class="f-s-12 text-secondary">No worries! Enter your email and we will send you a reset link.</p>
                                    </div>

                                    {{-- Email Input --}}
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="Enter Your Email">
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100 rounded">Send Reset Link</button>
                                    </div>

                                    {{-- Back to Login Link --}}
                                    <div class="col-12">
                                        <div class="text-center text-lg-start">
                                            Remember your password? <a href="{{route('login')}}" class="link-primary text-decoration-underline"> Sign In</a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
</div>

</body>
@section('script')

    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/js/tooltips_popovers.js')}}"></script>
@endsection