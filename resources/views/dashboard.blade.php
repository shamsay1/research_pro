@extends("layout.app")

@section("content")

<style>

/* =========================
   DASHBOARD HEADER
========================= */

.dashboard-header {
    margin-bottom: 18px;
}

.dashboard-header h4 {
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 3px;
}

.dashboard-header p {
    font-size: 12px;
    color: #64748b;
    margin: 0;
}


/* =========================
   STAT CARDS
========================= */

.five-cols {
    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 14px;

    width: 100%;
}


.card-custom {
    background: #ffffff;

    border: none;

    border-radius: 10px;

    padding: 15px;

    min-height: 105px;

    box-shadow:
        0 2px 8px rgba(15, 23, 42, 0.05);

    transition: 0.25s;

    position: relative;

    overflow: hidden;
}


.card-custom:hover {
    transform: translateY(-3px);

    box-shadow:
        0 7px 18px rgba(15, 23, 42, 0.08);
}


/* Card top */

.card-top {
    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 10px;
}


/* Icon */

.card-icon {
    width: 35px;

    height: 35px;

    border-radius: 8px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 17px;
}


/* Different icon colors */

.icon-blue {
    background: #eff6ff;

    color: #2563eb;
}

.icon-green {
    background: #ecfdf5;

    color: #059669;
}

.icon-orange {
    background: #fff7ed;

    color: #ea580c;
}

.icon-purple {
    background: #f5f3ff;

    color: #7c3aed;
}


/* Card title */

.card-title {
    font-size: 11px;

    color: #64748b;

    margin: 0;
}


/* Card value */

.card-value {
    font-size: 21px;

    font-weight: 700;

    color: #0f172a;

    margin: 0;
}


/* =========================
   QUICK SECTION
========================= */

.dashboard-section {
    margin-top: 18px;
}


.section-card {
    background: #ffffff;

    border-radius: 10px;

    padding: 18px;

    box-shadow:
        0 2px 8px rgba(15, 23, 42, 0.05);
}


.section-title {
    font-size: 14px;

    font-weight: 600;

    color: #0f172a;

    margin-bottom: 15px;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1100px) {

    .five-cols {
        grid-template-columns:
            repeat(2, 1fr);
    }

}


@media (max-width: 576px) {

    .five-cols {
        grid-template-columns: 1fr;
    }

    .dashboard-header h4 {
        font-size: 18px;
    }

}

</style>


<!-- =========================
     DASHBOARD HEADER
========================= -->

<div class="dashboard-header">

    <h4>
        Dashboard
    </h4>

    <p>
        Welcome
        {{ $user->firstname ?? $user->name ?? 'User' }}
        to Research Tracking System
    </p>

</div>


<!-- =========================
     STATISTICS
========================= -->

<div class="five-cols">


    <!-- ======================
         RESEARCH PROJECTS
    ======================= -->

    <div class="card-custom">

        <div class="card-top">

            <div>

                <p class="card-title">
                    @if($role === 'student')
                        My Research Projects
                    @elseif($role === 'supervisors')
                        Assigned Research
                    @else
                        Research Projects
                    @endif
                </p>

                <p class="card-value">
                    {{ $researchProjects }}
                </p>

            </div>


            <div class="card-icon icon-blue">

                <i class="bi bi-journal-text"></i>

            </div>

        </div>

    </div>



    <!-- ======================
         STUDENTS
    ======================= -->

    <div class="card-custom">

        <div class="card-top">

            <div>

                <p class="card-title">

                    @if($role === 'student')
                        My Profile
                    @elseif($role === 'supervisors')
                        My Students
                    @else
                        Registered Students
                    @endif

                </p>

                <p class="card-value">
                    {{ $registeredStudents }}
                </p>

            </div>


            <div class="card-icon icon-green">

                <i class="bi bi-people-fill"></i>

            </div>

        </div>

    </div>



    <!-- ======================
         SUPERVISORS
    ======================= -->

    <div class="card-custom">

        <div class="card-top">

            <div>

                <p class="card-title">

                    @if($role === 'student')
                        My Supervisor
                    @elseif($role === 'supervisors')
                        Supervisor
                    @else
                        Supervisors
                    @endif

                </p>

                <p class="card-value">
                    {{ $supervisors }}
                </p>

            </div>


            <div class="card-icon icon-orange">

                <i class="bi bi-person-workspace"></i>

            </div>

        </div>

    </div>



    <!-- ======================
         COMPLETED RESEARCH
    ======================= -->

    <div class="card-custom">

        <div class="card-top">

            <div>

                <p class="card-title">
                    Completed Research
                </p>

                <p class="card-value">
                    {{ $completedResearch }}
                </p>

            </div>


            <div class="card-icon icon-purple">

                <i class="bi bi-check-circle-fill"></i>

            </div>

        </div>

    </div>

</div>



<!-- =========================
     SECOND SECTION
========================= -->

<div class="dashboard-section">

    <div class="row g-3">


        <!-- Recent Research -->

        <div class="col-lg-8">

            <div class="section-card">

                <div class="section-title">

                    @if($role === 'student')
                        My Research Projects
                    @elseif($role === 'supervisors')
                        Recent Student Research
                    @else
                        Recent Research Projects
                    @endif

                </div>


                <div class="table-responsive">

                    <table class="table table-sm align-middle">

                        <thead>

                            <tr>

                                <th>
                                    Student
                                </th>

                                <th>
                                    Research Title
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($recentResearch as $research)

                                <tr>

                                    <td>

                                        @if($role === 'student')

                                            {{ $user->firstname }}
                                            {{ $user->lastname }}

                                        @else

                                            {{ $research->firstname ?? '' }}
                                            {{ $research->lastname ?? '' }}

                                        @endif

                                    </td>


                                    <td>

                                        {{ $research->title }}

                                    </td>


                                    <td>

                                        @if($research->status === 'pending')

                                            <span
                                                class="badge bg-warning-subtle text-warning"
                                            >
                                                Pending
                                            </span>

                                        @elseif($research->status === 'completed')

                                            <span
                                                class="badge bg-success-subtle text-success"
                                            >
                                                Completed
                                            </span>

                                        @elseif($research->status === 'in_progress')

                                            <span
                                                class="badge bg-primary-subtle text-primary"
                                            >
                                                In Progress
                                            </span>

                                        @elseif($research->status === 'correction')

                                            <span
                                                class="badge bg-danger-subtle text-danger"
                                            >
                                                Correction
                                            </span>

                                        @else

                                            <span
                                                class="badge bg-secondary-subtle text-secondary"
                                            >
                                                {{ ucfirst($research->status) }}
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3"
                                        class="text-center text-muted py-4">

                                        No research projects found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        <!-- Research Status -->

        <div class="col-lg-4">

            <div class="section-card">

                <div class="section-title">

                    Research Status

                </div>


                <!-- Completed -->

                <div class="d-flex justify-content-between mb-2">

                    <span class="small">
                        Completed
                    </span>

                    <strong class="small">
                        {{ $completed }}
                    </strong>

                </div>


                <div class="progress mb-3" style="height:7px;">

                    <div
                        class="progress-bar bg-success"
                        style="width:{{ $completedPercentage }}%;"
                    ></div>

                </div>



                <!-- In Progress -->

                <div class="d-flex justify-content-between mb-2">

                    <span class="small">
                        In Progress
                    </span>

                    <strong class="small">
                        {{ $inProgress }}
                    </strong>

                </div>


                <div class="progress mb-3" style="height:7px;">

                    <div
                        class="progress-bar bg-primary"
                        style="width:{{ $inProgressPercentage }}%;"
                    ></div>

                </div>



                <!-- Pending -->

                <div class="d-flex justify-content-between mb-2">

                    <span class="small">
                        Pending
                    </span>

                    <strong class="small">
                        {{ $pending }}
                    </strong>

                </div>


                <div class="progress" style="height:7px;">

                    <div
                        class="progress-bar bg-warning"
                        style="width:{{ $pendingPercentage }}%;"
                    ></div>

                </div>

            </div>

        </div>


    </div>

</div>


@endsection