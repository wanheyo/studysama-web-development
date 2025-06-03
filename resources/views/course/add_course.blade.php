@extends('layout.master')
@section('title', 'Add Course')
@section('css')
    <!-- filepond css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/filepond/filepond.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/filepond/image-preview.min.css')}}">

    <!-- editor css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">

    <!-- select2 css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/select/select2.min.css')}}" >
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Add Course</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-stack f-s-16"></i> Apps
                      </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Add Course</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Add Product start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="app-product-section">
                            <form class="app-form was-validated" method="POST" action="{{ route('course.add_course.post') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="main-title">
                                    <h6>General Information</h6>
                                </div>
                            
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label">Course Thumbnail</label>
                                        <div class="file-uploader" id="drop-zone">
                                            <label for="file-input" id="uploaded_image">
                                                <i class="fa-solid fa-cloud-arrow-up me-2 fs-1 mb-3 text-secondary"></i>
                                                <span class="fs-5">1920x1080 thumbnail size</span>
                                                <span class="fs-6 text-secondary text-center ms-3 me-3">JPEG, PNG or any image formats, up to 2MB</span>
                                                <span class="btn btn-lg btn-primary mt-4 rounded">Choose an image</span>
                                            </label>
                                            <input type="file" id="file-input" name="image" accept="image/*" class="uploadfile d-none"/>
                                        </div>
                                    </div>
                            
                                    <div class="mb-3">
                                        <label class="form-label">Course Title</label>
                                        <input type="text" class="form-control" name="name" required>
                                        <div class="invalid-feedback">
                                            Please enter a course title.
                                        </div>
                                    </div>
                            
                                    <div class="mb-3">
                                        <label class="form-label">Course Description</label>
                                        <textarea class="form-control" name="desc" placeholder="Course description"></textarea>
                                    </div>
                                </div>
                            
                                <div class="app-divider-v dashed"></div>
                            
                                <div class="main-title">
                                    <h6>Additional Information</h6>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">General Topics</label>
                                            {{-- <select class="category-select w-100" name="topic" required> --}}
                                            <select class="form-select w-100" name="topic" required>
                                                <option value="" selected disabled>Select Topic</option>
                                                @foreach ($topics as $topic)
                                                    <option value="{{ $topic->id }}">{{ $topic->desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            
                                    {{-- <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Availability</label>
                                            <select class="category-select w-100" name="availability">
                                                <option value="1">PUBLIC - Anyone Can View It</option>
                                                <option value="2">PRIVATE - Only You Can View It</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="col-12 mt-3">
                                    <label class="form-label">Your Agreement</label>
                                    <div class="alert alert-light-border-warning d-flex align-items-center justify-content-between"
                                        role="alert">
                                        <p class="mb-0">
                                            <i class="ti ti-alert-triangle f-s-18 me-2"></i> 
                                            Your course will be reviewed by our team first, and it will become unavailable to the public until approved. Please follow our <a href="" class="text-decoration-underline fw-semibold text-primary">guidelines</a> for a smooth process.
                                        </p>
                                        {{-- <i class="ti ti-x" data-bs-dismiss="alert"></i> --}}
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input mg-2" type="checkbox" id="agree_check" required>
                                        <label class="form-check-label ms-2" for="agree_check">
                                            Agree to submit this course for review
                                        </label>
                                        <div class="invalid-feedback">Example invalid feedback text</div>
                                    </div>
                                </div>
                            
                                <div class="col-12">
                                    <div class="mt-4 d-flex justify-content-end gap-2 flex-column flex-sm-row text-end">
                                        <a href="{{ url()->previous() }}" class="btn btn-light-secondary rounded">Cancel</a>
                                        <button type="submit" class="btn btn-primary rounded">Add Course</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Product end -->
    </div>

    <style>
        .swal2-toast {
            width: auto !important;
            max-width: 100% !important;
            padding: 0.625em !important;
        }
    </style>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toast notifications
            @if(session('success'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: "{{ session('success') }}",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: 'auto',
                    });
                }, 100);
            @endif
        
            @if(session('error'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ session('error') }}",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: 'auto',
                    });
                }, 100);
            @endif
        });
    </script>   

    <!--customizer-->
    <div id="customizer"></div>

    <!-- select2 -->
    <script src="{{asset('assets/vendor/select/select2.min.js')}}"></script>

    <!-- filepond -->
    <script src="{{asset('assets/vendor/filepond/file-encode.min.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/validate-size.min.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/validate-type.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/exif-orientation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/image-preview.min.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/filepond.min.js')}}"></script>

    <!-- Trumbowyg js -->
    <script src="{{asset('assets/vendor/trumbowyg/trumbowyg.min.js')}}"></script>

    <!-- sweetalert js-->
    <script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

    <!-- add course -->
    <script src="{{asset('assets/js/course/add_course.js')}}"></script>
@endsection


