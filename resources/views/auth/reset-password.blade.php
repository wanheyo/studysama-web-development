@section('title', 'Reset Password')
{{-- Assuming layout.head and layout.css exist --}}
@include('layout.head')
@include('layout.css')

<body>
<div class="app-wrapper d-block">
    <main class="w-100 p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="login-form-container">
                        <div class="mb-4">
                            {{-- Adjust logo path as needed --}}
                            <a class="logo d-inline-block" href="#">
                                <img src="{{asset('assets/images/logo/SS_Header_1.png')}}" width="250" alt="#">
                            </a>
                        </div>
                        <div class="form_container">
                            
                            {{-- FORM START --}}
                            <form class="app-form" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                
                                {{-- 1. Hidden Token (Required) --}}
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-3 text-center">
                                    <h3>Reset Password</h3>
                                    <p class="f-s-12 text-secondary">Enter your email and new password.</p>
                                </div>

                                {{-- Display Errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- 2. Email Address (Required for verification) --}}
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    {{-- Use request()->email to autofill from URL if available, or leave blank --}}
                                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email" value="{{ request()->get('email') }}">
                                </div>

                                {{-- 3. New Password --}}
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter New Password">
                                </div>

                                {{-- 4. Confirm Password (name must be password_confirmation) --}}
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password">
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                </div>
                            </form>
                            {{-- FORM END --}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>

@section('script')
    <script src="{{asset('assets/js/jquery-3.6.3.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
@endsection