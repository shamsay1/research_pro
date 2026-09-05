@extends('layout.app')

@section('content')

<style>

/* =========================================================
   CONTAINER
========================================================= */

.supervisor-container{
    max-width:1100px;
    margin:auto;
}


/* =========================================================
   HEADER
========================================================= */

.supervisor-header{
    margin-bottom:25px;
}

.supervisor-header h4{
    margin:0;
    font-size:25px;
    font-weight:700;
    color:#0f172a;
}

.supervisor-header p{
    margin-top:6px;
    color:#64748b;
    font-size:14px;
}


/* =========================================================
   STUDENT INFO
========================================================= */

.student-info-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:15px;
    padding:20px;
    margin-bottom:25px;
    box-shadow:0 3px 15px rgba(0,0,0,.05);
}

.student-info{
    display:flex;
    align-items:center;
    gap:15px;
}

.student-avatar{
    width:55px;
    height:55px;
    border-radius:50%;
    background:#2563eb;
    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:20px;
    font-weight:700;
}

.student-name{
    font-size:17px;
    font-weight:700;
    color:#0f172a;
}

.student-reg{
    color:#64748b;
    font-size:13px;
    margin-top:3px;
}


/* =========================================================
   GRID
========================================================= */

.supervisor-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:22px;
}


/* =========================================================
   CARD
========================================================= */

.supervisor-card{
    background:#fff;
    border-radius:16px;
    padding:25px;

    border:1px solid #e2e8f0;

    box-shadow:0 4px 18px rgba(0,0,0,.06);
}


/* =========================================================
   CARD HEADER
========================================================= */

.supervisor-card-header{
    display:flex;
    align-items:center;
    gap:13px;

    padding-bottom:18px;
    margin-bottom:20px;

    border-bottom:1px solid #e2e8f0;
}

.supervisor-icon{
    width:48px;
    height:48px;

    border-radius:12px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:22px;
}

.core-icon{
    background:#dbeafe;
    color:#2563eb;
}

.principal-icon{
    background:#fef3c7;
    color:#d97706;
}

.supervisor-card-header h5{
    margin:0;
    font-size:17px;
    font-weight:700;
    color:#0f172a;
}

.supervisor-card-header p{
    margin:3px 0 0;
    color:#64748b;
    font-size:12px;
}


/* =========================================================
   PROFILE
========================================================= */

.supervisor-profile{
    text-align:center;
    margin-bottom:20px;
}

.supervisor-avatar{
    width:80px;
    height:80px;

    margin:auto;

    border-radius:50%;

    background:#f1f5f9;
    color:#334155;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:28px;
    font-weight:700;
}

.supervisor-name{
    margin-top:12px;

    font-size:19px;
    font-weight:700;

    color:#0f172a;
}


/* =========================================================
   BADGE
========================================================= */

.supervisor-badge{
    display:inline-block;

    margin-top:7px;

    padding:5px 12px;

    border-radius:20px;

    font-size:11px;
    font-weight:700;
}

.core-badge{
    background:#dbeafe;
    color:#1d4ed8;
}

.principal-badge{
    background:#fef3c7;
    color:#b45309;
}


/* =========================================================
   DETAILS
========================================================= */

.supervisor-details{
    display:flex;
    flex-direction:column;
    gap:13px;
}

.detail-row{
    display:flex;

    justify-content:space-between;
    align-items:center;

    gap:15px;

    padding-bottom:12px;

    border-bottom:1px solid #f1f5f9;
}

.detail-row:last-child{
    border-bottom:none;
}

.detail-label{
    color:#64748b;
    font-size:13px;
}

.detail-value{
    color:#0f172a;
    font-size:13px;
    font-weight:600;

    text-align:right;

    word-break:break-word;
}


/* =========================================================
   STATUS
========================================================= */

.status-active{
    display:inline-flex;
    align-items:center;
    gap:5px;

    padding:4px 10px;

    border-radius:20px;

    background:#dcfce7;
    color:#15803d;

    font-size:11px;
    font-weight:700;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-supervisor{
    text-align:center;

    padding:35px 20px;

    color:#64748b;
}

.empty-supervisor i{
    font-size:40px;
    color:#cbd5e1;

    display:block;

    margin-bottom:10px;
}

.empty-supervisor h6{
    color:#334155;
    font-weight:700;
    margin-bottom:5px;
}

.empty-supervisor p{
    margin:0;
    font-size:13px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:768px){

    .supervisor-grid{
        grid-template-columns:1fr;
    }

    .detail-row{
        align-items:flex-start;
        flex-direction:column;
        gap:4px;
    }

    .detail-value{
        text-align:left;
    }

}

</style>


<div class="supervisor-container">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="supervisor-header">

        <h4>
            My Supervisors
        </h4>

        <p>
            View your assigned CO/Supervisor and Principal Supervisor.
        </p>

    </div>



    {{-- =====================================================
         STUDENT INFORMATION
    ====================================================== --}}

    @php

        $studentName = trim(
            ($student->firstname ?? '') . ' ' .
            ($student->middlename ?? '') . ' ' .
            ($student->lastname ?? '')
        );

        $studentWords = preg_split(
            '/\s+/',
            $studentName
        );

        $studentInitials = '';

        foreach(array_slice($studentWords, 0, 2) as $word){

            if(!empty($word)){

                $studentInitials .= strtoupper(
                    substr($word, 0, 1)
                );

            }

        }

    @endphp


    <div class="student-info-card">

        <div class="student-info">

            <div class="student-avatar">
                {{ $studentInitials ?: 'S' }}
            </div>

            <div>

                <div class="student-name">
                    {{ $studentName }}
                </div>

                <div class="student-reg">

                    Registration Number:
                    <strong>
                        {{ $student->reg_number ?? 'N/A' }}
                    </strong>

                </div>

            </div>

        </div>

    </div>



    {{-- =====================================================
         SUPERVISORS
    ====================================================== --}}

    <div class="supervisor-grid">


        {{-- =================================================
             CORE SUPERVISOR
        ================================================== --}}

        <div class="supervisor-card">

            <div class="supervisor-card-header">

                <div class="supervisor-icon core-icon">

                    <i class="bi bi-person-workspace"></i>

                </div>

                <div>

                    <h5>
                        CO/Supervisor
                    </h5>

                    <p>
                        Your main research supervisor
                    </p>

                </div>

            </div>


            @if($coreSupervisor && $coreSupervisor->supervisor)

                @php

                    $supervisor =
                        $coreSupervisor->supervisor;

                    $name = trim(
                        ($supervisor->firstname ?? '') . ' ' .
                        ($supervisor->middlename ?? '') . ' ' .
                        ($supervisor->lastname ?? '')
                    );

                    $words = preg_split(
                        '/\s+/',
                        $name
                    );

                    $initials = '';

                    foreach(array_slice($words, 0, 2) as $word){

                        if(!empty($word)){

                            $initials .= strtoupper(
                                substr($word, 0, 1)
                            );

                        }

                    }

                @endphp


                {{-- PROFILE --}}

                <div class="supervisor-profile">

                    <div class="supervisor-avatar">
                        {{ $initials ?: 'S' }}
                    </div>

                    <div class="supervisor-name">
                        {{ $name }}
                    </div>

                    <span class="supervisor-badge core-badge">

                        <i class="bi bi-check-circle me-1"></i>

                        Core Supervisor

                    </span>

                </div>


                {{-- DETAILS --}}

                <div class="supervisor-details">


                    <div class="detail-row">

                        <span class="detail-label">
                            Full Name
                        </span>

                        <span class="detail-value">
                            {{ $name }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Email
                        </span>

                        <span class="detail-value">
                            {{ $supervisor->email ?? 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Phone
                        </span>

                        <span class="detail-value">
                            {{ $supervisor->phone ?? 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Role
                        </span>

                        <span class="detail-value">
                            {{ $supervisor->role ?? 'Supervisor' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Assignment Status
                        </span>

                        <span class="detail-value">

                            <span class="status-active">

                                <i class="bi bi-circle-fill"
                                   style="font-size:7px;">
                                </i>

                                {{ ucfirst($coreSupervisor->status) }}

                            </span>

                        </span>

                    </div>


                </div>


            @else

                <div class="empty-supervisor">

                    <i class="bi bi-person-x"></i>

                    <h6>
                        No Core Supervisor Assigned
                    </h6>

                    <p>
                        You currently do not have a Core Supervisor.
                    </p>

                </div>

            @endif

        </div>



        {{-- =================================================
             PRINCIPAL SUPERVISOR
        ================================================== --}}

        <div class="supervisor-card">

            <div class="supervisor-card-header">

                <div class="supervisor-icon principal-icon">

                    <i class="bi bi-person-badge"></i>

                </div>

                <div>

                    <h5>
                        Principal Supervisor
                    </h5>

                    <p>
                        Your principal research supervisor
                    </p>

                </div>

            </div>


            @if($principalSupervisor && $principalSupervisor->supervisor)

                @php

                    $supervisor =
                        $principalSupervisor->supervisor;

                    $name = trim(
                        ($supervisor->firstname ?? '') . ' ' .
                        ($supervisor->middlename ?? '') . ' ' .
                        ($supervisor->lastname ?? '')
                    );

                    $words = preg_split(
                        '/\s+/',
                        $name
                    );

                    $initials = '';

                    foreach(array_slice($words, 0, 2) as $word){

                        if(!empty($word)){

                            $initials .= strtoupper(
                                substr($word, 0, 1)
                            );

                        }

                    }

                @endphp


                {{-- PROFILE --}}

                <div class="supervisor-profile">

                    <div class="supervisor-avatar">
                        {{ $initials ?: 'P' }}
                    </div>

                    <div class="supervisor-name">
                        {{ $name }}
                    </div>

                    <span class="supervisor-badge principal-badge">

                        <i class="bi bi-check-circle me-1"></i>

                        Principal Supervisor

                    </span>

                </div>


                {{-- DETAILS --}}

                <div class="supervisor-details">


                    <div class="detail-row">

                        <span class="detail-label">
                            Full Name
                        </span>

                        <span class="detail-value">
                            {{ $name }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Email
                        </span>

                        <span class="detail-value">
                            {{ $supervisor->email ?? 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Phone
                        </span>

                        <span class="detail-value">
                            {{ $supervisor->phone ?? 'Not provided' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Role
                        </span>

                        <span class="detail-value">
                            {{ $supervisor->role ?? 'Supervisor' }}
                        </span>

                    </div>


                    <div class="detail-row">

                        <span class="detail-label">
                            Assignment Status
                        </span>

                        <span class="detail-value">

                            <span class="status-active">

                                <i class="bi bi-circle-fill"
                                   style="font-size:7px;">
                                </i>

                                {{ ucfirst($principalSupervisor->status) }}

                            </span>

                        </span>

                    </div>


                </div>


            @else

                <div class="empty-supervisor">

                    <i class="bi bi-person-x"></i>

                    <h6>
                        No Principal Supervisor Assigned
                    </h6>

                    <p>
                        You currently do not have a Principal Supervisor.
                    </p>

                </div>

            @endif

        </div>


    </div>

</div>

@endsection