<!-- Menu Navigation starts -->
<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="{{ route('main.homepage') }}">
            <img src="{{asset('../assets/images/logo/SS_Header_1.png')}}" alt="#">
        </a>

        <span class="bg-light-primary toggle-semi-nav">
          <i class="ti ti-chevrons-right f-s-20"></i>
        </span>
    </div>
    <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-2">
            @auth
            @if (auth()->user()->isSuperadmin() || auth()->user()->isAdmin())
                <li class="menu-title">
                    <span>Admin Dashboard</span>
                </li>
                <li>
                    <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#admin_dashboard">
                        <i class="iconoir-home-alt"></i>
                        dashboard
                        {{-- <span class="badge text-primary-dark bg-primary-300  badge-notification ms-2">4</span> --}}
                    </a>
                    <ul class="collapse" id="admin_dashboard">
                        <li><a href="{{route('main.admin.homepage')}}">Homepage</a></li>
                        {{-- <li><a href="{{route('ecommerce_dashboard')}}">Notification</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#admin_course">
                        <i class="iconoir-book-stack"></i>
                        course
                        {{-- <span class="badge text-primary-dark bg-primary-300  badge-notification ms-2">4</span> --}}
                    </a>
                    <ul class="collapse" id="admin_course">
                        <li><a href="{{route('course.admin.find_course')}}">All Courses</a></li>
                        <li><a href="{{route('course.admin.course_statistics')}}">Statistics</a></li>
                        {{-- <li><a href="{{route('course.add_course')}}">Add New Course</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#admin_user">
                        <i class="iconoir-group"></i>
                        User
                        {{-- <span class="badge text-primary-dark bg-primary-300  badge-notification ms-2">4</span> --}}
                    </a>
                    <ul class="collapse" id="admin_user">
                        <li><a href="{{route('user.admin.find_user')}}">All User</a></li>
                        <li><a href="{{route('user.admin.user_statistics')}}">Statistics</a></li>
                        {{-- <li><a href="{{route('course.add_course')}}">Add New Course</a></li> --}}
                    </ul>
                </li>
            @endif
            
            
            <li class="menu-title">
                <span>Dashboard</span>
            </li>
            <li>
                <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#dashboard">
                    <i class="iconoir-home-alt"></i>
                    dashboard
                    {{-- <span class="badge text-primary-dark bg-primary-300  badge-notification ms-2">4</span> --}}
                </a>
                <ul class="collapse" id="dashboard">
                    <li><a href="{{route('main.homepage')}}">Homepage</a></li>
                    {{-- <li><a href="{{route('ecommerce_dashboard')}}">Notification</a></li> --}}
                </ul>
            </li>
            <li>
                <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#course">
                    <i class="iconoir-book-stack"></i>
                    course
                    {{-- <span class="badge text-primary-dark bg-primary-300  badge-notification ms-2">4</span> --}}
                </a>
                <ul class="collapse" id="course">
                    <li><a href="{{route('course.my_course')}}">My Courses</a></li>
                    <li><a href="{{route('course.find_course')}}">Find Courses</a></li>
                    <li><a href="{{route('course.add_course')}}">Add New Course</a></li>
                </ul>
            </li>
            <li>
                <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#ai">
                    <i class="iconoir-flare"></i>
                    StudySama AI
                    {{-- <span class="badge text-primary-dark bg-primary-300  badge-notification ms-2">4</span> --}}
                </a>
                <ul class="collapse" id="ai">
                    <li><a href="{{route('ai.mcq')}}">MCQ Quiz</a></li>
                    <li><a href="{{route('ai.flashcard')}}">Flashcard</a></li>
                    <li><a href="{{route('ai.word_search_puzzle')}}">Word Search Puzzle</a></li>
                    <li><a href="{{route('ai.leaderboard')}}">Leaderboard</a></li>
                </ul>
            </li>
            <li>
                <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#profile">
                    <i class="iconoir-profile-circle"></i>
                    profile
                    {{-- <span class="badge text-primary-dark bg-primary-300  badge-notification ms-2">4</span> --}}
                </a>
                <ul class="collapse" id="profile">
                    <li><a href="{{route('user.my_profile')}}">My Profile</a></li>
                    <li><a href="{{route('user.edit_profile')}}">Edit My Profile</a></li>
                </ul>
            </li>
            {{-- <li>
                <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#apps">
                    <i class="iconoir-apple-shortcuts"></i>
                    Apps
                </a>
                <ul class="collapse" id="apps">
                    <li><a href="{{route('calendar')}}">Calender</a></li>
                    <li class="another-level">
                        <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#Profile-page">
                            Profile
                        </a>
                        <ul class="collapse" id="Profile-page">
                            <li><a href="{{route('profile')}}">Profile</a></li>
                            <li><a href="{{route('setting')}}">Setting</a></li>
                        </ul>
                    </li>
                    <li class="another-level">
                        <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#projects-page">
                            Projects Page
                        </a>
                        <ul class="collapse" id="projects-page">
                            <li><a href="{{route('project_app')}}">projects</a></li>
                            <li><a href="{{route('project_details')}}">projects Details</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('to_do')}}">To-Do</a></li>
                    <li><a href="{{route('team')}}">Team</a></li>
                    <li><a href="">API</a></li>
                    <li class="another-level">
                        <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#ticket-page">
                            Ticket
                        </a>
                        <ul class="collapse" id="ticket-page">
                            <li><a href="{{route('ticket')}}">Ticket</a></li>
                            <li><a href="{{route('ticket_details')}}">Ticket Details</a></li>
                        </ul>
                    </li>
                    <li class="another-level">
                        <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#email-page">
                            Email Page
                        </a>
                        <ul class="collapse" id="email-page">
                            <li><a href="{{route('email')}}"> Email</a></li>
                            <li><a href="{{route('read_email')}}">Read Email</a></li>
                        </ul>
                    </li>
                    <li class="another-level">
                        <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#e-shop">
                            E-shop
                        </a>
                        <ul class="collapse" id="e-shop">
                            <li><a href="{{route('cart')}}">Cart</a></li>
                            <li><a href="{{route('product')}}">Product</a></li>
                            <li><a href="{{route('add_product')}}">Add Product</a></li>
                            <li><a href="{{route('product_details')}}">Product-Details</a></li>
                            <li><a href="{{route('product_list')}}">Product list</a></li>
                            <li><a href="{{route('orders')}}">Orders</a></li>
                            <li><a href="{{route('order_details')}}">Order Details</a></li>
                            <li><a href="{{route('order_list')}}">Orders List</a></li>
                            <li><a href="{{route('checkout')}}">Check out</a></li>
                            <li><a href="{{route('wishlist')}}">Wishlist</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('invoice')}}">Invoice</a></li>
                    <li><a href="{{route('chat')}}">Chat</a></li>
                    <li><a href="{{route('file_manager')}}">File manager</a></li>
                    <li><a href="{{route('bookmark')}}">Bookmark</a></li>
                    <li><a href="{{route('kanban_board')}}">Kanban board</a></li>
                    <li><a href="{{route('timeline')}}">Timeline</a></li>
                    <li><a href="{{route('faq')}}">FAQS</a></li>
                    <li><a href="{{route('pricing')}}">Pricing</a></li>
                    <li><a href="{{route('gallery')}}">Gallery</a></li>
                    <li class="another-level">
                        <a aria-expanded="false" class="" data-bs-toggle="collapse" href="#blog-page">
                            Blog Page
                        </a>
                        <ul class="collapse" id="blog-page">
                            <li><a href="{{route('blog')}}">Blog</a></li>
                            <li><a href="{{route('blog_details')}}">Blog Details</a></li>
                            <li><a href="{{route('add_blog')}}">Add Blog</a></li>

                        </ul>
                    </li>
                </ul>
            </li> --}}
            
            @endauth

            
            @guest
                <li class="menu-title">
                    <span>Guest Access</span>
                </li>
                <li class="no-sub">
                    <a class="" href="{{ route('login') }}">
                        <i class="iconoir-log-in"></i> Login to your account
                    </a>
                </li>
                <li class="no-sub">
                    <a class="" href="{{ route('register') }}">
                        <i class="iconoir-user-plus"></i> Register now
                    </a>
                </li>
            @endguest


            <li class="no-sub">
                <a class="" href="mailto:teqlathemes@gmail.com">
                    <i class="iconoir-chat-bubble-question"></i> Support
                </a>
            </li> 
            
        </ul>
    </div>

    <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>

</nav>
<!-- Menu Navigation ends -->
