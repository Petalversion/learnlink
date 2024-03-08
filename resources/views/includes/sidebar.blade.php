<!-- Student -->
@if(Auth::guard('student')->check())
<div id="wrapper">
  <!-- Sidebar -->
  <div class="position-fixed" style="top: 0; height: 100%; z-index: 1000;">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <div class="nk-nav-logo">
        <a href="{{route('index')}}" class="nk-nav-logo">
          <img src="/img/white.png" alt="" width="105" class="logo-img large-img" style="margin-top: 20px; margin-bottom: 20px; margin-left: 20px;">
          <img src="/img/ll-white.png" alt="" class="logo-img small-img" style="height: 40px;margin-top:15px;margin-left:32px;margin-bottom:15px">
        </a>
      </div>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('student.courses') || request()->routeIs('student.learn') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('student.courses')}}">
          <i class="fas fa-fw fa-book"></i>
          <span>Enrolled Courses</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('student.certificates') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('student.certificates')}}">
          <i class="fas fa-fw fa-award"></i>
          <span>Certificates</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('student.history') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('student.history')}}">
          <i class="fas fa-fw fa-clock-rotate-left"></i>
          <span>Purchase History</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('student.cart') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('student.cart')}}">
          <i class="fas fa-fw fa-cart-shopping"></i>
          <span>My Cart</span>
        </a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          <span>Log Out</span></a>
      </li>
    </ul>
  </div>
  <!-- End of Sidebar -->
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
      <!-- Topbar -->
      <div class="navbar-wrapper position-fixed w-100" style="z-index: 999;">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-800 small">{{$name}}</span>
                @if(isset($user_info) && $user_info->profile_picture)
                <img class="img-profile rounded-circle" src="{{ asset('storage/' . $user_info->profile_picture) }}">
                @else
                <!-- Add a placeholder image or default image -->
                <img class="img-profile rounded-circle" src="/img/9131529.png" alt="Placeholder Image">
                @endif
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('student.profile')}}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
              </div>
            </li>
        </nav>
      </div>
      @yield('content')
    </div>
  </div>
</div>

@elseif(Auth::guard('admin')->check())
<div id="wrapper">
  <!-- Sidebar -->
  <div class="position-fixed" style="top: 0; height: 100%; z-index: 1000;">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <div class="nk-nav-logo">
        <a href="{{route('index')}}" class="nk-nav-logo">
          <img src="/img/white.png" alt="" width="105" class="logo-img large-img" style="margin-top: 20px; margin-bottom: 20px; margin-left: 20px;">
          <img src="/img/ll-white.png" alt="" class="logo-img small-img" style="height: 40px;margin-top:15px;margin-left:32px;margin-bottom:15px">
        </a>
      </div>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ (request()->routeIs('admin.student') || request()->routeIs('admin.instructor')) || request()->routeIs('admin.admin') || request()->routeIs('admin.course') || request()->routeIs('admin.lesson') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
          <i class="fas fa-fw fa-users"></i>
          <span>Users</span>
          @if ($pendingInstructor > 0)
          <span class="badge bg-danger rounded-pill position-absolute top-0 start-51">{{ $pendingInstructor }}</span>
          @endif
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">User Accounts:</h6>
            <a class="collapse-item" href="{{route('admin.student')}}">Students</a>
            <a class="collapse-item position-relative" href="{{route('admin.instructor')}}">
              Instructor
              @if ($pendingInstructor > 0)
              <span class="badge bg-danger rounded-pill position-absolute top-0 start-51">{{ $pendingInstructor }}</span>
              @endif
            </a>
            <a class="collapse-item" href="{{route('admin.admin')}}">Admin</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Register:</h6>
            <a class="collapse-item" href="{{route('admin.register')}}">New Admin</a>
          </div>
        </div>
      </li>
      <li class="nav-item {{ request()->routeIs('admin.transaction') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('admin.transaction')}}">
          <i class="fas fa-fw fa-exchange"></i>
          <span>Transactions</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('admin.withdrawal.request') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('admin.withdrawal.request')}}">
          <i class="fas fa-fw fa-receipt"></i>
          <span>Withdrawal Requests</span>
          @if ($withdrawalRequest > 0)
          <span class="badge bg-danger rounded-pill position-absolute top-0 start-98">{{ $withdrawalRequest }}</span>
          @endif
        </a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          <span>Log Out</span></a>
      </li>
    </ul>
  </div>
  <!-- End of Sidebar -->
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
      <!-- Topbar -->
      <div class="navbar-wrapper w-100" style="z-index: 999;">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-800 small">{{$name}}</span>
                @if(isset($instructor_info) && $instructor_info->profile_picture)
                <img class="img-profile rounded-circle" src="{{ asset('storage/' . $instructor_info->profile_picture) }}">
                @else
                <!-- Add a placeholder image or default image -->
                <img class="img-profile rounded-circle" src="/img/9131529.png" alt="Placeholder Image">
                @endif
              </a>
              <!-- Dropdown - User Information -->
              <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('instructor.profile')}}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
              </div> -->
            </li>
        </nav>
      </div>
      @yield('content')
    </div>
  </div>
</div>

@else
<div id="wrapper">
  <!-- Sidebar -->
  <div class="position-fixed" style="top: 0; height: 100%; z-index: 1000;">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <div class="nk-nav-logo">
        <a href="{{route('index')}}" class="nk-nav-logo">
          <img src="/img/white.png" alt="" width="105" class="logo-img large-img" style="margin-top: 20px; margin-bottom: 20px; margin-left: 20px;">
          <img src="/img/ll-white.png" alt="" class="logo-img small-img" style="height: 40px;margin-top:15px;margin-left:32px;margin-bottom:15px">
        </a>
      </div>
      <!-- Divider -->
      <hr class=" sidebar-divider my-0">
      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('instructor.dashboard')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('instructor.course.course') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('instructor.course.course')}}">
          <i class="fas fa-fw fa-book-open"></i>
          <span>Courses</span>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('instructor.questions') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuestions" aria-expanded="true" aria-controls="collapseQuestions">
          <i class="fas fa-fw fa-comments"></i>
          <span>Feedback</span>
          @if ($questionNotif > 0)
          <span class="badge bg-danger rounded-pill position-absolute top-0 start-98">{{ $questionNotif }}</span>
          @endif
        </a>
        <div id="collapseQuestions" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Questions:</h6>
            <a class="collapse-item position-relative" href="{{route('instructor.questions')}}">
              Recent Questions
              @if ($questionNotif > 0)
              <span class="badge bg-danger rounded-pill position-absolute top-0 start-51">{{ $questionNotif }}</span>
              @endif
            </a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Reviews:</h6>
            <a class="collapse-item" href="{{route('instructor.reviews')}}">Course Reviews</a>
          </div>
        </div>
      </li>
      <li class="nav-item {{ (request()->routeIs('instructor.transactions') || request()->routeIs('instructor.transactions.new')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
          <i class="fas fa-fw fa-exchange"></i>
          <span>Withdrawal</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Withdrawal:</h6>
            <a class="collapse-item" href="{{route('instructor.transactions')}}">Withdrawal History</a>
            <a class="collapse-item" href="{{route('instructor.transactions.new')}}">Withdrawal Request</a>
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          <span>Log Out</span></a>
      </li>
    </ul>
  </div>
  <!-- End of Sidebar -->
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
      <!-- Topbar -->
      <div class="navbar-wrapper position-fixed w-100" style="z-index: 999;">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-800 small">{{$name}}</span>
                @if(isset($instructor_info) && $instructor_info->profile_picture)
                <img class="img-profile rounded-circle" src="{{ asset('storage/' . $instructor_info->profile_picture) }}">
                @else
                <!-- Add a placeholder image or default image -->
                <img class="img-profile rounded-circle" src="/img/9131529.png" alt="Placeholder Image">
                @endif
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('instructor.profile')}}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
              </div>
            </li>
        </nav>
      </div>
      @yield('content')
    </div>
  </div>
</div>
@endif
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
          <button type="submit">Logout</button>
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-weight:700 !important;" class="btn btn-primary">Logout</a>
      </div>
    </div>
  </div>
</div>