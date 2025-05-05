<div class="row">
    @foreach ($courses as $course)
        <div class="col-xxl-4 col-md-6 col-sm-6 mb-4">
            <div class="card overflow-hidden h-100">
                <div class="card-body p-0 d-flex flex-column">
                    <!-- Course Thumbnail -->
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img class="pic-1"
                                    src="{{ asset($course->image ? 'storage/uploads/course_picture/' . $course->image : '../assets/images/ecommerce/1280x720.png') }}"
                                    alt="Course Thumbnail"
                                    style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;" />
                            </a>
                            <ul class="product-links">
                                <li>
                                    <a href="{{ route('course.course_detail', ['course_id' => $course->id]) }}" 
                                        class="bg-success h-30 w-30 d-flex-center b-r-20">
                                        <i class="ti ti-eye f-s-18 text-light"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div class="p-3 flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <a href="{{ route('course.course_detail', ['course_id' => $course->id]) }}"
                                class="h5 mb-0 text-truncate" style="max-width: 70%;" data-bs-placement="top" data-bs-toggle="tooltip"
                                title="{{ $course->name }}">
                                {{ $course->name }}
                            </a>
                            <div class="d-flex align-items-center">
                                <span class="text-warning fw-bold me-1">
                                    {{ number_format($course->average_rating, 1) }}
                                </span>
                                <i class="ti ti-star-filled text-warning"></i>
                            </div>
                        </div>

                        <p class="text-secondary small mb-2"
                        style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">
                            {{ $course->desc ?? 'No description available' }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>
                                <small class="text-muted">
                                    <i class="ti ti-books"></i>
                                    Topic:
                                </small>
                            </div>
                            @foreach ($course->topics as $topic)
                                <span class="badge bg-primary small">#{{ $topic->name }}</span>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>
                                <small class="text-muted">
                                    <i class="ti ti-users me-1"></i>
                                    {{ $course->total_joined ?? 0 }} joined
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="ti ti-calendar me-1"></i>
                                    {{ $course->created_at ? \Carbon\Carbon::parse($course->created_at)->format('M Y') : 'Jan 2023' }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Footer: Tutor Info -->
                    <div class="p-2 border-top bg-primary-light">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $course->tutor_image ? asset('storage/uploads/profile_picture/' . $course->tutor_image) : asset('assets/images/avtar/woman.jpg') }}"
                                class="rounded-circle border"
                                width="32"
                                height="32"
                                style="object-fit: cover;"
                                alt="Tutor Avatar">
                            <div class="text-truncate">
                                <small class="text-muted d-block">Tutor</small>
                                <span class="fw-semibold text-truncate d-block" style="max-width: 150px;">
                                    {{ $course->tutor_username ?? 'Null' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>