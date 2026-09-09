@extends('layout.app')

@section('content')

<style>

    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .page-header h4 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
    }

    .page-header p {
        margin: 5px 0 0;
        font-size: 14px;
        color: #64748b;
    }

    .btn-add {
        border: 0;
        background: #2563eb;
        color: #fff;
        padding: 10px 16px;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-add:hover {
        background: #1d4ed8;
        color: #fff;
    }


    /* =========================================================
       MAIN CARD
    ========================================================= */

    .staff-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
    }


    /* =========================================================
       STUDENT ACCORDION
    ========================================================= */

    .student-accordion {
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .student-button {
        background: #fff !important;
        padding: 15px 18px !important;
        box-shadow: none !important;
    }

    .student-button:not(.collapsed) {
        background: #f8fafc !important;
        color: #0f172a !important;
    }

    .student-button:focus {
        box-shadow: none !important;
    }

    .student-header {
        display: flex;
        align-items: center;
        width: 100%;
        gap: 13px;
    }

    .student-avatar {
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .student-info {
        flex: 1;
        min-width: 0;
    }

    .student-name {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .student-reg {
        font-size: 16px;
        color: #64748b;
        margin-top: 3px;
    }

    .student-status {
        margin-right: 8px;
    }


    /* =========================================================
       BADGES
    ========================================================= */

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .core-badge {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        background: #dbeafe;
        color: #1d4ed8;
    }

    .principal-badge {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        background: #ede9fe;
        color: #7c3aed;
    }


    /* =========================================================
       STUDENT DETAILS
    ========================================================= */

    .student-details {
        padding: 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    .detail-title {
        font-size: 16px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 12px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .detail-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px;
    }

    .detail-label {
        font-size: 16px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        word-break: break-word;
    }


    /* =========================================================
       SUPERVISOR CARDS
    ========================================================= */

    .supervisors-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
    }

    .supervisor-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .supervisor-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
    }

    .supervisor-card.core {
        border-left: 4px solid #2563eb;
    }

    .supervisor-card.principal {
        border-left: 4px solid #7c3aed;
    }

    .supervisor-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .supervisor-person {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .supervisor-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #475569;
    }

    .supervisor-name {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
    }

    .supervisor-role {
        font-size: 15px;
        color: #64748b;
        margin-top: 2px;
    }

    .supervisor-details {
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
    }

    .supervisor-detail {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
        color: #475569;
        margin-bottom: 8px;
    }

    .supervisor-detail i {
        width: 16px;
        color: #64748b;
    }


    /* =========================================================
       ACTIONS
    ========================================================= */

    .action-area {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 18px;
        padding-top: 15px;
        border-top: 1px solid #e2e8f0;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 13px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .action-view {
        background: #eff6ff;
        color: #2563eb;
    }

    .action-view:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #64748b;
    }

    .empty-state i {
        font-size: 45px;
        color: #94a3b8;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .form-control,
    .form-select {
        height: 42px;
        border: 1px solid #dbe3ec;
        border-radius: 7px;
        background: #f8fafc;
        font-size: 13px;
    }

    .form-control:focus,
    .form-select:focus {
        background: #fff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.10);
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }

    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        padding: 12px 14px;
        border-radius: 8px;
        font-size: 12px;
        margin-bottom: 18px;
    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media(max-width: 768px) {

        .page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .btn-add {
            width: 100%;
        }

        .student-header {
            align-items: flex-start;
        }

        .student-status {
            display: none;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .supervisor-grid {
            grid-template-columns: 1fr;
        }

        .student-details {
            padding: 15px;
        }
    }

</style>

{{-- ========================================================= --}}
{{-- PAGE HEADER --}}
{{-- ========================================================= --}}

<div class="page-header">

<div>

    <h4>
        Student Supervisors
    </h4>

    <p>
        Manage Co-Supervisor and Principal Supervisors assigned to students
    </p>

</div>


<button
    class="btn-add"
    data-bs-toggle="modal"
    data-bs-target="#assignStudentModal"
>

    <i class="bi bi-person-plus-fill me-1"></i>

    Assign Supervisors

</button>


</div>

{{-- ========================================================= --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================================= --}}

@if(session('success'))
<div class="alert alert-success">

    <i class="bi bi-check-circle me-1"></i>

    {{ session('success') }}

</div>


@endif

{{-- ========================================================= --}}
{{-- VALIDATION ERRORS --}}
{{-- ========================================================= --}}

@if($errors->any())

<div class="alert alert-danger">

    <i class="bi bi-exclamation-triangle me-1"></i>

    <strong>Please correct the following:</strong>

    <ul class="mb-0 mt-2">

        @foreach($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

        @endforeach

    </ul>

</div>


@endif

{{-- ========================================================= --}}
{{-- MAIN CARD --}}
{{-- ========================================================= --}}

<div class="staff-card">

@php

    /*
    |--------------------------------------------------------------------------
    | Convert assignments grouped by teacher
    | into assignments grouped by student
    |--------------------------------------------------------------------------
    */

    $studentAssignments = collect();

    foreach ($assignments as $group) {

        foreach ($group as $assignment) {

            $studentAssignments->push($assignment);

        }

    }

    $studentAssignments = $studentAssignments
        ->groupBy('student_id');

@endphp



@if($studentAssignments->count() > 0)


    {{-- ================================================= --}}
    {{-- ACCORDION --}}
    {{-- ================================================= --}}

    <div
        class="accordion"
        id="studentAccordion"
    >


        @foreach($studentAssignments as $studentId => $studentGroup)

            @php

                $student = $studentGroup
                    ->first()
                    ->student;

                $coreSupervisor = $studentGroup
                    ->firstWhere(
                        'supervisor_type',
                        'core'
                    );

                $principalSupervisor = $studentGroup
                    ->firstWhere(
                        'supervisor_type',
                        'principal'
                    );

                $accordionId = 'student_' . $studentId;

            @endphp


            {{-- ================================================= --}}
            {{-- STUDENT ACCORDION ITEM --}}
            {{-- ================================================= --}}

            <div class="accordion-item student-accordion">


                {{-- ================================================= --}}
                {{-- HEADER --}}
                {{-- ================================================= --}}

                <h2
                    class="accordion-header"
                    id="heading_{{ $studentId }}"
                >

                    <button
                        class="accordion-button student-button {{ !$loop->first ? 'collapsed' : '' }}"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#{{ $accordionId }}"
                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="{{ $accordionId }}"
                    >


                        <div class="student-header">


                            {{-- AVATAR --}}

                            <div class="student-avatar">

                                <i class="bi bi-person-fill"></i>

                            </div>


                            {{-- STUDENT INFO --}}

                            <div class="student-info">

                                <div class="student-name">

                                    {{ $student->firstname }}
                                    {{ $student->middlename }}
                                    {{ $student->lastname }}

                                </div>


                                <div class="student-reg">

                                    Reg:
                                    {{ $student->reg_number }}

                                </div>

                            </div>


                            {{-- STATUS --}}

                            <div class="student-status">

                                @if(
                                    $studentGroup->where(
                                        'status',
                                        'active'
                                    )->count() == 2
                                )

                                    <span class="status-badge status-active">

                                        <i class="bi bi-check-circle me-1"></i>

                                       Click to view info

                                    </span>

                                @else

                                    <span class="status-badge status-inactive">

                                        <i class="bi bi-exclamation-circle me-1"></i>

                                        Incomplete

                                    </span>

                                @endif

                            </div>


                        </div>


                    </button>

                </h2>



                {{-- ================================================= --}}
                {{-- COLLAPSE BODY --}}
                {{-- ================================================= --}}

                <div
                    id="{{ $accordionId }}"
                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                    aria-labelledby="heading_{{ $studentId }}"
                    data-bs-parent="#studentAccordion"
                >


                    <div class="student-details">


                        {{-- ================================================= --}}
                        {{-- STUDENT DETAILS --}}
                        {{-- ================================================= --}}

                        <div class="detail-title">

                            <i class="bi bi-person-vcard me-1"></i>

                            Student Details

                        </div>


                        <div class="details-grid">


                            <div class="detail-box">

                                <div class="detail-label">
                                    Full Name
                                </div>

                                <div class="detail-value">

                                    {{ $student->firstname }}
                                    {{ $student->middlename }}
                                    {{ $student->lastname }}

                                </div>

                            </div>


                            <div class="detail-box">

                                <div class="detail-label">
                                    Registration Number
                                </div>

                                <div class="detail-value">

                                    {{ $student->reg_number }}

                                </div>

                            </div>


                            <div class="detail-box">

                                <div class="detail-label">
                                    Email
                                </div>

                                <div class="detail-value">

                                    {{ $student->email }}

                                </div>

                            </div>


                            <div class="detail-box">

                                <div class="detail-label">
                                    Phone
                                </div>

                                <div class="detail-value">

                                    {{ $student->phone }}

                                </div>

                            </div>


                            <div class="detail-box">

                                <div class="detail-label">
                                    Student Status
                                </div>

                                <div class="detail-value">

                                    @if($student->status === 'active')

                                        <span class="status-badge status-active">
                                            Active
                                        </span>

                                    @else

                                        <span class="status-badge status-inactive">
                                            {{ ucfirst($student->status) }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="detail-box">

                                <div class="detail-label">
                                    Supervisor Status
                                </div>

                                <div class="detail-value">

                                    @if($studentGroup->count() == 2)

                                        <span class="status-badge status-active">

                                            2 / 2 Assigned

                                        </span>

                                    @elseif($studentGroup->count() == 1)

                                        <span class="status-badge status-inactive">

                                            1 / 2 Assigned

                                        </span>

                                    @else

                                        <span class="status-badge status-inactive">

                                            0 / 2 Assigned

                                        </span>

                                    @endif

                                </div>

                            </div>


                        </div>



                        {{-- ================================================= --}}
                        {{-- SUPERVISORS --}}
                        {{-- ================================================= --}}

                        <div class="supervisors-title">

                            <i class="bi bi-people-fill me-1"></i>

                            Assigned Supervisors

                        </div>


                        <div class="supervisor-grid">

                            {{-- ================================================= --}}
                            {{-- PRINCIPAL SUPERVISOR --}}
                            {{-- ================================================= --}}

                            <div class="supervisor-card principal">


                                <div class="supervisor-top">


                                    <div class="supervisor-person">


                                        <div class="supervisor-avatar">

                                            <i class="bi bi-person-badge"></i>

                                        </div>


                                        <div>

                                            @if($principalSupervisor)

                                                <div class="supervisor-name">

                                                    {{ $principalSupervisor->supervisor->firstname }}
                                                    {{ $principalSupervisor->supervisor->middlename }}
                                                    {{ $principalSupervisor->supervisor->lastname }}

                                                </div>

                                                <div class="supervisor-role">

                                                    Principal Supervisor

                                                </div>

                                            @else

                                                <div class="supervisor-name text-muted">

                                                    Not Assigned

                                                </div>

                                                <div class="supervisor-role">

                                                    Principal Supervisor

                                                </div>

                                            @endif

                                        </div>

                                    </div>


                                   <div class="supervisor-actions">

                            <span class="principal-badge">
                                PRINCIPAL
                            </span>

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-primary edit-supervisor-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editSupervisorModal"
                                data-type="principal"
                                data-assignment="{{ $principalSupervisor?->id }}"
                                data-current="{{ $principalSupervisor?->teacher_id }}"
                            >
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </button>

                        </div>


                                </div>


                                @if($principalSupervisor)

                                    <div class="supervisor-details">


                                        <div class="supervisor-detail">

                                            <i class="bi bi-envelope"></i>

                                            <span>

                                                {{ $principalSupervisor->supervisor->email }}

                                            </span>

                                        </div>


                                        <div class="supervisor-detail">

                                            <i class="bi bi-telephone"></i>

                                            <span>

                                                {{ $principalSupervisor->supervisor->phone }}

                                            </span>

                                        </div>


                                        <div class="supervisor-detail">

                                            <i class="bi bi-person-badge"></i>

                                            <span>

                                                {{ ucfirst($principalSupervisor->supervisor->role) }}

                                            </span>

                                        </div>


                                        <div class="supervisor-detail">

                                            <i class="bi bi-check-circle"></i>

                                            <span>

                                                Status:
                                                {{ ucfirst($principalSupervisor->status) }}

                                            </span>

                                        </div>
                                         <div class="supervisor-detail">
                                             Created date: {{ $principalSupervisor->updated_at->format('m-d-Y') }}
                                            
                                         </div>


                                    </div>

                                @endif


                            </div>
                            {{-- ================================================= --}}
                            {{-- CORE SUPERVISOR --}}
                            {{-- ================================================= --}}

                            <div class="supervisor-card core">


                                <div class="supervisor-top">


                                    <div class="supervisor-person">


                                        <div class="supervisor-avatar">

                                            <i class="bi bi-person-workspace"></i>

                                        </div>


                                        <div>

                                            @if($coreSupervisor)

                                                <div class="supervisor-name">

                                                    {{ $coreSupervisor->supervisor->firstname }}
                                                    {{ $coreSupervisor->supervisor->middlename }}
                                                    {{ $coreSupervisor->supervisor->lastname }}

                                                </div>

                                                <div class="supervisor-role">

                                                    Co-Supervisor

                                                </div>

                                            @else

                                                <div class="supervisor-name text-muted">

                                                    Not Assigned

                                                </div>

                                                <div class="supervisor-role">

                                                    Co-Supervisor

                                                </div>
                                              

                                            @endif

                                        </div>

                                    </div>


                                    <div class="supervisor-actions">

    <span class="core-badge">
        Co-Supervisor
    </span>

    <button
        type="button"
        class="btn btn-sm btn-outline-primary edit-supervisor-btn"
        data-bs-toggle="modal"
        data-bs-target="#editSupervisorModal"
        data-type="core"
        data-assignment="{{ $coreSupervisor?->id }}"
        data-current="{{ $coreSupervisor?->teacher_id }}"
    >
        <i class="bi bi-pencil-square"></i>
        Edit
    </button>

</div>


                                </div>


                                @if($coreSupervisor)

                                    <div class="supervisor-details">


                                        <div class="supervisor-detail">

                                            <i class="bi bi-envelope"></i>

                                            <span>

                                                {{ $coreSupervisor->supervisor->email }}

                                            </span>

                                        </div>


                                        <div class="supervisor-detail">

                                            <i class="bi bi-telephone"></i>

                                            <span>

                                                {{ $coreSupervisor->supervisor->phone }}

                                            </span>

                                        </div>


                                        <div class="supervisor-detail">

                                            <i class="bi bi-person-badge"></i>

                                            <span>

                                                {{ ucfirst($coreSupervisor->supervisor->role) }}

                                            </span>

                                        </div>

                                        <!-- ========================================================= -->
<!-- EDIT SUPERVISOR MODAL -->
<!-- ========================================================= -->

<div
    class="modal fade"
    id="editSupervisorModal"
    tabindex="-1"
    aria-labelledby="editSupervisorModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                method="POST"
                id="editSupervisorForm"
                action="{{ route('admin.supervisor.update', $student->id) }}"
            >

                @csrf
                @method('PUT')

                <!-- HEADER -->
                <div class="modal-header">

                    <div>
                        <h5 class="modal-title" id="editSupervisorModalLabel">
                            Edit Supervisor
                        </h5>

                        <small class="text-muted">
                            Change the assigned supervisor
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <!-- BODY -->
                <div class="modal-body">

                    <!-- Supervisor Type -->
                    <div class="mb-3">

                        <label class="form-label">
                            Supervisor Type
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="supervisorTypeDisplay"
                            readonly
                        >

                        <input
                            type="hidden"
                            name="supervisor_type"
                            id="supervisorType"
                        >

                    </div>


                    <!-- Supervisor -->
                    <div class="mb-3">

                        <label
                            for="supervisor_id"
                            class="form-label"
                        >
                            Select Supervisor
                        </label>

                        <select
                            name="supervisor_id"
                            id="supervisor_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Select Supervisor --
                            </option>

                            @foreach($teachers as $supervisor)

                                <option
                                    value="{{ $supervisor->id }}"
                                >
                                    {{ $supervisor->firstname }}
                                    {{ $supervisor->middlename }}
                                    {{ $supervisor->lastname }}
                                    — {{ $supervisor->email }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-circle me-1"></i>
                        Update Supervisor
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>


                                        <div class="supervisor-detail">

                                            <i class="bi bi-check-circle"></i>

                                            <span>

                                                Status:
                                                {{ ucfirst($coreSupervisor->status) }}

                                            </span>
                                              

                                        </div>
                                         <div class="supervisor-detail">
                                             Created date: {{ $coreSupervisor->updated_at->format('m-d-Y') }}
                                            
                                         </div>


                                    </div>

                                @endif


                            </div>



                            


                        </div>



                        {{-- ================================================= --}}
                        {{-- ACTIONS --}}
                        {{-- ================================================= --}}

                        <div class="action-area">


                            <a
                                href="{{ route(
                                    'admin.research.details',
                                    $student->id
                                ) }}"
                                class="action-btn action-view"
                            >

                                <i class="bi bi-eye"></i>

                                View Student Research

                            </a>


                        </div>


                    </div>

                </div>

            </div>


        @endforeach


    </div>


@else


    {{-- ================================================= --}}
    {{-- EMPTY STATE --}}
    {{-- ================================================= --}}

    <div class="empty-state">

        <i class="bi bi-people"></i>

        <h5 class="mt-3">

            No Students Assigned

        </h5>

        <p>

            No student has been assigned to supervisors yet.

        </p>


        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#assignStudentModal"
        >

            <i class="bi bi-person-plus-fill me-1"></i>

            Assign Supervisors

        </button>

    </div>

@endif


</div>

{{-- ========================================================= --}}
{{-- ASSIGN SUPERVISORS MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="assignStudentModal"
    tabindex="-1"
    aria-hidden="true"
>
<div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">


        {{-- MODAL HEADER --}}

        <div class="modal-header bg-primary text-white">

            <h5 class="modal-title">

                <i class="bi bi-person-plus-fill me-2"></i>

                Assign Student Supervisors

            </h5>


            <button
                type="button"
                class="btn-close btn-close-white"
                data-bs-dismiss="modal"
            ></button>

        </div>



        {{-- FORM --}}

        <form
            action="{{ route('supervisor.assignments.store') }}"
            method="POST"
        >

            @csrf


            <div class="modal-body">


                {{-- INFORMATION --}}

                <div class="info-box">

                    <i class="bi bi-info-circle me-1"></i>

                    Each student must have exactly two supervisors:
                    <strong>one Co-Supervisor</strong>
                    and
                    <strong>one Principal Supervisor</strong>.

                </div>



                {{-- STUDENT --}}

                <div class="mb-3">

                    <label class="form-label">

                        Select Student

                    </label>


                    <select
                        name="student_id"
                        class="form-select"
                        required
                        {{ $students->isEmpty() ? 'disabled' : '' }}
                    >

                        <option value="">

                            Select Student

                        </option>


                        @foreach($students as $student)

                            <option
                                value="{{ $student->id }}"
                                {{ old('student_id') == $student->id ? 'selected' : '' }}
                            >

                                {{ $student->firstname }}
                                {{ $student->middlename }}
                                {{ $student->lastname }}

                                —
                                {{ $student->reg_number }}

                            </option>

                        @endforeach

                    </select>


                    @if($students->isEmpty())

                        <small class="text-danger">

                            All students already have supervisors.

                        </small>

                    @endif

                </div>

                {{-- PRINCIPAL SUPERVISOR --}}

                <div class="mb-3">

                    <label class="form-label">

                        Principal Supervisor

                    </label>


                    <select
                        name="principal_teacher_id"
                        class="form-select"
                        required
                    >

                        <option value="">

                            Select Principal Supervisor

                        </option>


                        @foreach($teachers as $teacher)

                            <option
                                value="{{ $teacher->id }}"
                                {{ old('principal_teacher_id') == $teacher->id ? 'selected' : '' }}
                            >

                                {{ $teacher->firstname }}
                                {{ $teacher->middlename }}
                                {{ $teacher->lastname }}

                            </option>

                        @endforeach

                    </select>


                    <small class="text-muted">

                        Co-Supervisor and Principal Supervisors must be different.

                    </small>

                </div>

                


                {{-- CORE SUPERVISOR --}}

                <div class="mb-3">

                    <label class="form-label">

                        Co-Supervisor

                    </label>


                    <select
                        name="core_teacher_id"
                        class="form-select"
                        required
                    >

                        <option value="">

                            Select Co-Supervisor

                        </option>


                        @foreach($teachers as $teacher)

                            <option
                                value="{{ $teacher->id }}"
                                {{ old('core_teacher_id') == $teacher->id ? 'selected' : '' }}
                            >

                                {{ $teacher->firstname }}
                                {{ $teacher->middlename }}
                                {{ $teacher->lastname }}

                            </option>

                        @endforeach

                    </select>

                </div>





            </div>



            {{-- MODAL FOOTER --}}

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >

                    Cancel

                </button>


                <button
                    type="submit"
                    class="btn btn-primary"
                    {{ $students->isEmpty() ? 'disabled' : '' }}
                >

                    <i class="bi bi-check-lg me-1"></i>

                    Assign Supervisors

                </button>

            </div>


        </form>

    </div>

</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const editButtons = document.querySelectorAll('.edit-supervisor-btn');

    const supervisorType = document.getElementById('supervisorType');

    const supervisorTypeDisplay =
        document.getElementById('supervisorTypeDisplay');

    const supervisorSelect =
        document.getElementById('supervisor_id');


    editButtons.forEach(button => {

        button.addEventListener('click', function () {

            const type = this.dataset.type;
            const currentSupervisor = this.dataset.current;

            // Set hidden supervisor type
            supervisorType.value = type;

            // Display supervisor type
            if (type === 'principal') {

                supervisorTypeDisplay.value =
                    'Principal Supervisor';

            } else {

                supervisorTypeDisplay.value =
                    'Co-Supervisor';

            }


            // Select current supervisor
            supervisorSelect.value =
                currentSupervisor || '';

        });

    });

});
</script>
<style>

.supervisor-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.supervisor-actions .btn {
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 10px;
}

.supervisor-actions .btn i {
    margin-right: 3px;
}

</style>
{{-- ========================================================= --}}
{{-- SWEET ALERT --}}
{{-- ========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Success!',

    text: @json(session('success')),

    confirmButtonText: 'OK',

    confirmButtonColor: '#2563eb'

});

</script>

@endif

@if($errors->any())

<script>

Swal.fire({

    icon: 'error',

    title: 'Assignment Error',

    text: @json($errors->first()),

    confirmButtonText: 'OK',

    confirmButtonColor: '#dc2626'

});

</script>

@endif

@endsection
