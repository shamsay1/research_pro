@extends("layout.app")

@section("content")

<style>



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


/* =========================================================
   STAT CARDS
========================================================= */

.five-cols {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
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


/* =========================================================
   CARD TOP
========================================================= */

.card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}


/* =========================================================
   CARD ICON
========================================================= */

.card-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 17px;
}

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


/* =========================================================
   CARD TITLE
========================================================= */

.card-title {
    font-size: 11px;
    color: #64748b;
    margin: 0;
}


/* =========================================================
   CARD VALUE
========================================================= */

.card-value {
    font-size: 21px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}


/* =========================================================
   DASHBOARD SECTION
========================================================= */

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


/* =========================================================
   TABLE
========================================================= */

.research-table {
    margin-bottom: 0;
}

.research-table th {
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    white-space: nowrap;
    border-bottom: 1px solid #e2e8f0;
}

.research-table td {
    font-size: 12px;
    color: #334155;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
}

.research-title {
    font-weight: 500;
    color: #0f172a;
    max-width: 350px;
}


/* =========================================================
   STATUS BADGES
========================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 20px;

    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}


/* =========================================================
   PROGRESS
========================================================= */

.progress {
    background: #f1f5f9;
    border-radius: 20px;
}

.progress-bar {
    border-radius: 20px;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-research {
    text-align: center;
    padding: 35px 10px;
}

.empty-research i {
    font-size: 30px;
    color: #94a3b8;
    display: block;
    margin-bottom: 8px;
}

.empty-research p {
    margin: 0;
    color: #94a3b8;
    font-size: 12px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .five-cols {
        grid-template-columns: repeat(2, 1fr);
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


<!-- =========================================================
     DASHBOARD HEADER
========================================================= -->

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



<!-- =========================================================
     STATISTICS CARDS
========================================================= -->

<div class="five-cols">


    <!-- =====================================================
         RESEARCH PROJECTS
    ====================================================== -->

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



    <!-- =====================================================
         STUDENTS
    ====================================================== -->

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



    <!-- =====================================================
         SUPERVISORS
    ====================================================== -->

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



    <!-- =====================================================
         COMPLETED RESEARCH
    ====================================================== -->

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



<!-- =========================================================
     SECOND SECTION
========================================================= -->

<div class="dashboard-section">

    <div class="row g-3">


        <!-- =================================================
             RECENT RESEARCH PROJECTS
        ================================================== -->

        <div class="col-lg-8">

            <div class="section-card">


                <!-- TITLE -->

                <div class="section-title">

                    @if($role === 'student')

                        My Research Projects

                    @elseif($role === 'supervisors')

                        Recent Student Research

                    @else

                        Recent Research Projects

                    @endif

                </div>



                <!-- TABLE -->

                <div class="table-responsive">

                    <table class="table table-sm align-middle research-table">

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


                                    <!-- STUDENT -->

                                    <td>

                                        @if($role === 'student')

                                            <strong>
                                                {{ $user->firstname ?? '' }}
                                                {{ $user->lastname ?? '' }}
                                            </strong>

                                        @else

                                            <strong>
                                                {{ $research->firstname ?? '' }}
                                                {{ $research->lastname ?? '' }}
                                            </strong>

                                        @endif

                                    </td>



                                    <!-- TITLE -->

                                    <td>

                                        <div class="research-title">

                                            {{ $research->title }}

                                        </div>

                                    </td>



                                    <!-- STATUS -->

                                    <td>

                                        @if($research->status === 'pending')

                                            <span class="status-badge bg-warning-subtle text-warning">

                                                Pending

                                            </span>


                                        @elseif(
                                            $research->status === 'under_review'
                                            ||
                                            $research->status === 'in_progress'
                                        )

                                            <span class="status-badge bg-primary-subtle text-primary">

                                                In Progress

                                            </span>


                                        @elseif(
                                            $research->status === 'completed'
                                            ||
                                            $research->status === 'approved'
                                        )

                                            <span class="status-badge bg-success-subtle text-success">

                                                Completed

                                            </span>


                                        @elseif($research->status === 'correction')

                                            <span class="status-badge bg-danger-subtle text-danger">

                                                Correction

                                            </span>


                                        @else

                                            <span class="status-badge bg-secondary-subtle text-secondary">

                                                {{ ucfirst(str_replace('_', ' ', $research->status)) }}

                                            </span>

                                        @endif

                                    </td>


                                </tr>

                            @empty


                                <!-- EMPTY -->

                                <tr>

                                    <td colspan="3">

                                        <div class="empty-research">

                                            <i class="bi bi-journal-x"></i>

                                            <p>
                                                No research projects found.
                                            </p>

                                        </div>

                                    </td>

                                </tr>


                            @endforelse


                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        <!-- =================================================
             RESEARCH STATUS
        ================================================== -->

        <div class="col-lg-4">

            <div class="section-card">


                <div class="section-title">

                    Research Status

                </div>



                <!-- ==========================================
                     COMPLETED
                =========================================== -->

                <div class="d-flex justify-content-between mb-2">

                    <span class="small">

                        Completed

                    </span>

                    <strong class="small">

                        {{ $completed }}

                    </strong>

                </div>


                <div
                    class="progress mb-3"
                    style="height:7px;"
                >

                    <div
                        class="progress-bar bg-success"
                        role="progressbar"
                        style="width: {{ $completedPercentage }}%;"
                        aria-valuenow="{{ $completedPercentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>

                </div>



                <!-- ==========================================
                     IN PROGRESS
                =========================================== -->

                <div class="d-flex justify-content-between mb-2">

                    <span class="small">

                        In Progress

                    </span>

                    <strong class="small">

                        {{ $inProgress }}

                    </strong>

                </div>


                <div
                    class="progress mb-3"
                    style="height:7px;"
                >

                    <div
                        class="progress-bar bg-primary"
                        role="progressbar"
                        style="width: {{ $inProgressPercentage }}%;"
                        aria-valuenow="{{ $inProgressPercentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>

                </div>



                <!-- ==========================================
                     PENDING
                =========================================== -->

                <div class="d-flex justify-content-between mb-2">

                    <span class="small">

                        Pending

                    </span>

                    <strong class="small">

                        {{ $pending }}

                    </strong>

                </div>


                <div
                    class="progress"
                    style="height:7px;"
                >

                    <div
                        class="progress-bar bg-warning"
                        role="progressbar"
                        style="width: {{ $pendingPercentage }}%;"
                        aria-valuenow="{{ $pendingPercentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>

                </div>


            </div>

        </div>


    </div>

</div>


@endsection

