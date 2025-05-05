@section('title', 'Forbidden')
@include('layout.head')

@include('layout.css')

<div class="error-container p-0">
    <div class="container">
        <div>
            <div>
                <img src="{{asset('../assets/images/background/error-403.png')}}" class="img-fluid" alt="">
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <p class="text-center text-secondary f-w-500">403 Forbidden response status code indicates that the server
                            understands the request<br> but refuses to authorize it.</p>
                    </div>
                </div>
            </div>
            <a role="button" href="{{route('index')}}" class="btn btn-lg btn-success"><i class="ti ti-home"></i> Back To Home</a>
        </div>
    </div>
</div>
@section('script')
    <!--jquery-->
    <script src="{{asset('assets/js/jquery-3.6.3.min.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
@endsection
