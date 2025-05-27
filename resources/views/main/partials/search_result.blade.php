@if($courses->isEmpty() && $users->isEmpty())
    <li class="search-list-item text-center py-3">
        <p class="mb-0 text-secondary">No results found.</p>
    </li>
@else
    @foreach($courses as $course)
        <li class="search-list-item">
            <div class="h-35 w-35 d-flex-center b-r-15 overflow-hidden bg-light-primary search-list-avtar">
                <i class="ph ph-book"></i>
            </div>
            <div class="search-list-content">
                <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}">
                    <h6 class="mb-0 text-dark">{{ $course->name }}</h6>
                </a>
                <p class="f-s-13 mb-0 text-secondary">Course</p>
            </div>
        </li>
    @endforeach

    @foreach($users as $user)
        <li class="search-list-item">
            <div class="h-35 w-35 d-flex-center b-r-15 overflow-hidden bg-light-warning search-list-avtar">
                <i class="ph ph-user"></i>
            </div>
            <div class="search-list-content">
                <a href="{{ route('user.profile', ['user_id' => encrypt($user->id), 'shared' => 0]) }}">
                    <h6 class="mb-0 text-dark">{{ $user->username }}</h6>
                </a>
                <p class="f-s-13 mb-0 text-secondary">User</p>
            </div>
        </li>
    @endforeach
@endif
