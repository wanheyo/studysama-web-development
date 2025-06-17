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
                <h4 class="main-title">All User</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-stack f-s-16"></i> User
                      </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">All User</a>
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
                        <div class="table-responsive app-scroll app-datatable-default user-list-table">
                            <table id="user-Listtable" class="table-sm display align-middle">
                                <thead>
                                <tr>
                                    <th></th> <!-- Expand/Collapse control column -->
                                    <th>Picture</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($users as $user)
                                    <tr class="user-row"
                                        data-role="{{ $user->role }}"
                                        data-bio="{{ e($user->bio ?? 'No bio included') }}"
                                        data-phone="{{ $user->phone_num ?? 'N/A' }}"
                                        data-total-follower="{{ $user->total_follower ?? 0 }}"
                                        data-total-following="{{ $user->following_count ?? 0 }}"
                                        data-level="{{ $user->userPoints->level ?? 0 }}"
                                        data-xp="{{ $user->userPoints->xp ?? 0 }}"
                                        data-point="{{ $user->userPoints->total_points ??0 }}"
                                        data-created-at="{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y h:i A') }}"
                                        data-updated-at="{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y h:i A') }}">
                                        <!-- Expand/Collapse control -->
                                        <td class="dt-control">
                                        </td>
                                        
                                        <!-- Picture -->
                                        <td>
                                            <a href="{{ route('user.profile', ['user_id' => encrypt($user->id), 'shared' => 0]) }}" 
                                                style="cursor: pointer; text-decoration: none; color: inherit;" 
                                                class="d-flex align-items-center gap-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="h-35 w-35 d-flex-center b-r-22 overflow-hidden me-2">
                                                        <img src="{{ $user->image ? asset('storage/uploads/profile_picture/' . $user->image) : asset('assets/images/avtar/woman.jpg') }}" 
                                                            alt="Tutor Avatar" class="img-fluid">
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        
                                        <!-- Username -->
                                        <td>{{ $user->username }}</td>
                                        
                                        <!-- Email -->
                                        <td>
                                            {{ $user->email }}
                                            {{-- @foreach ($course->topics as $topic)
                                                <span class="badge text-light-primary small text-truncate d-inline-block" 
                                                    style="max-width: 70%; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $topic->name }}
                                                </span>
                                            @endforeach --}}
                                        </td>
                                        
                                        <!-- Tutor -->
                                        <td>
                                            {{ $user->name }}
                                            {{-- <a href="{{ route('user.profile', ['user_id' => encrypt($course->tutor_id), 'shared' => 0]) }}" 
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
                                            </a> --}}
                                        </td>
                                        
                                        <!-- Dates -->
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y h:i A') }}</td>
                                        
                                        <!-- Rating -->
                                        @php
                                            $role = $user->role;
                                            if ($role == "Superadmin" || $role == "Admin") {
                                                $color = 'orange';
                                            } else {
                                                $color = 'green';
                                            }
                                        @endphp

                                        <td style="color: {{ $color }};">
                                            {{ $role }}
                                        </td>
                                        
                                        <!-- Status -->
                                        <td>
                                            @if ($user->status == 1)
                                                <span class="badge text-bg-success">Active</span>
                                            @elseif ($user->status == 2)
                                                <span class="badge text-bg-warning text-dark">Needs Review</span>
                                            @else
                                                <span class="badge text-bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td>
                                            <a href="{{ route('user.profile', ['user_id' => encrypt($user->id), 'shared' => 0]) }}" 
                                                class="btn btn-light-info icon-btn b-r-4">
                                                <i class="ti ti-eye text-info"></i>
                                            </a>
                                            <button type="button" class="btn btn-light-success icon-btn b-r-4 edit-user-btn" 
                                                    data-course-id="{{ encrypt($user->id) }}">
                                                <i class="ti ti-edit text-success"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No User Found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- User List end -->
    </div>

    <!-- Modal for User Details -->
    <div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="userDetailModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userStatusForm" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <!-- Profile Image -->
                            <div class="col-md-4 text-center">
                                <img id="modalUserImage" src="" alt="User Avatar" class="img-fluid rounded-circle" style="max-height: 150px; object-fit: cover;">
                            </div>

                            <!-- Basic Info -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" id="modalUserUsername" disabled>
                                </div>

                                <div class="row">
                                    <!-- Topics -->
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" id="modalUserRole" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="modalUserName" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" id="modalUserEmail" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="modalUserPhone" disabled>
                            </div>
                        </div>

                        <!-- Bio & Phone -->
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Bio</label>
                                <textarea class="form-control" id="modalUserBio" rows="3" disabled></textarea>
                            </div>
                        </div>

                        <!-- Points & Stats -->
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">XP</label>
                                <input type="text" class="form-control" id="modalUserXp" disabled>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Level</label>
                                <input type="text" class="form-control" id="modalUserLevel" disabled>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Total Points</label>
                                <input type="text" class="form-control" id="modalUserPoints" disabled>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Followers / Following</label>
                                <input type="text" class="form-control" id="modalUserFollowCount" disabled>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Created At</label>
                                <input type="text" class="form-control" id="modalUserCreatedAt" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Updated At</label>
                                <input type="text" class="form-control" id="modalUserUpdatedAt" disabled>
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
                    <button type="button" class="btn btn-danger me-2" id="deleteCourseBtn">Delete User</button>
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
            var table = $('#user-Listtable').DataTable({
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,
                // ... your other DataTable options
            });

            // Function to format child row content
            function format(rowData) {
                return `
                    <div class="child-row-content p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-2">User Bio</h6>
                                <p class="text-muted">${rowData.bio || 'No bio included'}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">Additional Details</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Phone:</strong> ${rowData.phone || 'N/A'}</li>
                                    <li><strong>Total Follower:</strong> ${rowData.totalFollower || '0'}</li>
                                    <li><strong>Total Following:</strong> ${rowData.totalFollowing || '0'}</li>
                                    <li><strong>Level:</strong> ${rowData.level || '1'}</li>
                                    <li><strong>XP:</strong> ${rowData.xp || '0'}</li>
                                    <li><strong>point:</strong> ${rowData.point || '0'}</li>
                                    <li><strong>Created At:</strong> ${rowData.createdAt || 'N/A'}</li>
                                    <li><strong>Updated At:</strong> ${rowData.updatedAt || 'N/A'}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Add event listener for opening and closing details
            $('#user-Listtable tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).find('i').removeClass('ti-minus').addClass('ti-plus');
                } else {
                    const data = {
                        bio: tr.data('bio'),
                        phone: tr.data('phone'),
                        totalFollower: tr.data('total-follower'),
                        totalFollowing: tr.data('total-following'),
                        level: tr.data('level'),
                        xp: tr.data('xp'),
                        point: tr.data('point'),
                        createdAt: tr.data('created-at'),
                        updatedAt: tr.data('updated-at'),
                    };
                    row.child(format(data)).show();
                    tr.addClass('shown');
                    $(this).find('i').removeClass('ti-plus').addClass('ti-minus');
                }
            });
        });

        // Alternative: Click anywhere on row to expand
        // $('#user-Listtable tbody').on('click', 'tr', function() {
        //     var row = table.row(this);
            
        //     if (row.child.isShown()) {
        //         row.child.hide();
        //         $(this).removeClass('shown');
        //     } else {
        //         row.child(format(row.data())).show();
        //         $(this).addClass('shown');
        //     }
        // });

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
            let currentUserId = null;
            
            // Edit button click handler
            document.querySelectorAll('.edit-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    currentUserId = this.dataset.userId;
                    
                    // Set profile image
                    const userImg = row.querySelector('img').src;
                    document.getElementById('modalUserImage').src = userImg;

                    // Basic Info
                    document.getElementById('modalUserUsername').value = row.querySelector('td:nth-child(3)').textContent.trim();
                    document.getElementById('modalUserEmail').value = row.querySelector('td:nth-child(4)').textContent.trim();
                    document.getElementById('modalUserName').value = row.querySelector('td:nth-child(5)').textContent.trim();
                    document.getElementById('modalUserRole').value = row.querySelector('td:nth-child(8)').textContent.trim();
                    // document.getElementById('modalUserRole').textContent = row.dataset.role;

                    // Bio & Phone
                    document.getElementById('modalUserBio').value = row.dataset.bio;
                    document.getElementById('modalUserPhone').value = row.dataset.phone;

                    // XP, Level, Points
                    document.getElementById('modalUserXp').value = row.dataset.xp;
                    document.getElementById('modalUserLevel').value = row.dataset.level;
                    document.getElementById('modalUserPoints').value = row.dataset.point;

                    // Follower / Following
                    document.getElementById('modalUserFollowCount').value = `${row.dataset.totalFollower} / ${row.dataset.totalFollowing}`;

                    // Timestamps
                    document.getElementById('modalUserCreatedAt').value = row.dataset.createdAt;
                    document.getElementById('modalUserUpdatedAt').value = row.dataset.updatedAt;

                    
                    // Show modal
                    new bootstrap.Modal(document.getElementById('userDetailModal')).show();
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

