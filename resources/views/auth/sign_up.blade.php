@section('title', 'Sign Up')
@include('layout.head')

@include('layout.css')

<body class="sign-in-bg">
<div class="app-wrapper d-block">
    <div class="main-container">
        <!-- sign up start -->
        <div class="container">
            <div class="row sign-in-content-bg">
                <div class="col-lg-6 image-contentbox d-none d-lg-block">
                    <div class="form-container">

                        <div class="signup-content mt-4">
                    <span>
                      <img src="{{asset('../assets/images/logo/SS_Header_1.png')}}" alt="" class="img-fluid ">
                    </span>
                        </div>

                        <div class="signup-bg-img">
                            <img src="{{asset('../assets/images/login/02.png')}}" alt="" class="img-fluid">
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 form-contentbox">
                    <div class="form-container">
                        <form class="app-form" method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5 text-center text-lg-start">
                                        <h2 class="text-primary f-w-600">Create Account</h2>
                                        <p>Get Started For Free Today!</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username (16 characters)</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter Your Username" value="{{ old('username') }}" maxlength="16" required>
                                        @error('username')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="username" 
                                               id="username" 
                                               placeholder="Enter Your Username" 
                                               value="{{ old('username') }}" 
                                               maxlength="16" 
                                               required>
                                        <small id="usernameFeedback" class="form-text mt-2"></small>
                                        @error('username')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const usernameInput = document.getElementById('username');
                                        const feedback = document.getElementById('usernameFeedback');
                                
                                        usernameInput.addEventListener('input', function () {
                                            const username = this.value;
                                
                                            if (username.length > 0) {
                                                fetch(`/check_username?username=${username}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.available) {
                                                            feedback.textContent = "Username is available.";
                                                            feedback.classList.remove("text-danger");
                                                            feedback.classList.add("text-success");
                                                        } else {
                                                            feedback.textContent = "Username is already taken.";
                                                            feedback.classList.remove("text-success");
                                                            feedback.classList.add("text-danger");
                                                        }
                                                    });
                                            } else {
                                                feedback.textContent = "";
                                            }
                                        });
                                    });
                                </script> --}}
                                                       
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password" required>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password1" placeholder="Confirm Your Password" required>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                            <label class="form-check-label text-secondary" for="checkDefault">
                                                Accept Terms & Conditions
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-12 mt-3">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100 rounded">Sign Up</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center text-lg-start">
                                        Already Have an Account? 
                                        <a href="{{route('login')}}" class="link-primary text-decoration-underline"> Sign in</a>
                                    </div>
                                </div>
                                {{-- <div class="app-divider-v justify-content-center">
                                    <p>Or sign up with</p>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-facebook icon-btn b-r-22 m-1"><i
                                                class="ti ti-brand-facebook text-white"></i></button>
                                        <button type="button" class="btn btn-gmail icon-btn b-r-22 m-1"><i
                                                class="ti ti-brand-google text-white"></i></button>
                                        <button type="button" class="btn btn-github icon-btn b-r-22 m-1"><i
                                                class="ti ti-brand-github text-white"></i></button>
                                    </div>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- sign up end -->
    </div>
</div>

</body>
@section('script')
    <!--js-->
    <script src="{{asset('assets/js/coming_soon.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
@endsection
