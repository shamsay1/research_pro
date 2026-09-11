<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >


    <style>

        /* =========================
           RESET
        ========================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: "Segoe UI", sans-serif;

            background: #f5f7fb;

            color: #334155;

            font-size: 14px;

            overflow-x: hidden;
        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {

            position: fixed;

            top: 0;
            left: 0;

            width: 190px;

            height: 100vh;

            background: #1e293b;

            color: white;

            z-index: 1000;

            transition: all 0.3s ease;

            overflow-y: auto;

            overflow-x: hidden;
        }


        /* Sidebar collapsed */

        .sidebar.hide {

            width: 70px;
        }


        /* =========================
           SIDEBAR HEADER
        ========================= */

        .sidebar-header {

            height: 55px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                linear-gradient(
                    45deg,
                    #0f172a,
                    #1e3a8a
                );

            font-size: 17px;

            font-weight: 700;

            white-space: nowrap;
        }


        /* =========================
           SIDEBAR LINKS
        ========================= */

        .sidebar a {

            display: flex;

            align-items: center;

            gap: 10px;

            width: 100%;

            padding: 11px 15px;

            color: #cbd5e1;

            text-decoration: none;

            font-size: 15px;

            transition: 0.25s;

            white-space: nowrap;
        }


        .sidebar a i {

            min-width: 20px;

            font-size: 17px;

            text-align: center;
        }


        .sidebar a:hover {

            background: #334155;

            color: white;
        }


        .sidebar a.active {

            background: #334155;

            color: white !important;

            border-left: 3px solid #3b82f6;
        }


        /* Hide text when collapsed */

        .sidebar.hide a span {

            display: none;
        }


        .sidebar.hide .sidebar-header span {

            display: none;
        }


        /* Center icons */

        .sidebar.hide a {

            justify-content: center;

            padding-left: 0;

            padding-right: 0;
        }


        /* =========================
           TOPBAR
        ========================= */

        .topbar {

            position: fixed;

            top: 0;

            right: 0;

            left: 190px;

            height: 55px;

            background: white;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 18px;

            border-bottom: 1px solid #e2e8f0;

            z-index: 999;

            transition: all 0.3s ease;
        }


        .topbar.full {

            left: 70px;
        }


        .topbar h6 {

            color: #0f172a;

            font-weight: 600;

            font-size: 14px;
        }
        .chat-menu {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
}

.chat-icon {
    position: relative;
    width: 25px;
    height: 25px;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: visible !important;
}

.chat-icon i {
    font-size: 20px;
    line-height: 1;
}


/* ===============================
   NOTIFICATION BADGE
================================ */

.chat-notification {
    position: absolute;

    /* CORNER YA ICON */
    top: -9px;
    right: -11px;

    min-width: 17px;
    height: 17px;

    padding: 0 4px;

    background: #ff3b30;

    color: #fff;

    border-radius: 50px;

    border: 2px solid #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 9px;
    font-weight: 700;

    line-height: 1;

    z-index: 9999;

    white-space: nowrap;

    box-sizing: border-box;
}


        /* =========================
           TOGGLE BUTTON
        ========================= */

        .toggle-btn {

            width: 34px;

            height: 34px;

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

            border-radius: 7px;

            color: #475569;

            font-size: 20px;

            transition: 0.2s;
        }


        .toggle-btn:hover {

            background: #f1f5f9;

            color: #2563eb;
        }


        /* =========================
           MAIN CONTENT
        ========================= */

        .content {

            margin-left: 190px;

            padding: 75px 18px 25px;

            min-height: 100vh;

            transition: all 0.3s ease;
        }


        .content.full {

            margin-left: 70px;
        }


        /* =========================
           DASHBOARD CARDS
        ========================= */

        .card-custom {

            border: none;

            border-radius: 10px;

            padding: 15px;

            background: white;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.05);

            transition: 0.25s;
        }


        .card-custom:hover {

            transform: translateY(-2px);

            box-shadow:
                0 6px 15px rgba(0, 0, 0, 0.08);
        }


        .card-title {

            font-size: 12px;

            color: #64748b;

            margin-bottom: 5px;
        }


        .card-value {

            font-size: 22px;

            font-weight: 700;

            color: #0f172a;
        }


        /* =========================
           FIVE CARDS
        ========================= */

        .five-cols {

            display: grid;

            grid-template-columns:
                repeat(5, 1fr);

            gap: 15px;

            width: 100%;
        }


        /* =========================
           TABLE
        ========================= */

        .table-container {

            background: white;

            padding: 15px;

            border-radius: 10px;

            margin-top: 15px;

            overflow-x: auto;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.04);
        }


        /* =========================
           OVERLAY
        ========================= */

        #overlay {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(0, 0, 0, 0.45);

            z-index: 998;
        }


        #overlay.show {

            display: block;
        }


        /* =========================
           TABLET
        ========================= */

        @media (max-width: 1100px) {

            .five-cols {

                grid-template-columns:
                    repeat(3, 1fr);
            }
        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 768px) {

            /* Sidebar */

            .sidebar {

                left: -190px;

                width: 190px;
            }


            .sidebar.show {

                left: 0;
            }


            /* Topbar */

            .topbar {

                left: 0;

                height: 55px;

                padding: 0 12px;
            }


            .topbar.full {

                left: 0;
            }


            /* Content */

            .content {

                margin-left: 0;

                padding:
                    70px 12px 20px;
            }


            .content.full {

                margin-left: 0;
            }


            /* Cards */

            .five-cols {

                grid-template-columns:
                    repeat(2, 1fr);

                gap: 10px;
            }


            .card-custom {

                padding: 12px;
            }


            .card-value {

                font-size: 20px;
            }
        }


        /* =========================
           SMALL MOBILE
        ========================= */

        @media (max-width: 576px) {

            .five-cols {

                grid-template-columns: 1fr;
            }


            .topbar h6 {

                font-size: 13px;
            }


            .content {

                padding-left: 10px;

                padding-right: 10px;
            }
        }
        #pageLoader {
        position: fixed;
        inset: 0;
        background: rgba(255, 255, 255, 0.97);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999999;
        opacity: 1;
        visibility: visible;
        transition: opacity .3s ease, visibility .3s ease;
    }

    #pageLoader.hide {
        opacity: 0;
        visibility: hidden;
    }

    .loader-box {
        text-align: center;
    }

    .spinner {
        width: 48px;
        height: 48px;
        border: 4px solid #e5e7eb;
        border-top: 4px solid #2563eb;
        border-radius: 50%;
        animation: spin .8s linear infinite;
        margin: 0 auto 12px;
    }

    .loader-text {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    </style>

</head>


<body>
    <div id="pageLoader">
        <div class="loader-box">
            <div class="spinner"></div>
            <div class="loader-text">Loading...</div>
        </div>
    </div>



 @php

    // Chat unread count
    if (Auth::guard('web')->check()) {
    $unreadChats = App\Models\ChatMessage::where('is_read', 0)->where('admin_id',Auth::guard('web')->user()->id)->count();
    }
    // Default values
    $notifications = collect();
    $unreadNotifications = 0;

    // Check logged in user
    if (Auth::guard('web')->check()) {

        $user = Auth::guard('web')->user();

        // User's notifications
        $notifications = App\Models\Notification::where(
            'supervisor_id',
            $user->id
        )->where('is_read',false)
        ->latest()
        ->get();

        // Unread notifications
        $unreadNotifications = App\Models\Notification::where(
            'supervisor_id',
            $user->id
        )
        ->where('is_read', false)
        ->count();
    }

@endphp


    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside
        class="sidebar"
        id="sidebar"
    >

        <!-- Header -->

        <div class="sidebar-header">
            @if(Auth::guard('web')->check() && Auth::guard('web')->user()->role === 'admin')
            <span>Admin</span>
            @elseif(Auth::guard('web')->check() && Auth::guard('web')->user()->role === 'supervisors')
            <span>Supervisor</span>
            @else
            <span>Student</span>
            @endif

        </div>


        <!-- Dashboard -->

        <a
            href="/dashboard"
            class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
        >

            <i class="bi bi-speedometer2"></i>

            <span>Dashboard</span>

        </a>


       @if(
    Auth::guard('web')->check() &&
    Auth::guard('web')->user()->role === 'admin'
)

    {{-- =====================================================
         ADMIN
    ====================================================== --}}

    <a href="{{ route('staff.index') }}" class="{{ Route::currentRouteName() == 'staff.index' ? 'active' : '' }}">

        <i class="bi bi-person-badge-fill"></i>

        <span>Manage Supervisors</span>

    </a>


    <a href="{{ route('student.index') }}" class="{{ Route::currentRouteName() == 'student.index' ? 'active' : '' }}">

        <i class="bi bi-mortarboard-fill"></i>

        <span>Manage Students</span>

    </a>


    <a href="{{ route('supervisor.assignments.index') }}" class="{{ Route::currentRouteName() == 'supervisor.assignments.index' ? 'active' : '' }}">

        <i class="bi bi-person-check-fill"></i>

        <span>Assign Students</span>

    </a>
    <a href="{{ route('supervisor.students') }}" class="{{ Route::currentRouteName() == 'supervisor.students' ? 'active' : '' }}">

        <i class="bi bi-people-fill"></i>

        <span>My Students</span>

    </a>


    <a href="{{ route('supervisor.research') }}" class="{{ Route::currentRouteName() == 'supervisor.research' ? 'active' : '' }}">

        <i class="bi bi-journal-text"></i>

        <span>Researches</span>

    </a>
 <a href="{{ route('admin.chats') }}" class="chat-menu {{Route::currentRouteName() == 'admin.chats' ? 'active' : ''}}">

    <div class="chat-icon">

        <i class="bi bi-chat-right-text-fill"></i>

        @if($unreadChats > 0)

            <span class="chat-notification">
                {{ $unreadChats > 99 ? '99+' : $unreadChats }}
            </span>

        @endif

    </div>

    <span>Chats</span>

</a>


   


    <a href="{{ route('admin.research.report') }}" class="{{ Route::currentRouteName() == 'admin.research.report' ? 'active' : '' }}">

       <i class="bi bi-bar-chart"></i>

        <span>Report</span>

    </a>


@elseif(
    Auth::guard('web')->check() &&
    Auth::guard('web')->user()->role === 'supervisors'
)

    {{-- =====================================================
         SUPERVISOR
    ====================================================== --}}

    <a href="{{ route('supervisor.students') }}" class="{{ Route::currentRouteName() == 'supervisor.students' ? 'active' : '' }}">

        <i class="bi bi-people-fill"></i>

        <span>My Students</span>

    </a>


    <a href="{{ route('supervisor.research') }}" class="{{ Route::currentRouteName() == 'supervisor.research' ? 'active' : '' }}">

        <i class="bi bi-journal-text"></i>

        <span>Researches</span>

    </a>
    {{-- <a href="{{ route('student.chat') }}" class="{{ Route::currentRouteName() == 'student.chat' ? 'active' : '' }}">

        <i class="bi bi-chat-left-text-fill"></i>

        <span>Chats</span>

    </a> --}}


@elseif(
    Auth::guard('student')->check()
)

    {{-- =====================================================
         STUDENT
    ====================================================== --}}
    <a href="{{ route('supervisors1') }}" class="{{ Route::currentRouteName() == 'supervisors1' ? 'active' : '' }}">

        <i class="bi bi-people"></i>

        <span>My supervisors</span>

    </a>
    <a href="{{ route('student.research') }}" class="{{ Route::currentRouteName() == 'student.research' ? 'active' : '' }}">

        <i class="bi bi-file-earmark-text-fill"></i>

        <span>Submission</span>

    </a>


    <a href="{{ route('student.research.responses') }}" class="{{ Route::currentRouteName() == 'student.research.responses' ? 'active' : '' }}">

        <i class="bi bi-chat-left-text-fill"></i>

        <span>Responses</span>

    </a>
    
    <a href="{{ route('student.chat') }}" class="{{ Route::currentRouteName() == 'student.chat' ? 'active' : '' }}">

        <i class="bi bi-chat-left-text-fill"></i>

        <span>Chats</span>

    </a>
    


@endif

        <!-- Logout -->
        <a href="{{ route('settings') }}" class="{{ Route::currentRouteName() == 'settings' ? 'active' : '' }}">

            <i class="bi bi-people-fill"></i>

            <span>Setting</span>

        </a>

        <a
    href="#"
    onclick="
        event.preventDefault();
        document.getElementById('logout-form').submit();
    "
>
    <i class="bi bi-box-arrow-right"></i>
    <span>Logout</span>
</a>

<form
    id="logout-form"
    action="{{ route('logout') }}"
    method="POST"
    style="display:none;"
>
    @csrf
</form>

    </aside>



    <!-- =========================
         OVERLAY
    ========================= -->

    <div id="overlay"></div>



    <!-- =========================
         TOPBAR
    ========================= -->

    <header
        class="topbar"
        id="topbar"
    >

        <div
            class="d-flex align-items-center gap-2"
        >

            <div
                class="toggle-btn"
                id="toggleBtn"
                onclick="toggleSidebar()"
            >

                <i class="bi bi-list"></i>

            </div>


            <h6 class="mb-0">

                Dashboard

            </h6>

        </div>


        <!-- Right Side -->
        <div class="d-flex align-items-center gap-3">

    <!-- Notification -->
    <div class="dropdown">

        <button
            class="btn btn-light position-relative"
            type="button"
            id="notificationDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
        >

            <i class="bi bi-bell fs-5"></i>

            @if($unreadNotifications > 0)
                <span
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                >
                    {{ $unreadNotifications }}
                </span>
            @endif

        </button>


        <!-- Notification Card -->
        <div
            class="dropdown-menu dropdown-menu-end shadow border-0 p-0"
            style="width: 380px;"
            aria-labelledby="notificationDropdown"
        >

            <!-- Header -->
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="mb-0 fw-bold">
                        Notifications
                    </h6>

                    <small class="text-muted">
                        Your latest notifications
                    </small>
                </div>

                @if($unreadNotifications > 0)
                    <span class="badge bg-danger">
                        {{ $unreadNotifications }} New
                    </span>
                @endif

            </div>


            <!-- Notifications -->
            <div style="max-height: 400px; overflow-y: auto;">

                @forelse($notifications as $notification)

                    <div
                        class="p-3 border-bottom notification-item
                        {{ !$notification->is_read ? 'bg-light' : '' }}"
                    >

                        <div class="d-flex gap-3">

                            <!-- Icon -->
                            <div>
                                <div
                                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;"
                                >
                                    <i class="bi bi-bell"></i>
                                </div>
                            </div>


                            <!-- Content -->
                            <div class="flex-grow-1">

                                <div class="d-flex justify-content-between">

                                    <h6 class="mb-1 fw-bold">
                                        {{ $notification->title }}
                                    </h6>

                                    @if(!$notification->is_read)
                                        <span class="badge bg-primary">
                                            New
                                        </span>
                                    @endif

                                </div>

                                <p class="mb-1 text-muted small">
                                    {{ $notification->message }}
                                </p>

                                <small class="text-secondary">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center p-4">

                        <i
                            class="bi bi-bell-slash fs-1 text-muted"
                        ></i>

                        <p class="text-muted mb-0 mt-2">
                            No notifications
                        </p>

                    </div>

                @endforelse

            </div>


            <!-- Footer -->
            <div class="p-2 text-center border-top">

                <form
    action="{{ route('notifications.clearAll') }}"
    method="POST"
    class="d-inline"
>
    @csrf

    <button
        type="submit"
        class="btn btn-link text-decoration-none small p-0"
    >
        Clear all
    </button>
</form>

            </div>

        </div>

    </div>


    <!-- User -->

    <div class="d-flex align-items-center gap-2">

        <i class="bi bi-person-circle fs-5"></i>

        <span class="d-none d-sm-inline">
            @if (Auth::guard('web')->check() &&
            Auth::guard('web')->user()->role === 'admin')
            {{ Auth::guard('web')->user()->firstname.'    '.Auth::guard('web')->user()->middlename  }}
            @elseif (Auth::guard('web')->check() &&
            Auth::guard('web')->user()->role === 'supervisors')
            {{ Auth::guard('web')->user()->firstname.'    '.Auth::guard('web')->user()->middlename  }}
            @elseif(Auth::guard('student')->check())
              {{ Auth::guard('student')->user()->firstname.'  '.Auth::guard('student')->user()->middlename }}

            @endif
        </span>

    </div>

</div>

       

    </header>



    <!-- =========================
         CONTENT
    ========================= -->

    <main
        class="content"
        id="content"
    >

        @yield("content")

    </main>



    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    ></script>


    <!-- =========================
         SIDEBAR JAVASCRIPT
    ========================= -->

    <script>

        function toggleSidebar() {

            const sidebar =
                document.getElementById("sidebar");

            const content =
                document.getElementById("content");

            const topbar =
                document.getElementById("topbar");

            const overlay =
                document.getElementById("overlay");


            /* ======================
               MOBILE
            ====================== */

            if (window.innerWidth <= 768) {

                sidebar.classList.toggle("show");

                overlay.classList.toggle(
                    "show",
                    sidebar.classList.contains("show")
                );

                return;
            }


            /* ======================
               DESKTOP
            ====================== */

            sidebar.classList.toggle("hide");

            content.classList.toggle("full");

            topbar.classList.toggle("full");
        }



        /* =========================
           CLOSE MOBILE SIDEBAR
        ========================= */

        document
            .getElementById("overlay")
            .addEventListener(
                "click",
                function () {

                    document
                        .getElementById("sidebar")
                        .classList.remove("show");

                    this.classList.remove("show");

                }
            );



        /* =========================
           AUTO RESET ON RESIZE
        ========================= */

        window.addEventListener(
            "resize",
            function () {

                const sidebar =
                    document.getElementById("sidebar");

                const content =
                    document.getElementById("content");

                const topbar =
                    document.getElementById("topbar");

                const overlay =
                    document.getElementById("overlay");


                if (window.innerWidth > 768) {

                    sidebar.classList.remove("show");

                    overlay.classList.remove("show");

                }

            }
        );

    </script>
    <script>
    window.addEventListener('load', function () {

        const loader = document.getElementById('pageLoader');

        if (loader) {
            loader.classList.add('hide');

            setTimeout(function () {
                loader.remove();
            }, 300);
        }

    });
</script>

</body>

</html>