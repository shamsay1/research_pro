@extends('layout.app')

@section('content')

{{-- =========================================================
     TIME DIFFERENCE HELPER
========================================================= --}}

@php

function timeDifference($from, $to)
{
    if (!$from || !$to) {
        return 'N/A';
    }

    $from = \Carbon\Carbon::parse($from);
    $to   = \Carbon\Carbon::parse($to);

    $diff = $from->diff($to);

    $parts = [];

    /*
    |--------------------------------------------------------------------------
    | DAYS
    |--------------------------------------------------------------------------
    */

    if ($diff->d > 0) {

        $parts[] = $diff->d . ' ' .
            ($diff->d == 1 ? 'Day' : 'Days');

    }

    /*
    |--------------------------------------------------------------------------
    | HOURS
    |--------------------------------------------------------------------------
    */

    if ($diff->h > 0) {

        $parts[] = $diff->h . ' ' .
            ($diff->h == 1 ? 'Hour' : 'Hours');

    }

    /*
    |--------------------------------------------------------------------------
    | MINUTES
    |--------------------------------------------------------------------------
    */

    if ($diff->i > 0) {

        $parts[] = $diff->i . ' ' .
            ($diff->i == 1 ? 'Minute' : 'Minutes');

    }

    /*
    |--------------------------------------------------------------------------
    | LESS THAN ONE MINUTE
    |--------------------------------------------------------------------------
    */

    if (empty($parts)) {

        return 'Less than 1 Minute';

    }

    return implode(' ', $parts);
}

@endphp


<style>

/* =========================================================
   MAIN CONTAINER
========================================================= */

.report-container{

    max-width:1200px;

    margin:auto;

}


/* =========================================================
   HEADER
========================================================= */

.header{

    margin-bottom:25px;

}

.header h3{

    font-weight:700;

    color:#0f172a;

}

.header p{

    margin-top:5px;

}


/* =========================================================
   STATISTICS
========================================================= */

.stats{

    display:grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:15px;

    margin-bottom:20px;

}

.stat{

    background:#fff;

    border-radius:12px;

    padding:18px;

    border:1px solid #e5e7eb;

    box-shadow:
        0 3px 12px rgba(0,0,0,.04);

}

.stat h6{

    color:#64748b;

    font-size:13px;

    margin-bottom:5px;

}

.stat h2{

    font-weight:700;

    color:#0f172a;

}


/* =========================================================
   SEARCH
========================================================= */

.search-box{

    background:white;

    padding:15px;

    border-radius:10px;

    margin-bottom:20px;

    border:1px solid #e5e7eb;

}


/* =========================================================
   STUDENT ACCORDION
========================================================= */

.student-accordion{

    margin-bottom:15px;

    border-radius:10px;

    overflow:hidden;

    border:1px solid #e2e8f0;

}

.accordion-button{

    font-weight:600;

}

.accordion-button:not(.collapsed){

    background:#f8fafc;

    color:#0f172a;

}

.student-name-header{

    font-weight:700;

    color:#0f172a;

}

.student-reg{

    font-size:12px;

    color:#64748b;

    margin-top:3px;

}


/* =========================================================
   STUDENT INFORMATION
========================================================= */

.student-info{

    background:#f8fafc;

    border-radius:10px;

    padding:18px;

    margin-bottom:20px;

}

.info-grid{

    display:grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:15px;

}

.info-card{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:8px;

    padding:12px;

}

.label{

    font-size:11px;

    color:#64748b;

    margin-bottom:4px;

}

.value{

    font-weight:600;

    font-size:14px;

    color:#1e293b;

}


/* =========================================================
   RESEARCH BOX
========================================================= */

.research-box{

    border:1px solid #e5e7eb;

    border-radius:12px;

    margin-bottom:20px;

    overflow:hidden;

    background:white;

}

.research-header{

    background:#f8fafc;

    padding:15px;

    border-bottom:1px solid #e5e7eb;

}

.research-title{

    font-size:16px;

    font-weight:700;

    color:#0f172a;

}


/* =========================================================
   DATE AND TIME
========================================================= */

.date-time{

    font-weight:700 !important;

    color:#1e293b !important;

}


/* =========================================================
   RESPONSE TIME
========================================================= */

.response-time{

    margin-top:10px;

    padding:8px 10px;

    background:#eff6ff;

    border-left:3px solid #2563eb;

    border-radius:5px;

    color:#1d4ed8;

    font-size:12px;

}

.response-time strong{

    font-weight:700;

}


/* =========================================================
   TIMELINE
========================================================= */

.timeline{

    position:relative;

    padding-left:30px;

    margin-top:20px;

}

.timeline:before{

    content:"";

    position:absolute;

    left:9px;

    top:0;

    bottom:0;

    width:2px;

    background:#d1d5db;

}

.timeline-item{

    position:relative;

    margin-bottom:25px;

}

.timeline-item:last-child{

    margin-bottom:0;

}


/* =========================================================
   TIMELINE DOT
========================================================= */

.dot{

    position:absolute;

    left:-30px;

    top:5px;

    width:16px;

    height:16px;

    border-radius:50%;

    background:#2563eb;

    border:3px solid #dbeafe;

}

.dot.supervisor{

    background:#f59e0b;

    border-color:#fde68a;

}

.dot.status{

    background:#22c55e;

    border-color:#bbf7d0;

}


/* =========================================================
   TIMELINE CONTENT
========================================================= */

.timeline-content{

    background:#f8fafc;

    border-radius:8px;

    padding:14px;

    border:1px solid #e5e7eb;

}

.timeline-action{

    font-weight:700;

    font-size:14px;

    color:#1e293b;

}

.timeline-by{

    font-size:12px;

    color:#64748b;

    margin-top:5px;

}


/* =========================================================
   COMMENT
========================================================= */

.comment{

    background:white;

    padding:10px;

    margin-top:10px;

    border-left:3px solid #f59e0b;

    border-radius:5px;

    line-height:1.5;

    font-size:13px;

}

.comment strong{

    font-weight:700;

}


/* =========================================================
   STATUS
========================================================= */

.status{

    padding:5px 10px;

    border-radius:20px;

    font-size:11px;

    font-weight:700;

    display:inline-block;

}

.pending{

    background:#dbeafe;

    color:#1d4ed8;

}

.correction{

    background:#fef3c7;

    color:#92400e;

}

.approved{

    background:#dcfce7;

    color:#166534;

}

.rejected{

    background:#fee2e2;

    color:#991b1b;

}


/* =========================================================
   DOCUMENT BUTTONS
========================================================= */

.document-btn{

    margin-top:8px;

}

.correction-document{

    margin-top:8px;

}


/* =========================================================
   EMPTY
========================================================= */

.empty-report{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:12px;

    padding:60px 20px;

    text-align:center;

    color:#64748b;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:900px){

    .stats{

        grid-template-columns:
            repeat(2,1fr);

    }

    .info-grid{

        grid-template-columns:1fr;

    }

}


@media(max-width:600px){

    .stats{

        grid-template-columns:1fr;

    }

    .research-header{

        flex-direction:column;

        gap:10px;

    }

}

</style>



<div class="report-container">


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="header">

    <h3>

        <i class="bi bi-journal-bookmark-fill me-2"></i>

        Research Process Report

    </h3>

    <p class="text-muted">

        Student and Supervisor Complete Research History

    </p>

</div>



{{-- =========================================================
     STATISTICS
========================================================= --}}

<div class="stats">


<div class="stat">

    <h6>
        Total Research
    </h6>

    <h2>
        {{ $totalResearch }}
    </h2>

</div>


<div class="stat">

    <h6>
        Pending
    </h6>

    <h2>
        {{ $pendingResearch }}
    </h2>

</div>


<div class="stat">

    <h6>
        Correction
    </h6>

    <h2>
        {{ $correctionResearch }}
    </h2>

</div>


<div class="stat">

    <h6>
        Approved
    </h6>

    <h2>
        {{ $approvedResearch }}
    </h2>

</div>


</div>



{{-- =========================================================
     SEARCH
========================================================= --}}

<div class="search-box">

<form
    method="GET"
    action="{{ route('admin.research.report') }}"
>

<div class="input-group">


<input
    type="text"
    name="search"
    value="{{ $search }}"
    class="form-control"
    placeholder="Search student, registration number or research title"
>


<button
    type="submit"
    class="btn btn-primary"
>

    <i class="bi bi-search me-1"></i>

    Search

</button>


@if($search)

<a
    href="{{ route('admin.research.report') }}"
    class="btn btn-secondary"
>

    Clear

</a>

@endif


</div>

</form>

</div>



{{-- =========================================================
     STUDENTS ACCORDION
========================================================= --}}

@if($groupedResearches->count())


<div
    class="accordion"
    id="studentAccordion"
>


@foreach(
    $groupedResearches
    as $studentId => $studentResearches
)


@php

    /*
    |--------------------------------------------------------------------------
    | Student
    |--------------------------------------------------------------------------
    */

    $student =
        $studentResearches
        ->first()
        ->student;


    /*
    |--------------------------------------------------------------------------
    | Collect Supervisors
    |--------------------------------------------------------------------------
    */

    $supervisors =
        collect();


    foreach(
        $studentResearches
        as $research
    ){

        foreach(
            $research->corrections
            as $correction
        ){

            if(
                $correction->supervisor
            ){

                $supervisors->push(
                    $correction->supervisor
                );

            }

        }

    }


    $supervisors =
        $supervisors
        ->unique('id');

@endphp



<div
    class="accordion-item student-accordion"
>


{{-- =====================================================
     ACCORDION HEADER
===================================================== --}}

<h2
    class="accordion-header"
    id="heading{{ $studentId }}"
>


<button
    class="accordion-button collapsed"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#collapse{{ $studentId }}"
>


<div
    class="w-100 d-flex justify-content-between align-items-center me-3"
>


<div>


<div class="student-name-header">

@if($student)

    {{ $student->firstname }}

    {{ $student->middlename }}

    {{ $student->lastname }}

@else

    Unknown Student

@endif

</div>


<div class="student-reg">

    Registration Number :

    {{ $student->reg_number ?? 'N/A' }}

</div>


</div>


<div>

<div class="d-flex align-items-center gap-2">

    <span class="badge bg-primary">
        {{ $studentResearches->count() }}
        {{ $studentResearches->count() == 1 ? 'Times Research submission' : 'Times Researches submission' }}
    </span>

    <a
        href="{{ route('admin.research.student.print', $student->id) }}"
        target="_blank"
        class="btn btn-sm btn-success"
        onclick="event.stopPropagation();"
    >
        <i class="bi bi-eye"></i>
        View report
    </a>

</div>

</div>


</div>


</button>

</h2>



{{-- =====================================================
     ACCORDION BODY
===================================================== --}}

<div
    id="collapse{{ $studentId }}"
    class="accordion-collapse collapse"
    data-bs-parent="#studentAccordion"
>


<div class="accordion-body">
<div class="d-flex justify-content-end mb-4">

    <a
        href="{{ route('admin.research.student.print', $student->id) }}"
        target="_blank"
        class="btn btn-success"
    >
        <i class="bi bi-printer-fill me-1"></i>
        Print Student Research Summary
    </a>

</div>


{{-- =====================================================
     STUDENT INFORMATION
===================================================== --}}

<div class="student-info">


<h5 class="mb-3">

    <i class="bi bi-person-circle me-1"></i>

    Student Information

</h5>


<div class="info-grid">


<div class="info-card">

<div class="label">

    Full Name

</div>

<div class="value">

    {{ $student->firstname }}

    {{ $student->middlename }}

    {{ $student->lastname }}

</div>

</div>


<div class="info-card">

<div class="label">

    Registration Number

</div>

<div class="value">

    {{ $student->reg_number ?? 'N/A' }}

</div>

</div>


<div class="info-card">

<div class="label">

    Total Research

</div>

<div class="value">

    {{ $studentResearches->count() }}

</div>

</div>


</div>

</div>



{{-- =====================================================
     SUPERVISOR INFORMATION
===================================================== --}}

<div class="student-info">


<h5 class="mb-3">

    <i class="bi bi-person-badge me-1"></i>

    Supervisor Information

</h5>


@if($supervisors->count())


<div class="row">


@foreach(
    $supervisors
    as $supervisor
)


<div class="col-md-4 mb-3">


<div class="info-card">


<div class="label">

    <span>{{ $supervisor->supervisor_type }}</span>

</div>


<div class="value">

    {{ $supervisor->firstname }}

    {{ $supervisor->middlename }}

    {{ $supervisor->lastname }}
    

</div>


</div>


</div>


@endforeach


</div>


@else


<div class="alert alert-warning mb-0">

    <i class="bi bi-exclamation-triangle me-1"></i>

    No Supervisor Assigned Yet

</div>


@endif


</div>



{{-- =====================================================
     RESEARCH RECORDS
===================================================== --}}

@foreach(
    $studentResearches
    as $research
)


@php

    $status =
        strtolower(
            $research->status ?? 'pending'
        );

@endphp


<div class="research-box">



{{-- =====================================================
     RESEARCH HEADER
===================================================== --}}

<div
    class="research-header d-flex justify-content-between align-items-start"
>


<div>


<div class="research-title">

    {{ $research->title }}

</div>


<div class="small text-muted mt-1">

    Submitted :

    <strong class="date-time">

        {{ $research->created_at
            ? $research->created_at
                ->format('d M Y h:i A')
            : 'N/A'
        }}

    </strong>

</div>


</div>


<span
    class="status {{ $status }}"
>

    {{ ucfirst($status) }}

</span>


</div>



<div class="p-3">



{{-- =====================================================
     RESEARCH DOCUMENT
===================================================== --}}

<div class="mb-3">


<strong>

    <i class="bi bi-file-earmark-text me-1"></i>

    Research Document

</strong>


<br>


@if($research->document)


<a
    href="{{ asset($research->document) }}"
    target="_blank"
    class="btn btn-sm btn-outline-primary document-btn"
>

    <i class="bi bi-file-earmark-pdf me-1"></i>

    View Research

</a>


@else


<span class="text-muted">

    No Document

</span>


@endif


</div>



{{-- =====================================================
     TIMELINE TITLE
===================================================== --}}

<h6 class="mt-3">

    <i class="bi bi-clock-history me-1"></i>

    Complete Timeline

</h6>



<div class="timeline">



{{-- =====================================================
     STUDENT SUBMISSION
===================================================== --}}

<div class="timeline-item">


<div class="dot"></div>


<div class="timeline-content">


<div class="timeline-action">

    Research Submitted

</div>


<div class="timeline-by">

    <i class="bi bi-person me-1"></i>

    Student :

    {{ $student->firstname }}

    {{ $student->middlename }}

    {{ $student->lastname }}

</div>


<div class="small date-time mt-2">

    <i class="bi bi-calendar-event me-1"></i>

    {{ $research->created_at
        ? $research->created_at
            ->format('d M Y h:i A')
        : 'N/A'
    }}

</div>


</div>

</div>



{{-- =====================================================
     SUPERVISOR CORRECTIONS
===================================================== --}}

@foreach(
    $research->corrections
    ->sortBy('created_at')
    as $correction
)


@php

    /*
    |--------------------------------------------------------------------------
    | Find previous correction
    |--------------------------------------------------------------------------
    */

    $previousCorrection =

        $research->corrections
        ->filter(function($item) use ($correction){

            return $item->created_at
                && $correction->created_at
                && $item->created_at
                    ->lt(
                        $correction->created_at
                    );

        })
        ->sortByDesc('created_at')
        ->first();


    /*
    |--------------------------------------------------------------------------
    | Calculate response starting point
    |--------------------------------------------------------------------------
    */

    $responseFrom =

        $previousCorrection
            ? $previousCorrection->created_at
            : $research->created_at;


    /*
    |--------------------------------------------------------------------------
    | Response description
    |--------------------------------------------------------------------------
    */

    $responseLabel =

        $previousCorrection
            ? 'previous correction'
            : 'submission';

@endphp



<div class="timeline-item">


<div class="dot supervisor"></div>


<div class="timeline-content">


<div class="timeline-action">

    Supervisor Correction

</div>



{{-- SUPERVISOR --}}

<div class="timeline-by">

    <i class="bi bi-person-badge me-1"></i>

    Supervisor :

    @if($correction->supervisor)

        {{ $correction->supervisor->firstname }}

        {{ $correction->supervisor->middlename }}

        {{ $correction->supervisor->lastname }}

    @else

        Unknown Supervisor

    @endif

</div>



{{-- CORRECTION DATE --}}

<div class="small date-time mt-2">

    <i class="bi bi-calendar-event me-1"></i>

    {{ $correction->created_at
        ? $correction->created_at
            ->format('d M Y h:i A')
        : 'N/A'
    }}

</div>



{{-- =================================================
     RESPONSE TIME
================================================= --}}

@if(
    $responseFrom &&
    $correction->created_at
)

<div class="response-time">

    <i class="bi bi-hourglass-split me-1"></i>

    <strong>

        Supervisor responded

        {{ timeDifference(
            $responseFrom,
            $correction->created_at
        ) }}

        after {{ $responseLabel }}

    </strong>

</div>

@endif



{{-- =================================================
     CORRECTION COMMENT
================================================= --}}

@if($correction->comment)


<div class="comment">


<strong>

    <i class="bi bi-chat-left-text me-1"></i>

    Supervisor Comment

</strong>


<br>


{{ $correction->comment }}


</div>


@endif



{{-- =================================================
     CORRECTION DOCUMENT
================================================= --}}

@if($correction->documentary)


<a
    href="{{ asset($correction->documentary) }}"
    target="_blank"
    class="btn btn-sm btn-outline-warning correction-document"
>


<i class="bi bi-file-earmark-text me-1"></i>

View Correction Document


</a>


@endif


</div>

</div>


@endforeach



{{-- =====================================================
     CURRENT STATUS
===================================================== --}}

<div class="timeline-item">


<div class="dot status"></div>


<div class="timeline-content">


<div class="timeline-action">

    Current Research Status

</div>


<div class="mt-2">


<span
    class="status {{ $status }}"
>

    {{ ucfirst($status) }}

</span>


</div>


<div class="small date-time mt-2">

    <i class="bi bi-calendar-event me-1"></i>

    Last Updated :

    {{ $research->updated_at
        ? $research->updated_at
            ->format('d M Y h:i A')
        : 'N/A'
    }}

</div>


</div>

</div>



</div>


</div>

</div>


@endforeach


</div>

</div>

</div>


@endforeach


</div>



{{-- =====================================================
     PAGINATION
===================================================== --}}

<div class="mt-4">

    {{ $researches->links() }}

</div>


@else


{{-- =====================================================
     NO DATA
===================================================== --}}

<div class="empty-report">

    <i class="bi bi-file-earmark-x fs-1"></i>

    <h5 class="mt-3">

        No Research Found

    </h5>

    <p>

        There are no research records matching your search.

    </p>

</div>


@endif


</div>

@endsection