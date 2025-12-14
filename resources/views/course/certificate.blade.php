@extends('layout.master')
@section('title', 'Certificate')
@section('css')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .certificate-container {
            margin: 0;
            padding: 0;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
        }
        body {
            background: white !important;
        }
    }
    
    .certificate-container {
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .certificate-card {
        /* background: white; */
        border: 8px solid #2c3e50;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }
    
    .certificate-card::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        bottom: 20px;
        border: 3px solid #f39c12;
        border-radius: 10px;
        pointer-events: none;
    }
    
    .certificate-header {
        text-align: center;
        padding: 3rem 2rem 1rem;
        background: linear-gradient(45deg, #f39c12, #e67e22);
        color: white;
        /* margin: 0 -15px; */
    }
    
    .certificate-body {
        padding: 3rem 4rem;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    
    .certificate-title {
        font-size: 3rem;
        font-weight: bold;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    
    .certificate-subtitle {
        font-size: 1.2rem;
        color: #7f8c8d;
        margin-bottom: 2rem;
    }
    
    .recipient-name {
        font-size: 2.5rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 2rem 0;
        text-decoration: underline;
        text-decoration-color: #f39c12;
        text-underline-offset: 10px;
    }
    
    .course-name {
        font-size: 1.8rem;
        font-weight: 600;
        color: #34495e;
        margin: 1.5rem 0;
        font-style: italic;
    }
    
    .certificate-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #2c3e50;
        margin: 2rem 0;
    }
    
    .certificate-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        /* margin-top: 4rem;
        padding-top: 2rem; */
        /* border-top: 2px solid #ecf0f1; */
    }
    
    .signature-section {
        text-align: center;
        flex: 1;
    }
    
    .signature-line {
        border-bottom: 2px solid #2c3e50;
        width: 200px;
        margin: 2rem auto 0.5rem;
    }
    
    .signature-label {
        font-size: 0.9rem;
        color: #7f8c8d;
        font-weight: 500;
    }
    
    .certificate-date {
        font-size: 1rem;
        color: #7f8c8d;
        margin-top: 1rem;
    }
    
    .certificate-id {
        font-size: 0.9rem;
        color: #95a5a6;
        margin-top: 0.5rem;
    }
    
    .decorative-border {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            radial-gradient(circle at 20px 20px, #f39c12 2px, transparent 2px),
            radial-gradient(circle at 20px 20px, #f39c12 2px, transparent 2px);
        background-size: 40px 40px;
        background-position: 0 0, 20px 20px;
        opacity: 0.1;
        pointer-events: none;
    }
    
    .logo-section {
        margin-bottom: 1rem;
    }
    
    .logo-section img {
        max-width: 200px;
        height: auto;
    }
    
    .seal {
        position: absolute;
        bottom: 55px;
        right: 55px;
        width: 100px;
        height: 100px;
        border: 4px solid #f39c12;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        font-weight: bold;
        color: #f39c12;
        font-size: 0.8rem;
        text-align: center;
        line-height: 1.2;
    }
</style>
@endsection

@section('main-content')
    <div class="container-fluid no-print">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">Certificate - {{ $course->name }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-book f-s-16"></i> Course
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course.find_course') }}" class="f-s-14 f-w-500">Find Courses</a>
                    </li>
                    <li>
                        <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}" class="f-s-14 f-w-500">{{ $course->name }}</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Certificate</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @if($courseProgress < 100)
        <div class="alert alert-label alert-label-warning justify-content-between mx-4 no-print" role="alert">
            <p class="mb-0">
                <i class="ti ti-certificate label-icon label-icon-warning text-black"></i>
                This certificate is <span class="badge bg-warning" data-bs-placement="top" data-bs-toggle="tooltip" title="This certificate is still valid but no longer reflects the latest course content">Outdated</span>
                but still valid.
                This is because new resources or updates have been added to this course.
                {{-- , which caused the course progression to reach {{ $courseProgress }}%. --}}
            </p>
            {{-- <a href="{{ route('course.certificate', ['course_id' => encrypt($course->id)]) }}" class="btn btn-sm btn-success rounded">
                Claim Updated Certificate
            </a> --}}
        </div>
    @endif


    <!-- Certificate start -->
    <div class="certificate-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card certificate-card">
                        <div class="decorative-border"></div>
                        
                        <!-- Certificate Header -->
                        <div class="certificate-header">
                            <div class="logo-section">
                                <img src="{{ asset('../assets/images/logo/SS_Header_1.png') }}" alt="Logo" class="img-fluid">
                            </div>
                            {{-- <h4 class="mb-0 text-white">Learning Management System</h4>
                            <p class="mb-0 text-white">Excellence in Education</p> --}}
                        </div>

                        <!-- Certificate Body -->
                        <div class="certificate-body">
                            <h1 class="certificate-title">Certificate</h1>
                            <p class="certificate-subtitle">of Completion</p>
                            
                            <p class="certificate-text">
                                This is to certify that
                            </p>
                            
                            <h2 class="recipient-name">{{ $userCourse->user->name }}</h2>
                            
                            <p class="certificate-text">
                                has successfully completed the course
                            </p>
                            
                            <h3 class="course-name">"{{ $course->name }}"</h3>
                            
                            <p class="certificate-text">
                                with dedication and has demonstrated proficiency in the subject matter.
                                This achievement reflects their commitment to continuous learning and professional development.
                            </p>

                            <hr class="hr my-4"/>

                            <!-- Certificate Footer -->
                            <div class="certificate-footer">
                                {{-- <div class="signature-section">
                                    <div class="signature-line"></div>
                                    <p class="signature-label">Director</p>
                                </div> --}}
                                
                                <div class="text-center">
                                    <p class="certificate-date">
                                        <strong>Date of Completion:</strong><br>
                                        {{ $certificate->created_at->format('F d, Y') }}
                                    </p>
                                    <p class="certificate-id">
                                        Certificate ID: #{{ str_pad($certificate->id, 6, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                                
                                {{-- <div class="signature-section">
                                    <div class="signature-line"></div>
                                    <p class="signature-label">Course Instructor</p>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Seal -->
                        <div class="seal">
                            <div>
                                OFFICIAL<br>
                                SEAL <i class="ph-duotone ph-seal-check f-s-16"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center mt-4 no-print">
                        <button type="button" class="btn btn-primary m-2 rounded" onclick="window.print()">
                            <i class="ti ti-printer"></i> Print Certificate
                        </button>
                        <button type="button" class="btn btn-success m-2 rounded" onclick="downloadCertificate()">
                            <i class="ti ti-download"></i> Download PDF
                        </button>
                        <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}" class="btn btn-secondary m-2 rounded">
                            <i class="ti ti-arrow-left"></i> Back to Course
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Certificate end -->
@endsection

@section('script')
<script>
    function downloadCertificate() {
        // You can implement PDF generation here
        // For now, it will trigger print dialog
        window.print();
    }
    
    // Auto-adjust font size for long names
    document.addEventListener('DOMContentLoaded', function() {
        const nameElement = document.querySelector('.recipient-name');
        const nameLength = nameElement.textContent.length;
        
        if (nameLength > 25) {
            nameElement.style.fontSize = '2rem';
        } else if (nameLength > 20) {
            nameElement.style.fontSize = '2.2rem';
        }
        
        const courseElement = document.querySelector('.course-name');
        const courseLength = courseElement.textContent.length;
        
        if (courseLength > 50) {
            courseElement.style.fontSize = '1.4rem';
        } else if (courseLength > 35) {
            courseElement.style.fontSize = '1.6rem';
        }
    });
</script>

<!--customizer-->
<div id="customizer"></div>
@endsection