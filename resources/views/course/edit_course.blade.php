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
                <h4 class="main-title">Edit Course</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-stack f-s-16"></i> Course
                      </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Edit Course - {{ $course->name }}</a>
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
                            <form class="app-form was-validated" method="POST" action="{{ route('course.edit_course.post', ['course_id' => encrypt($course->id)]) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="main-title">
                                    <h6>General Information</h6>
                                </div>
                            
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label">Course Thumbnail | Click or drag the area below to add new image</label>
                                        <div class="file-uploader" id="drop-zone">
                                            <label for="file-input" id="uploaded_image">
                                                @if($course->image)
                                                    <div>
                                                        <img src="{{ asset('storage/uploads/course_picture/' . $course->image) }}" alt="Existing Course Image" class="uploaded-image mb-2" style="max-width: 100%; max-height: 200px; object-fit: contain;" />
                                                        <div class="mt-2 d-flex justify-content-center align-items-center gap-2">
                                                            <p class="mb-0 text-center">Existing image: {{ $course->image }}</p>
                                                            <button type="button" class="btn btn-sm btn-danger b-r-22" id="delete-image-btn" title="Delete image">
                                                                <i class="fa-solid fa-trash"></i>Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <i class="fa-solid fa-cloud-arrow-up me-2 fs-1 mb-3 text-secondary"></i>
                                                    <span class="fs-5">1920x1080 thumbnail size</span>
                                                    <span class="fs-6 text-secondary text-center ms-3 me-3">JPEG, PNG or any image formats, up to 2MB</span>
                                                    <span class="btn btn-lg btn-secondary mt-4">Choose an image</span>
                                                @endif
                                            </label>
                                            <input type="hidden" name="delete_image" id="delete_image" value="0">
                                            <input type="file" id="file-input" name="image" accept="image/*" class="uploadfile d-none"/>
                                        </div>
                                    </div>
                            
                                    <div class="mb-3">
                                        <label class="form-label">Course Title</label>
                                        <input type="text" class="form-control" name="name" placeholder="Course title" required value="{{ $course->name }}">
                                        <div class="invalid-feedback">
                                            Please enter a course title.
                                        </div>
                                    </div>
                            
                                    <div class="mb-3">
                                        <label class="form-label">Course Description</label>
                                        <textarea class="form-control" name="desc" placeholder="Course description">{{ $course->desc }}</textarea>
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
                                            <select class="category-select w-100" name="topic">
                                                @foreach ($topics as $topic)
                                                    @foreach ($course->topics as $course_topic)
                                                        <option value="{{ $topic->id }}" {{ $topic->id == $course_topic->id ? 'selected' : '' }}>
                                                            {{ $topic->desc }}
                                                        </option>
                                                    @endforeach
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
                                    <label class="form-label">Notice</label>
                                    <div class="alert alert-light-border-warning d-flex align-items-center justify-content-between"
                                        role="alert">
                                        <p class="mb-0">
                                            <i class="ti ti-alert-triangle f-s-18 me-2"></i> 
                                            Please follow our <a href="" class="text-decoration-underline fw-semibold text-primary">guidelines</a> before submitting your changes. Fail to follow the <a href="" class="text-decoration-underline fw-semibold text-primary">guidelines</a> may cause your course to be deleted.
                                        </p>
                                    </div>
                                    {{-- <div class="form-check d-flex">
                                        <input class="form-check-input mg-2" type="checkbox" id="flexCheck">
                                        <label class="form-check-label ms-2" for="flexCheck">
                                            Agree to submit this course for review
                                        </label>
                                    </div> --}}
                                </div>
                            
                                <div class="col-12">
                                    <div class="mt-4 d-flex justify-content-end gap-2 flex-column flex-sm-row text-end">
                                        <button type="button" class="btn btn-light-secondary rounded">Cancel</button>
                                        <button type="submit" class="btn btn-primary rounded">Submit Changes</button>
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
@endsection

@section('script')
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

    <!-- add course -->
    <script src="{{asset('assets/js/course/edit_course.js')}}"></script>
@endsection


