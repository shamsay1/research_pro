@extends('layout.app')

@section('content')

<style>

.responses-container{
    max-width:1000px;
    margin:auto;
}

.responses-header{
    margin-bottom:25px;
}

.responses-header h4{
    margin:0;
    font-size:24px;
    font-weight:700;
    color:#0f172a;
}

.responses-header p{
    margin-top:6px;
    color:#64748b;
    font-size:14px;
}


/* =========================================
   RESEARCH CARD
========================================= */

.research-response-card{
    background:#fff;
    border-radius:14px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 3px 15px rgba(0,0,0,.07);
    border:1px solid #f1f5f9;
}


/* =========================================
   RESEARCH INFORMATION
========================================= */

.research-info{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
    padding-bottom:18px;
    border-bottom:1px solid #e2e8f0;
}

.research-title{
    font-size:19px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:6px;
}

.research-date{
    color:#94a3b8;
    font-size:13px;
}


/* =========================================
   STATUS
========================================= */

.research-status{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:6px 12px;
    border-radius:20px;
    font-size:11px;
    font-weight:700;
    text-transform:capitalize;
}

.status-pending{
    background:#fef3c7;
    color:#92400e;
}

.status-under_review{
    background:#dbeafe;
    color:#1d4ed8;
}

.status-correction{
    background:#fee2e2;
    color:#dc2626;
}

.status-resubmitted{
    background:#dbeafe;
    color:#1d4ed8;
}

.status-approved{
    background:#dcfce7;
    color:#15803d;
}

.status-completed{
    background:#dcfce7;
    color:#15803d;
}

.status-rejected{
    background:#fee2e2;
    color:#dc2626;
}


/* =========================================
   RESPONSE SECTION
========================================= */

.correction-section{
    margin-top:22px;
}

.correction-title{
    font-size:16px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:15px;
}


/* =========================================
   CORRECTION CARD
========================================= */

.correction-card{
    border:1px solid #fecaca;
    background:#fffafa;
    border-radius:12px;
    padding:18px;
    margin-bottom:15px;
}

.correction-card:last-child{
    margin-bottom:0;
}


/* =========================================
   CORRECTION HEADER
========================================= */

.correction-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:15px;
    margin-bottom:12px;
}

.supervisor-name{
    font-size:14px;
    font-weight:700;
    color:#334155;
}

.response-date{
    font-size:12px;
    color:#94a3b8;
    margin-top:5px;
}


/* =========================================
   COMMENT
========================================= */

.comment-box{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:9px;
    padding:15px;
}

.comment-label{
    font-size:12px;
    font-weight:700;
    color:#64748b;
    margin-bottom:7px;
}

.comment-text{
    color:#334155;
    font-size:14px;
    line-height:1.7;
    white-space:pre-line;
}


/* =========================================
   CORRECTION STATUS
========================================= */

.correction-status{
    display:inline-block;
    padding:5px 10px;
    border-radius:15px;
    font-size:11px;
    font-weight:700;
}

.correction-status-pending{
    background:#fef3c7;
    color:#92400e;
}

.correction-status-resolved{
    background:#dcfce7;
    color:#15803d;
}


/* =========================================
   NO RESPONSE
========================================= */

.no-response{
    background:#f8fafc;
    border:1px dashed #cbd5e1;
    border-radius:10px;
    padding:25px;
    text-align:center;
    color:#64748b;
}

.no-response i{
    font-size:35px;
    color:#94a3b8;
    display:block;
    margin-bottom:8px;
}


/* =========================================
   NO RESEARCH
========================================= */

.empty-research{
    background:#fff;
    border-radius:14px;
    padding:45px 25px;
    text-align:center;
    box-shadow:0 3px 15px rgba(0,0,0,.07);
}

.empty-research i{
    font-size:55px;
    color:#94a3b8;
}

.empty-research h5{
    margin-top:15px;
    color:#334155;
    font-weight:700;
}

.empty-research p{
    color:#64748b;
    font-size:14px;
}


/* =========================================
   DOCUMENT
========================================= */

.document-link{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-top:12px;
    padding:7px 12px;
    border-radius:7px;
    background:#eff6ff;
    color:#2563eb;
    text-decoration:none;
    font-size:12px;
    font-weight:600;
}

.document-link:hover{
    background:#dbeafe;
    color:#1d4ed8;
}

</style>


<div class="responses-container">


    {{-- =========================================
         HEADER
    ========================================== --}}

    <div class="responses-header">

        <h4>
            Research Responses
        </h4>

        <p>
            View feedback and comments provided by your supervisor
            regarding your research proposal.
        </p>

    </div>


    {{-- =========================================
         SUCCESS
    ========================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- =========================================
         ERROR
    ========================================== --}}

    @if(session('error'))

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-circle me-1"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- =========================================
         STUDENT HAS RESEARCH
    ========================================== --}}

    @if($researches->isNotEmpty())


        @foreach($researches as $research)


            <div class="research-response-card">


                {{-- =================================
                     RESEARCH INFORMATION
                ================================== --}}

                <div class="research-info">


                    <div>

                        {{-- TITLE --}}

                        <div class="research-title">

                            {{ $research->title }}

                        </div>


                        {{-- SUBMITTED DATE --}}

                        <div class="research-date">

                            <i class="bi bi-calendar3 me-1"></i>

                            Date Submitted:

                            @if($research->created_at)

                                {{ $research->created_at->format('d F Y, h:i A') }}

                            @else

                                N/A

                            @endif

                        </div>


                        {{-- DOCUMENT --}}

                        @if($research->document)

                            <a
                                href="{{ asset('storage/'.$research->document) }}"
                                target="_blank"
                                class="document-link"
                            >

                                <i class="bi bi-file-earmark-text"></i>

                                View Research Document

                            </a>

                        @endif

                    </div>


                    {{-- =================================
                         RESEARCH STATUS
                    ================================== --}}

                    <div>

                        <span
                            class="research-status status-{{ $research->status }}"
                        >

                            @switch($research->status)

                                @case('pending')

                                    <i class="bi bi-clock"></i>
                                    Pending

                                @break


                                @case('under_review')

                                    <i class="bi bi-eye"></i>
                                    Under Review

                                @break


                                @case('correction')

                                    <i class="bi bi-exclamation-circle"></i>
                                    Correction Required

                                @break


                                @case('resubmitted')

                                    <i class="bi bi-arrow-repeat"></i>
                                    Resubmitted

                                @break


                                @case('approved')

                                    <i class="bi bi-check-circle"></i>
                                    Approved

                                @break


                                @case('completed')

                                    <i class="bi bi-check-circle-fill"></i>
                                    Completed

                                @break


                                @case('rejected')

                                    <i class="bi bi-x-circle"></i>
                                    Rejected

                                @break


                                @default

                                    {{ str_replace(
                                        '_',
                                        ' ',
                                        $research->status
                                    ) }}

                            @endswitch

                        </span>

                    </div>

                </div>


                {{-- =================================
                     SUPERVISOR RESPONSES
                ================================== --}}

                <div class="correction-section">


                    <div class="correction-title">

                        <i class="bi bi-chat-left-text me-1"></i>

                        Supervisor Responses

                    </div>


                    {{-- =================================
                         CORRECTIONS EXIST
                    ================================== --}}

                    @if($research->corrections->isNotEmpty())


                        @foreach($research->corrections as $correction)


                            <div class="correction-card">


                                {{-- RESPONSE HEADER --}}

                                <div class="correction-header">


                                    <div>

                                        <div class="supervisor-name">

                                            <i class="bi bi-person-badge me-1"></i>

                                            Supervisor:

                                            @if($correction->supervisor)

                                                {{ $correction->supervisor->name }}

                                            @else

                                                Supervisor

                                            @endif

                                        </div>


                                        {{-- DATE + TIME --}}

                                        <div class="response-date">

                                            <i class="bi bi-calendar3 me-1"></i>

                                            Responded:

                                            @if($correction->created_at)

                                                {{ $correction->created_at->format('d F Y, h:i A') }}

                                            @else

                                                N/A

                                            @endif

                                        </div>

                                    </div>


                                    {{-- CORRECTION STATUS --}}

                                    @if($correction->status === 'resolved')

                                        <span
                                            class="correction-status correction-status-resolved"
                                        >

                                            <i class="bi bi-check-circle me-1"></i>

                                            Resolved

                                        </span>

                                    @else

                                        <span
                                            class="correction-status correction-status-pending"
                                        >

                                            <i class="bi bi-exclamation-triangle me-1"></i>

                                            Correction

                                        </span>

                                    @endif

                                </div>


                                {{-- COMMENT --}}

                                {{-- COMMENT --}}

<div class="comment-box">


<div class="comment-label">
    Supervisor Comment
</div>

<div class="comment-text">
    {{ $correction->comment }}
</div>


</div>

{{-- ========================================= --}}
{{-- SUPERVISOR ATTACHMENT --}}
{{-- ========================================= --}}

@if($correction->documentary)

<div class="attachment-box mt-3">

    <div class="attachment-title">

        <i class="bi bi-paperclip me-1"></i>

        Supervisor Attachment

    </div>


    <div class="attachment-file">

        <div class="attachment-info">

            <i class="bi bi-file-earmark-text attachment-icon"></i>

            <div>

                <div class="attachment-name">

                    {{ basename($correction->documentary) }}

                </div>

                <div class="attachment-label">

                    Document provided by supervisor

                </div>

            </div>

        </div>



        {{-- DOWNLOAD --}}
        <a
            href="{{ asset($correction->documentary) }}"
            download="{{ basename($correction->documentary) }}"
            class="btn btn-sm btn-success"
        >

            <i class="bi bi-download me-1"></i>

            Download

        </a>

    </div>

</div>


@endif



                            </div>


                        @endforeach


                    @else


                        {{-- =================================
                             NO RESPONSE YET
                        ================================== --}}

                        <div class="no-response">

                            <i class="bi bi-chat-left-dots"></i>

                            <strong>

                                No Supervisor Response Yet

                            </strong>

                            <div class="small mt-1">

                                Your supervisor has not provided
                                any comments or corrections for
                                this research yet.

                            </div>

                        </div>


                    @endif


                </div>


            </div>


        @endforeach


    @else


        {{-- =========================================
             NO RESEARCH
        ========================================== --}}

        <div class="empty-research">

            <i class="bi bi-file-earmark-text"></i>

            <h5>
                No Research Submitted
            </h5>

            <p>
                You have not submitted any research proposal yet.
            </p>

        </div>

    @endif


</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session('success') }}',
    confirmButtonText: 'OK'
});
</script>
@endif

@endsection