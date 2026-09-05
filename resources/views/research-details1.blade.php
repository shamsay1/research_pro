@extends('layout.app')

@section('content')

<style>

    .page-header {
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-bottom:20px;
    }

    .page-header h4 {
        margin:0;
        font-size:22px;
        font-weight:700;
        color:#0f172a;
    }

    .page-header p {
        margin:5px 0 0;
        font-size:16px;
        color:#64748b;
    }


    /*
    |--------------------------------------------------------------------------
    | BACK BUTTON
    |--------------------------------------------------------------------------
    */

    .btn-back {
        border:0;
        background:#f1f5f9;
        color:#334155;
        padding:9px 14px;
        border-radius:7px;
        font-size:16px;
        font-weight:600;
        text-decoration:none;
    }

    .btn-back:hover {
        background:#e2e8f0;
        color:#0f172a;
    }


    /*
    |--------------------------------------------------------------------------
    | INFORMATION CARDS
    |--------------------------------------------------------------------------
    */

    .info-card {
        background:#fff;
        border-radius:10px;
        padding:18px;
        box-shadow:0 2px 8px rgba(15,23,42,.05);
        height:100%;
    }

    .info-title {
        font-size:16px;
        font-weight:700;
        color:#0f172a;
        margin-bottom:14px;
    }

    .info-row {
        display:flex;
        justify-content:space-between;
        gap:20px;
        padding:9px 0;
        border-bottom:1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom:0;
    }

    .info-label {
        font-size:16px;
        color:#64748b;
    }

    .info-value {
        font-size:16px;
        font-weight:600;
        color:#334155;
        text-align:right;
    }


    /*
    |--------------------------------------------------------------------------
    | RESEARCH DOCUMENT
    |--------------------------------------------------------------------------
    */

    .document-box {
        background:#f8fafc;
        border:1px solid #e2e8f0;
        border-radius:8px;
        padding:12px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
    }

    .document-name {
        font-size:16px;
        font-weight:600;
        color:#334155;
        word-break:break-all;
    }

    .btn-document {
        background:#eff6ff;
        color:#2563eb;
        padding:7px 11px;
        border-radius:6px;
        text-decoration:none;
        font-size:12px;
        font-weight:600;
        white-space:nowrap;
    }

    .btn-document:hover {
        background:#dbeafe;
        color:#1d4ed8;
    }


    /*
    |--------------------------------------------------------------------------
    | TIMELINE
    |--------------------------------------------------------------------------
    */

    .timeline {
        position:relative;
        margin-top:10px;
        padding-left:30px;
    }

    .timeline::before {
        content:"";
        position:absolute;
        left:9px;
        top:5px;
        bottom:5px;
        width:2px;
        background:#e2e8f0;
    }

    .timeline-item {
        position:relative;
        padding-bottom:24px;
    }

    .timeline-item:last-child {
        padding-bottom:0;
    }

    .timeline-dot {
        position:absolute;
        left:-27px;
        top:2px;
        width:18px;
        height:18px;
        border-radius:50%;
        background:#eff6ff;
        border:4px solid #fff;
        box-shadow:0 0 0 1px #2563eb;
    }

    .timeline-title {
        font-size:16px;
        font-weight:700;
        color:#0f172a;
        margin-bottom:3px;
    }

    .timeline-date {
        font-size:16px;
        color:#64748b;
        margin-bottom:6px;
    }

    .timeline-text {
        font-size:16px;
        color:#475569;
        line-height:1.6;
        background:#f8fafc;
        border-radius:7px;
        padding:10px;
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    .status-badge {
        display:inline-block;
        padding:5px 10px;
        border-radius:20px;
        font-size:11px;
        font-weight:600;
    }

    .status-pending {
        background:#fef3c7;
        color:#b45309;
    }

    .status-progress {
        background:#dbeafe;
        color:#2563eb;
    }

    .status-correction {
        background:#fee2e2;
        color:#dc2626;
    }

    .status-resubmitted {
        background:#ede9fe;
        color:#7c3aed;
    }

    .status-completed {
        background:#dcfce7;
        color:#15803d;
    }


    @media(max-width:768px) {

        .page-header {
            flex-direction:column;
            align-items:stretch;
            gap:12px;
        }

        .btn-back {
            text-align:center;
        }

        .info-row {
            flex-direction:column;
            gap:3px;
        }

        .info-value {
            text-align:left;
        }

        .document-box {
            flex-direction:column;
            align-items:stretch;
        }

        .btn-document {
            text-align:center;
        }

    }

</style>


<!-- =========================================================
     HEADER
========================================================= -->

<div class="page-header">

    <div>

        <h4>
            Research Details
        </h4>

        <p>
            Complete research progress between student and supervisor
        </p>

    </div>


    <a
        href="{{ url()->previous() }}"
        class="btn-back"
    >

        <i class="bi bi-arrow-left me-1"></i>

        Back

    </a>
    <button
    type="button"
    class="btn btn-warning"
    data-bs-toggle="modal"
    data-bs-target="#addCorrectionModal"
>
    <i class="bi bi-chat-left-text me-1"></i>
    Add Comments
</button>
<div
    class="modal fade"
    id="addCorrectionModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-chat-left-text me-2"></i>
                    Add Research Comments
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="{{ route(
                    'admin.research.addCorrection',
                    $research->id
                ) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="modal-body">

                    {{-- RESEARCH TITLE --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Research Title
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $research->title }}"
                            readonly
                        >

                    </div>


                    {{-- COMMENT --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                         
                        </label>

                        <textarea
                            name="comment"
                            class="form-control"
                            rows="6"
                            placeholder="Write your correction comments here..."
                       
                        >{{ old('comment') }}</textarea>

                        @error('comment')

                            <small class="text-danger">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- DOCUMENT --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Correction Document
                         
                        </label>

                        <input
                            type="file"
                            name="attachment"
                            class="form-control"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                          
                        >

                        <small class="text-muted">
                            PDF, DOC, DOCX, JPG, JPEG or PNG.
                            Maximum size: 10MB.
                        </small>

                        @error('attachment')

                            <small class="text-danger d-block">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>


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

                        <i class="bi bi-send me-1"></i>

                        Send Correction

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</div>



<!-- =========================================================
     STUDENT + SUPERVISOR
========================================================= -->

<div class="row g-3 mb-3">


    <!-- STUDENT -->

    <div class="col-lg-6">

        <div class="info-card">

            <div class="info-title">

                <i class="bi bi-person-fill me-1"></i>

                Student Information

            </div>


            <div class="info-row">

                <span class="info-label">
                    Full Name
                </span>

                <span class="info-value">

                    {{ $student->firstname }}

                    {{ $student->middlename }}

                    {{ $student->lastname }}

                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Registration Number
                </span>

                <span class="info-value">

                    {{ $student->reg_number }}

                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Student Status
                </span>

                <span class="info-value">

                    {{ ucfirst($student->status) }}

                </span>

            </div>

        </div>

    </div>



    <!-- SUPERVISOR -->

    <div class="col-lg-6">

        <div class="info-card">

            <div class="info-title">

                <i class="bi bi-person-workspace me-1"></i>

                Supervisor Information

            </div>


            <div class="info-row">

                <span class="info-label">
                    Full Name
                </span>

                <span class="info-value">

                    {{ $assignment->supervisor->firstname }}

                    {{ $assignment->supervisor->middlename }}

                    {{ $assignment->supervisor->lastname }}

                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Role
                </span>

                <span class="info-value">
                    Supervisor
                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Assignment Status
                </span>

                <span class="info-value">

                    {{ ucfirst($assignment->status) }}

                </span>

            </div>

        </div>

    </div>

</div>



<!-- =========================================================
     RESEARCH INFORMATION
========================================================= -->

<div class="info-card mb-3">

<div class="info-title">

    <i class="bi bi-journal-text me-1"></i>

    Research Information

</div>


{{-- ========================================================= --}}
{{-- RESEARCH TITLE --}}
{{-- ========================================================= --}}

<div class="info-row">

    <span class="info-label">
        Research Title
    </span>

    <span class="info-value">

        {{ $research->title }}

    </span>

</div>


{{-- ========================================================= --}}
{{-- CURRENT STATUS --}}
{{-- ========================================================= --}}

<div class="info-row">

    <span class="info-label">
        Current Status
    </span>

    <span class="info-value">

        @if($research->status === 'pending')

            <span class="status-badge status-pending">
                Pending
            </span>

        @elseif($research->status === 'in_progress')

            <span class="status-badge status-progress">
                In Progress
            </span>

        @elseif($research->status === 'correction')

            <span class="status-badge status-correction">
                Correction
            </span>

        @elseif($research->status === 'resubmitted')

            <span class="status-badge status-resubmitted">
                Resubmitted
            </span>

        @elseif($research->status === 'completed')

            <span class="status-badge status-completed">
                Completed
            </span>

        @else

            <span class="status-badge status-progress">
                {{ ucfirst($research->status) }}
            </span>

        @endif

    </span>

</div>


{{-- ========================================================= --}}
{{-- SUBMITTED AT --}}
{{-- ========================================================= --}}

<div class="info-row">

    <span class="info-label">
        Submitted At
    </span>

    <span class="info-value">

        {{ $research->created_at
            ? \Carbon\Carbon::parse(
                $research->created_at
            )->format('d M Y, h:i A')
            : '-' }}

    </span>

</div>


{{-- ========================================================= --}}
{{-- SUPERVISOR RESPONSE TIME --}}
{{-- ========================================================= --}}

<div class="info-row">

    <span class="info-label">
        Supervisor Response
    </span>

    <span class="info-value">

        @if($research->created_at && $research->updated_at)

            @php

                $submittedAt = \Carbon\Carbon::parse(
                    $research->created_at
                );

                $respondedAt = \Carbon\Carbon::parse(
                    $research->updated_at
                );

                $seconds = $submittedAt->diffInSeconds(
                    $respondedAt
                );

                $minutes = floor($seconds / 60);

                $hours = floor($minutes / 60);

                $days = floor($hours / 24);

                $weeks = floor($days / 7);

            @endphp


            <div class="response-time-box">

                <div class="response-time-icon">

                    <i class="bi bi-clock-history"></i>

                </div>


                <div>

                    <div class="response-time-label">

                        Response Time

                    </div>


                    <div class="response-time-value">

                        @if($seconds < 60)

                            Less than 1 minute after submission

                        @elseif($minutes < 60)

                            {{ $minutes }}
                            {{ $minutes == 1 ? 'minute' : 'minutes' }}
                            after submission

                        @elseif($hours < 24)

                            {{ $hours }}
                            {{ $hours == 1 ? 'hour' : 'hours' }}
                            after submission

                        @elseif($days < 7)

                            {{ $days }}
                            {{ $days == 1 ? 'day' : 'days' }}
                            after submission

                        @else

                            {{ $weeks }}
                            {{ $weeks == 1 ? 'week' : 'weeks' }}
                            after submission

                        @endif

                    </div>


                    <div class="response-time-date">

                        Updated:
                        {{ $respondedAt->format('d M Y, h:i A') }}

                    </div>

                </div>

            </div>


        @else

            <span class="text-muted">

                Waiting for supervisor response

            </span>

        @endif

    </span>

</div>


{{-- ========================================================= --}}
{{-- DOCUMENT --}}
{{-- ========================================================= --}}

<div class="info-row">

    <span class="info-label">
        Document
    </span>

    <span
        class="info-value"
        style="width:70%;"
    >

        <div class="document-box">

            <span class="document-name">

                <i class="bi bi-file-earmark-text me-1"></i>

                {{ basename($research->document) }}

            </span>


            <a
                href="{{ asset($research->document) }}"
                target="_blank"
                class="btn-document"
            >

                <i class="bi bi-eye me-1"></i>

                View Document

            </a>

        </div>

    </span>

</div>

</div>

<style>

    .response-time-box {

        display: flex;

        align-items: center;

        gap: 12px;

        background: #f8fafc;

        border: 1px solid #e2e8f0;

        border-radius: 8px;

        padding: 10px 13px;

    }


    .response-time-icon {

        width: 38px;

        height: 38px;

        min-width: 38px;

        border-radius: 50%;

        background: #eff6ff;

        color: #2563eb;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 17px;

    }


    .response-time-label {

        font-size: 11px;

        color: #64748b;

        margin-bottom: 2px;

    }


    .response-time-value {

        font-size: 13px;

        font-weight: 700;

        color: #1e293b;

    }


    .response-time-date {

        font-size: 10px;

        color: #94a3b8;

        margin-top: 3px;

    }

</style>




<!-- =========================================================
     RESEARCH TIMELINE
========================================================= -->

<div class="info-card">

    <div class="info-title">

        <i class="bi bi-clock-history me-1"></i>

        Research Progress Timeline

    </div>


    <div class="timeline">


        <!-- RESEARCH SUBMITTED -->

        <div class="timeline-item">

            <div class="timeline-dot"></div>

            <div class="timeline-title">

                Research Submitted

            </div>

            <div class="timeline-date">

                <i class="bi bi-calendar3 me-1"></i>

                {{ $research->created_at
                    ? \Carbon\Carbon::parse(
                        $research->created_at
                    )->format('d M Y, h:i A')
                    : '-' }}

            </div>

            <div class="timeline-text">

                Student submitted the research proposal
                to the supervisor.

            </div>

        </div>



        <!-- SUPERVISOR RESPONSES -->

        @foreach($corrections as $correction)

            <div class="timeline-item">

                <div class="timeline-dot"></div>


                <div class="timeline-title">

                    Supervisor Response

                </div>


                <div class="timeline-date">

                    <i class="bi bi-calendar3 me-1"></i>

                    {{ \Carbon\Carbon::parse(
                        $correction->created_at
                    )->format(
                        'd M Y, h:i A'
                    ) }}

                </div>


                <div class="timeline-text">

                    {{ $correction->comment }}

                </div>

            </div>

        @endforeach



        <!-- CURRENT STATUS -->

        <div class="timeline-item">

            <div class="timeline-dot"></div>

            <div class="timeline-title">

                Current Research Status

            </div>

            <div class="timeline-date">

                Last updated:

                {{ $research->updated_at
                    ? \Carbon\Carbon::parse(
                        $research->updated_at
                    )->format('d M Y, h:i A')
                    : '-' }}

            </div>

            <div class="timeline-text">

                Current status:

                <strong>
                    {{ ucfirst(
                        str_replace(
                            '_',
                            ' ',
                            $research->status
                        )
                    ) }}
                </strong>

            </div>

        </div>


    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('error'))
<script>
Swal.fire({
    icon: 'Success',
    title: 'Success!',
    text: '{{ session('error') }}',
    confirmButtonText: 'OK'
});
</script>
@endif

@endsection