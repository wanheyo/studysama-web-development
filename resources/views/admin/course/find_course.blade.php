@extends('layout.master')
@section('title', 'All Course')
@section('css')
    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/datatable2/buttons.dataTables.min.css')}}">
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">All Course</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone ph-book f-s-16"></i> Course
                      </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">All Course </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Course List start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body px-0">
                        <div class="table-responsive app-scroll app-datatable-default product-list-table">
                            <table id="product-Listtable" class="table-sm display align-middle">
                                <thead>
                                <tr>
                                    <th></th> <!-- Expand/Collapse control column -->
                                    <th>Thumbnail</th> <!-- Thumbnail column -->
                                    <th>Title</th>
                                    <th>Topic</th>
                                    <th>Tutor</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($courses as $course)
                                    <tr class="course-row" 
                                        data-desc="{{ e($course->desc ?? 'No description available') }}" 
                                        data-total-join="{{ $course->total_joined ?? 0 }}"
                                        data-rating="{{ number_format($course->average_rating, 1) }}"
                                        data-created-at="{{ \Carbon\Carbon::parse($course->created_at)->format('d/m/Y h:i A') }}"
                                        data-updated-at="{{ \Carbon\Carbon::parse($course->updated_at)->format('d/m/Y h:i A') }}"
                                        data-total-lesson="{{ $course->lessons->count() ?? 0 }}"
                                        data-total-resource="{{ $course->lessons->flatMap->resources->count() }}">
                                        <!-- Expand/Collapse control -->
                                        <td class="dt-control">
                                        </td>
                                        
                                        <!-- Course Image -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="h-100 w-100 d-flex-center b-r-10 overflow-hidden me-2">
                                                    <div class="product-image">
                                                        <a href="#" class="image">
                                                            <img class="pic-1"
                                                                src="{{ asset($course->image ? 'storage/uploads/course_picture/' . $course->image : '../assets/images/ecommerce/1280x720.png') }}"
                                                                alt="Course Thumbnail"
                                                                style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Course Title -->
                                        <td>{{ $course->name }}</td>
                                        
                                        <!-- Topics -->
                                        <td>
                                            @foreach ($course->topics as $topic)
                                                <span class="badge text-light-primary small text-truncate d-inline-block" 
                                                    style="max-width: 70%; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $topic->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        
                                        <!-- Tutor -->
                                        <td>
                                            <a href="{{ route('user.profile', ['user_id' => encrypt($course->tutor_id), 'shared' => 0]) }}" 
                                                style="cursor: pointer; text-decoration: none; color: inherit;" 
                                                class="d-flex align-items-center gap-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="h-35 w-35 d-flex-center b-r-22 overflow-hidden me-2">
                                                        <img src="{{ $course->tutor_image ? asset('storage/uploads/profile_picture/' . $course->tutor_image) : asset('assets/images/avtar/woman.jpg') }}" 
                                                            alt="Tutor Avatar" class="img-fluid">
                                                    </div>
                                                    <div class="d-flex">
                                                        <span class="fw-medium">{{ $course->tutor_username }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        
                                        <!-- Dates -->
                                        <td>{{ \Carbon\Carbon::parse($course->created_at)->format('d/m/Y h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($course->updated_at)->format('d/m/Y h:i A') }}</td>
                                        
                                        <!-- Rating -->
                                        @php
                                            $rating = $course->average_rating;
                                            if ($rating >= 4.0) {
                                                $color = 'green';
                                            } elseif ($rating >= 2.5) {
                                                $color = 'orange';
                                            } else {
                                                $color = 'red';
                                            }
                                        @endphp

                                        <td style="color: {{ $color }};">
                                            {{ number_format($rating, 1) }}
                                        </td>
                                        
                                        <!-- Status -->
                                        <td>
                                            @if ($course->status == 1)
                                                <span class="badge text-bg-success">Active</span>
                                            @elseif ($course->status == 2)
                                                <span class="badge text-bg-warning text-dark">Needs Review</span>
                                            @else
                                                <span class="badge text-bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td>
                                            <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}" 
                                                class="btn btn-light-info icon-btn b-r-4">
                                                <i class="ti ti-eye text-info"></i>
                                            </a>
                                            <button type="button" class="btn btn-light-success icon-btn b-r-4 edit-course-btn" 
                                                    data-course-id="{{ encrypt($course->id) }}">
                                                <i class="ti ti-edit text-success"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Courses Found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Course List end -->
    </div>

    <!-- Modal for Course Details -->
    <div class="modal fade" id="courseDetailModal" tabindex="-1" aria-labelledby="courseDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="courseDetailModalLabel">Course Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="courseStatusForm" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Course Image -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Course Thumbnail</label>
                                <div class="text-center">
                                    <img id="modalCourseImage" src="" alt="Course Thumbnail" 
                                        class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <!-- Course Title -->
                                <div class="mb-3">
                                    <label class="form-label">Course Title</label>
                                    <input type="text" class="form-control" id="modalCourseTitle" disabled>
                                </div>
                                
                                
                                <div class="row">
                                    <!-- Topics -->
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Topics</label>
                                        <div id="modalCourseTopics"></div>
                                    </div>
                                    
                                    <!-- Tutor -->
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Tutor</label>
                                        <a href="{{ route('user.profile', ['user_id' => encrypt($course->tutor_id), 'shared' => 0]) }}" 
                                                style="cursor: pointer; text-decoration: none; color: inherit;" 
                                                class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center">
                                                <img id="modalTutorImage" src="" alt="Tutor Avatar" 
                                                    class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                <span id="modalTutorName" class="fw-medium"></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Course Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="modalCourseDesc" rows="4" disabled></textarea>
                        </div>
                        
                        <div class="row">
                            <!-- Created At -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Created At</label>
                                <input type="text" class="form-control" id="modalCreatedAt" disabled>
                            </div>
                            
                            <!-- Updated At -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Updated At</label>
                                <input type="text" class="form-control" id="modalUpdatedAt" disabled>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Rating -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rating</label>
                                <input type="text" class="form-control" id="modalRating" disabled>
                            </div>
                            
                            <!-- Total Joined -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Joined</label>
                                <input type="text" class="form-control" id="modalTotalJoined" disabled>
                            </div>

                            <!-- Total Lesson -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Lesson</label>
                                <input type="text" class="form-control" id="modalTotalLesson" disabled>
                            </div>

                            <!-- Total Resource -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Resource</label>
                                <input type="text" class="form-control" id="modalTotalResource" disabled>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="modalCourseStatus" name="status" required>
                                <option value="1">Active</option>
                                <option value="2">In Review</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger me-2" id="deleteCourseBtn">Delete Course</button>
                    <button type="button" class="btn btn-success" id="updateCourseBtn">Update Status</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this course? This action cannot be undone.</p>
                    <p class="text-muted"><strong>Course:</strong> <span id="deleteCourseName"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        
    </style>
@endsection

@section('script')

    <script>
        // DataTables Child Rows Implementation

        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#product-Listtable').DataTable({
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,
                "pageLength": 10,           // Show 10 records per page
                "lengthMenu": [10, 25, 50, 100], // Page length options
                // ... your other DataTable options
            });

            // Function to format child row content
            function format(rowData) {
                return `
                    <div class="child-row-content p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-2">Course Description</h6>
                                <p class="text-muted">${rowData.desc || 'No description available'}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">Additional Details</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Total Joined:</strong> ${rowData.totalJoin || '0'}</li>
                                    <li><strong>Average Rating:</strong> ${rowData.rating || 'N/A'}</li>
                                    <li><strong>Created At:</strong> ${rowData.createdAt || 'N/A'}</li>
                                    <li><strong>Updated At:</strong> ${rowData.updatedAt || 'N/A'}</li>
                                    <li><strong>Total Lesson:</strong> ${rowData.totalLesson || '0'}</li>
                                    <li><strong>Total Resource:</strong> ${rowData.totalResource || '0'}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Add event listener for opening and closing details
            $('#product-Listtable tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).find('i').removeClass('ti-minus').addClass('ti-plus');
                } else {
                    const data = {
                        desc: tr.data('desc'),
                        totalJoin: tr.data('total-join'),
                        rating: tr.data('rating'),
                        createdAt: tr.data('created-at'),
                        updatedAt: tr.data('updated-at'),
                        totalLesson: tr.data('total-lesson'),
                        totalResource: tr.data('total-resource'),
                    };
                    row.child(format(data)).show();
                    tr.addClass('shown');
                    $(this).find('i').removeClass('ti-plus').addClass('ti-minus');
                }
            });
        });

        // Alternative: Click anywhere on row to expand
        $('#product-Listtable tbody').on('click', 'tr', function() {
            var row = table.row(this);
            
            if (row.child.isShown()) {
                row.child.hide();
                $(this).removeClass('shown');
            } else {
                row.child(format(row.data())).show();
                $(this).addClass('shown');
            }
        });

        // CSS for styling
        const childRowStyles = `
            <style>
            /* Child row styling */
            .child-row-content {
                background-color: #f8f9fa;
                border-left: 3px solid #007bff;
                margin: 10px 0;
            }

            /* Row state styling */
            tr.shown {
                background-color: #f8f9fa;
            }

            /* Details control button */
            td.dt-control {
                background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTggM1Y4SDEzIiBzdHJva2U9IiM2NjY2NjYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=') no-repeat center center;
                cursor: pointer;
                width: 30px;
                text-align: center;
            }

            tr.shown td.dt-control {
                background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTMgOEgxMyIgc3Ryb2tlPSIjNjY2NjY2IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K') no-repeat center center;
            }
            </style>
        `;

        document.addEventListener('DOMContentLoaded', function() {
            let currentCourseId = null;
            
            // Edit button click handler
            document.querySelectorAll('.edit-course-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    currentCourseId = this.dataset.courseId;
                    
                    // Populate modal with course data
                    document.getElementById('modalCourseTitle').value = row.querySelector('td:nth-child(3)').textContent.trim();
                    document.getElementById('modalCourseDesc').value = row.dataset.desc || 'No description available';
                    document.getElementById('modalCreatedAt').value = row.dataset.createdAt;
                    document.getElementById('modalUpdatedAt').value = row.dataset.updatedAt;
                    document.getElementById('modalRating').value = row.dataset.rating;
                    document.getElementById('modalTotalJoined').value = row.dataset.totalJoin;
                    document.getElementById('modalTotalLesson').value = row.dataset.totalLesson;
                    document.getElementById('modalTotalResource').value = row.dataset.totalResource;
                    
                    // Set course image
                    const courseImg = row.querySelector('img').src;
                    document.getElementById('modalCourseImage').src = courseImg;
                    
                    // Set tutor info
                    const tutorImg = row.querySelector('td:nth-child(5) img').src;
                    const tutorName = row.querySelector('td:nth-child(5) span').textContent.trim();
                    document.getElementById('modalTutorImage').src = tutorImg;
                    document.getElementById('modalTutorName').textContent = tutorName;
                    
                    // Set topics
                    const topicElements = row.querySelectorAll('td:nth-child(4) .badge');
                    const topicsContainer = document.getElementById('modalCourseTopics');
                    topicsContainer.innerHTML = '';
                    topicElements.forEach(topic => {
                        const badge = document.createElement('span');
                        badge.className = 'badge text-light-primary me-1 mb-1';
                        badge.textContent = topic.textContent.trim();
                        topicsContainer.appendChild(badge);
                    });
                    
                    // Set current status
                    const statusBadge = row.querySelector('td:nth-child(9) .badge');
                    let currentStatus = '1'; // default to active
                    if (statusBadge.textContent.includes('Active')) {
                        currentStatus = '1';
                    } else if (statusBadge.textContent.includes('Review')) {
                        currentStatus = '2';
                    }
                    document.getElementById('modalCourseStatus').value = currentStatus;
                    
                    // Show modal
                    new bootstrap.Modal(document.getElementById('courseDetailModal')).show();
                });
            });
            
            // Function to update course status via AJAX
            function updateCourseStatus(courseId, status, successMessage) {
                // Show loading state
                const updateBtn = document.getElementById('updateCourseBtn');
                const deleteBtn = document.getElementById('deleteCourseBtn');
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                
                // Disable buttons and show loading
                if (status === '0') {
                    confirmDeleteBtn.disabled = true;
                    confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';
                } else {
                    updateBtn.disabled = true;
                    updateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
                }
                
                fetch(`/course/admin/a_edit_course/${courseId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Success handling
                    console.log('Success:', data);
                    
                    // Hide modals
                    const courseModal = bootstrap.Modal.getInstance(document.getElementById('courseDetailModal'));
                    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                    
                    if (courseModal) courseModal.hide();
                    if (deleteModal) deleteModal.hide();
                    
                    // Show success message
                    showAlert('success', successMessage);
                    
                    // Update the table row status if not deleted
                    if (status !== '0') {
                        updateTableRowStatus(courseId, status);
                    } else {
                        // Remove the row from table if deleted
                        removeTableRow(courseId);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('danger', 'An error occurred while updating the course. Please try again.');
                })
                .finally(() => {
                    // Reset button states
                    if (status === '0') {
                        confirmDeleteBtn.disabled = false;
                        confirmDeleteBtn.innerHTML = 'Yes, Delete';
                    } else {
                        updateBtn.disabled = false;
                        updateBtn.innerHTML = 'Update Status';
                    }
                });
            }
            
            // Function to update table row status
            function updateTableRowStatus(courseId, status) {
                const editBtn = document.querySelector(`[data-course-id="${courseId}"]`);
                if (editBtn) {
                    const row = editBtn.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(9)');
                    const statusBadge = statusCell.querySelector('.badge');
                    
                    // Update status badge
                    statusBadge.className = 'badge';
                    switch(status) {
                        case '1':
                            statusBadge.classList.add('text-bg-success');
                            statusBadge.textContent = 'Active';
                            break;
                        case '2':
                            statusBadge.classList.add('text-bg-warning');
                            statusBadge.classList.add('text-dark');
                            statusBadge.textContent = 'Under Review';
                            break;
                        default:
                            statusBadge.classList.add('text-bg-secondary');
                            statusBadge.textContent = 'Inactive';
                    }
                }
            }
            
            // Function to remove table row
            function removeTableRow(courseId) {
                const editBtn = document.querySelector(`[data-course-id="${courseId}"]`);
                if (editBtn) {
                    const row = editBtn.closest('tr');
                    row.style.transition = 'opacity 0.3s ease';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                    }, 300);
                }
            }
            
            // Function to show alert messages
            function showAlert(type, message) {
                // Remove existing alerts
                const existingAlerts = document.querySelectorAll('.alert-custom');
                existingAlerts.forEach(alert => alert.remove());
                
                // Create new alert
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-custom`;
                alertDiv.style.position = 'fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.style.minWidth = '300px';
                
                alertDiv.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.body.appendChild(alertDiv);
                
                // Auto remove after 3 seconds
                setTimeout(() => {
                    if (alertDiv && alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 3000);
            }
            
            // Update status button handler
            document.getElementById('updateCourseBtn').addEventListener('click', function() {
                const selectedStatus = document.getElementById('modalCourseStatus').value;
                let statusText = '';
                
                switch(selectedStatus) {
                    case '1':
                        statusText = 'activated';
                        break;
                    case '2':
                        statusText = 'marked for review';
                        break;
                    default:
                        statusText = 'updated';
                }
                
                updateCourseStatus(currentCourseId, selectedStatus, `Course has been ${statusText} successfully.`);
            });
            
            // Delete button handler
            document.getElementById('deleteCourseBtn').addEventListener('click', function() {
                const courseName = document.getElementById('modalCourseTitle').value;
                document.getElementById('deleteCourseName').textContent = courseName;
                
                // Hide course detail modal and show delete confirmation
                bootstrap.Modal.getInstance(document.getElementById('courseDetailModal')).hide();
                new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
            });
            
            // Confirm delete handler
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                updateCourseStatus(currentCourseId, '0', 'Course has been deleted successfully.');
            });
        });
    </script>

    <!--customizer-->
    <div id="customizer"></div>

    <!--datatable -->
    <script src="{{asset('assets/vendor/datatable/jquery.dataTables.min.js')}}"></script>

    <!-- js-->
    <script src="{{asset('assets/js/product_list.js')}}"></script>
@endsection

