@section('title', 'Sign In')
@include('layout.head')

@include('layout.css')

<body>
<div class="app-wrapper d-block">
    <div class="">
        <!-- Body main section starts -->
        <main class="w-100 p-0">
            <!-- Login to your Account start -->
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

                                {{-- Add CSRF token and form attributes --}}
                                <form class="app-form" method="POST" action="{{ route('login.post') }}">
                                    @csrf
                                    <div class="mb-4 text-center">
                                        <h3>Login to your Account</h3>
                                        {{-- <p class="f-s-12 text-secondary">Get started with our app, just create an account and enjoy the experience.</p> --}}
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text text">We'll never share your email with anyone else.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control">
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="formCheck1" name="remember">
                                        <label class="form-check-label" for="formCheck1">Remember me</label>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100 rounded">Submit</button>
                                    </div>
                                    {{-- Rest of the form --}}
                                    <div class="col-12">
                                        <div class="text-center text-lg-start">
                                            Don't Have Your Account yet? <a href="{{route('register')}}"
                                                                            class="link-primary text-decoration-underline"> Sign up</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Login to your Account end -->
        </main>
        <!-- Body main section ends -->
    </div>
</div>

</body>
@section('script')

    <!-- Bootstrap js-->
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
@endsection
