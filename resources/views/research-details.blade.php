@extends('layout.app')

@section('content')

<style>

.details-container{
    max-width:1000px;
    margin:auto;
}


/* =====================================================
   HEADER
===================================================== */

.page-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:20px;
}

.page-header h4{
    margin:0;
    font-size:23px;
    font-weight:700;
    color:#0f172a;
}

.page-header p{
    margin:5px 0 0;
    font-size:14px;
    color:#64748b;
}


/* =====================================================
   CARD
===================================================== */

.detail-card{
    background:#fff;
    border-radius:14px;
    padding:22px;
    margin-bottom:20px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
}


/* =====================================================
   CARD TITLE
===================================================== */

.card-title{
    font-size:17px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:18px;
}


/* =====================================================
   STUDENT
===================================================== */

.student-box{
    display:flex;
    align-items:center;
    gap:15px;
}

.student-avatar{
    width:60px;
    height:60px;
    border-radius:50%;
    background:#eff6ff;
    color:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:25px;
}

.student-name{
    font-size:18px;
    font-weight:700;
    color:#0f172a;
}

.student-reg{
    font-size:13px;
    color:#64748b;
    margin-top:4px;
}


/* =====================================================
   INFO GRID
===================================================== */

.info-grid{
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:15px;
}

.info-item{
    padding:15px;
    background:#f8fafc;
    border-radius:10px;
    border:1px solid #e2e8f0;
}

.info-label{
    font-size:11px;
    color:#64748b;
    margin-bottom:5px;
}

.info-value{
    font-size:14px;
    font-weight:600;
    color:#0f172a;
}


/* =====================================================
   TITLE
===================================================== */

.research-main-title{
    font-size:20px;
    line-height:1.5;
    font-weight:700;
    color:#0f172a;
    padding:18px;
    border-radius:10px;
    background:#f8fafc;
}


/* =====================================================
   STATUS
===================================================== */

.status-badge{
    display:inline-block;
    padding:7px 13px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status-pending{
    background:#fef3c7;
    color:#92400e;
}

.status-under_review,
.status-resubmitted{
    background:#dbeafe;
    color:#1d4ed8;
}

.status-correction,
.status-rejected{
    background:#fee2e2;
    color:#b91c1c;
}

.status-approved,
.status-completed{
    background:#dcfce7;
    color:#15803d;
}


/* =====================================================
   DOCUMENT
===================================================== */

.document-box{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    padding:18px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    background:#f8fafc;
}

.document-info{
    display:flex;
    align-items:center;
    gap:12px;
}

.document-icon{
    width:45px;
    height:45px;
    border-radius:8px;
    background:#fee2e2;
    color:#dc2626;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
}

.document-name{
    font-size:14px;
    font-weight:600;
    color:#0f172a;
}

.document-type{
    font-size:12px;
    color:#64748b;
    margin-top:3px;
}


/* =====================================================
   BUTTONS
===================================================== */

.action-buttons{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.approve-btn{
    border:none;
    padding:11px 18px;
    border-radius:8px;
    background:#16a34a;
    color:#fff;
    font-weight:600;
}

.approve-btn:hover{
    background:#15803d;
}

.correction-btn{
    border:none;
    padding:11px 18px;
    border-radius:8px;
    background:#dc2626;
    color:#fff;
    font-weight:600;
}

.correction-btn:hover{
    background:#b91c1c;
}

.download-btn{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:10px 15px;
    border-radius:8px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}

.download-btn:hover{
    background:#1d4ed8;
    color:#fff;
}


/* =====================================================
   CORRECTION
===================================================== */

.correction-box{
    padding:15px;
    border-radius:10px;
    background:#fff7ed;
    border:1px solid #fed7aa;
    margin-bottom:12px;
}

.correction-comment{
    color:#334155;
    font-size:14px;
    line-height:1.6;
}

.correction-meta{
    font-size:11px;
    color:#64748b;
    margin-top:8px;
}


/* =====================================================
   FORM
===================================================== */

textarea.form-control{
    min-height:130px;
    resize:vertical;
}

.form-label{
    font-size:13px;
    font-weight:600;
    color:#334155;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:768px){

    .details-container{
        width:100%;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .document-box{
        flex-direction:column;
        align-items:flex-start;
    }

    .action-buttons{
        flex-direction:column;
    }

    .approve-btn,
    .correction-btn{
        width:100%;
    }

}

</style>


<div class="details-container">


    {{-- =================================================
        PAGE HEADER
    ================================================== --}}

    <div class="page-header">

        <div>

            <h4>
                Research Details
            </h4>

            <p>
                Review the research proposal submitted by the student.
            </p>

        </div>

        <a
            href="{{ route('supervisor.research') }}"
            class="btn btn-outline-secondary btn-sm"
        >
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>



    {{-- =================================================
        SUCCESS
    ================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle"></i>

            {{ session('success') }}

        </div>

    @endif



    {{-- =================================================
        ERROR
    ================================================== --}}

    @if(session('error'))

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-circle"></i>

            {{ session('error') }}

        </div>

    @endif



    {{-- =================================================
        VALIDATION ERRORS
    ================================================== --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- =================================================
        STUDENT INFORMATION
    ================================================== --}}

    <div class="detail-card">

        <div class="card-title">

            <i class="bi bi-person"></i>

            Student Information

        </div>


        <div class="student-box">

            <div class="student-avatar">

                <i class="bi bi-person"></i>

            </div>


            <div>

                <div class="student-name">

                    {{ $research->student->firstname }}

                    {{ $research->student->middlename }}

                    {{ $research->student->lastname }}

                </div>


                <div class="student-reg">

                    Registration:

                    {{ $research->student->reg_number }}

                </div>

            </div>

        </div>

    </div>



    {{-- =================================================
        RESEARCH INFORMATION
    ================================================== --}}

    <div class="detail-card">

        <div class="card-title">

            <i class="bi bi-journal-text"></i>

            Research Information

        </div>


        <div class="info-grid">


            <div class="info-item">

                <div class="info-label">
                    Research Title
                </div>

                <div class="info-value">

                    {{ $research->title }}

                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Status
                </div>

                <div>

                    <span
                        class="status-badge status-{{ $research->status }}"
                    >

                        {{ ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $research->status
                            )
                        ) }}

                    </span>

                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Date Submitted
                </div>

                <div class="info-value">

                    {{ $research->created_at->format(
                        'd F Y'
                    ) }}

                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Time Submitted
                </div>

                <div class="info-value">

                    {{ $research->created_at->format(
                        'h:i A'
                    ) }}

                </div>

            </div>

        </div>

    </div>



    {{-- =================================================
        TITLE
    ================================================== --}}

    <div class="detail-card">

        <div class="card-title">

            <i class="bi bi-type"></i>

            Research Title

        </div>


        <div class="research-main-title">

            {{ $research->title }}

        </div>

    </div>



    {{-- =================================================
        DOCUMENT
    ================================================== --}}

    <div class="detail-card">

        <div class="card-title">

            <i class="bi bi-file-earmark-text"></i>

            Research Document

        </div>


        @if($research->document)

            <div class="document-box">


                <div class="document-info">


                    <div class="document-icon">

                        <i class="bi bi-file-earmark-pdf"></i>

                    </div>


                    <div>

                        <div class="document-name">

                            Research Document

                        </div>


                        <div class="document-type">

                            Uploaded on

                            {{ $research->created_at->format(
                                'd F Y'
                            ) }}

                            at

                            {{ $research->created_at->format(
                                'h:i A'
                            ) }}

                        </div>

                    </div>

                </div>


                <a 
    href="{{ route('supervisor.research.download', $research->id) }}"
    class="download-btn"
>

    <i class="bi bi-download"></i>

    Download Document

</a>

            </div>

        @else

            <div class="alert alert-warning">

                No document uploaded.

            </div>

        @endif

    </div>



    {{-- =================================================
        SUPERVISOR ACTIONS
    ================================================== --}}

    @if(
        !in_array(
            $research->status,
            [
                'approved',
                'completed'
            ]
        )
    )

        <div class="detail-card">

            <div class="card-title">

                <i class="bi bi-shield-check"></i>

                Supervisor Decision

            </div>


            <p class="text-muted small">

                If the research is correct, approve it.
                If there are corrections, write your comments
                and send them to the student.

            </p>


            <div class="action-buttons">


                {{-- APPROVE --}}

                <form
                    action="{{ route(
                        'supervisor.research.approve',
                        $research->id
                    ) }}"
                    method="POST"
                    onsubmit="
                        return confirm(
                            'Are you sure you want to approve this research?'
                        );
                    "
                >

                    @csrf

                    @method('PATCH')


                    <button
                        type="submit"
                        class="approve-btn"
                    >

                        <i class="bi bi-check-circle"></i>

                        Approve Research

                    </button>

                </form>


                {{-- CORRECTION --}}

                <button
                    type="button"
                    class="correction-btn"
                    onclick="showCorrectionForm()"
                >

                    <i class="bi bi-exclamation-circle"></i>

                    Request Correction

                </button>


            </div>

        </div>



        {{-- =================================================
            CORRECTION FORM
        ================================================== --}}

        <div
            class="detail-card"
            id="correctionForm"
            style="display:none;"
        >

            <div class="card-title">

                <i class="bi bi-chat-left-text"></i>

                Correction Comment

            </div>


            <form
    action="{{ route(
        'supervisor.research.correction',
        $research->id
    ) }}"
    method="POST"
    enctype="multipart/form-data"
>

```
@csrf


{{-- ========================================================= --}}
{{-- COMMENT --}}
{{-- ========================================================= --}}

<div class="mb-3">

    <label class="form-label">

        Write corrections for the student

        <span class="text-danger">*</span>

    </label>


    <textarea
        name="comment"
        class="form-control"
        rows="6"
        placeholder="Write the corrections the student needs to make..."
        required
    >{{ old('comment') }}</textarea>


    <small class="text-muted">

        Write the instructions or corrections that the student
        needs to make.

    </small>

</div>



{{-- ========================================================= --}}
{{-- OPTIONAL ATTACHMENT --}}
{{-- ========================================================= --}}

<div class="mb-3">

    <label class="form-label">

        Attach Document

        <span class="text-muted">
            (Optional)
        </span>

    </label>


    <input
        type="file"
        name="attachment"
        class="form-control"
        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
    >


    <small class="text-muted">

        You can attach a PDF, DOC, DOCX, JPG or PNG
        if additional instructions are needed.

        Maximum size: 10MB.

    </small>

</div>



{{-- ========================================================= --}}
{{-- PREVIEW SELECTED FILE --}}
{{-- ========================================================= --}}

<div
    id="attachmentPreview"
    class="attachment-preview"
    style="display:none;"
>

    <i class="bi bi-paperclip"></i>

    <span id="attachmentName"></span>

</div>



{{-- ========================================================= --}}
{{-- SUBMIT --}}
{{-- ========================================================= --}}

<button
    type="submit"
    class="btn btn-danger"
>

    <i class="bi bi-send me-1"></i>

    Send Correction to Student

</button>
```

</form>

<style>

    .attachment-preview {

        margin-top: 10px;

        padding: 10px 12px;

        background: #f8fafc;

        border: 1px solid #e2e8f0;

        border-radius: 7px;

        color: #475569;

        font-size: 13px;

    }

    .attachment-preview i {

        color: #2563eb;

        margin-right: 6px;

    }

</style>

<script>

document
    .querySelector('input[name="attachment"]')
    .addEventListener('change', function () {

        const preview =
            document.getElementById(
                'attachmentPreview'
            );

        const name =
            document.getElementById(
                'attachmentName'
            );


        if (this.files.length > 0) {

            name.textContent =
                this.files[0].name;

            preview.style.display =
                'block';

        } else {

            preview.style.display =
                'none';

            name.textContent =
                '';

        }

    });

</script>


        </div>

    @else

        <div class="detail-card">

            <div class="alert alert-success mb-0">

                <i class="bi bi-check-circle"></i>

                This research has already been approved.

            </div>

        </div>

    @endif



    {{-- =================================================
        PREVIOUS CORRECTIONS
    ================================================== --}}

    @if($research->corrections->count())

        <div class="detail-card">

            <div class="card-title">

                <i class="bi bi-chat-square-text"></i>

                Correction History

            </div>


            @foreach(
                $research->corrections->sortByDesc('created_at')
                as $correction
            )

                <div class="correction-box">


                    <div class="correction-comment">

                        {{ $correction->comment }}

                    </div>


                    <div class="correction-meta">

                        By:

                        @if($correction->supervisor)

                            {{ $correction->supervisor->firstname }}

                            {{ $correction->supervisor->lastname }}

                        @else

                            Supervisor

                        @endif


                        |

                        {{ $correction->created_at->format(
                            'd F Y'
                        ) }}

                        at

                        {{ $correction->created_at->format(
                            'h:i A'
                        ) }}

                    </div>

                </div>

            @endforeach

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

<script>

function showCorrectionForm()
{
    const form =
        document.getElementById(
            'correctionForm'
        );

    form.style.display = 'block';

    form.scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });
}

</script>

@endsection