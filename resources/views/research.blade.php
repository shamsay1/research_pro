@extends('layout.app')

@section('content')

<style>

.research-container{
    max-width:900px;
    margin:auto;
}

.research-header{
    margin-bottom:20px;
}

.research-header h4{
    margin:0;
    font-size:24px;
    font-weight:700;
    color:#0f172a;
}

.research-header p{
    margin-top:5px;
    color:#64748b;
    font-size:14px;
}

.research-card{
    background:#fff;
    border-radius:14px;
    padding:25px;
    box-shadow:0 3px 15px rgba(0,0,0,.07);
}

.form-label{
    font-size:14px;
    font-weight:600;
    color:#334155;
}

.form-control{
    border-radius:8px;
    padding:11px 13px;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,.1);
}

.upload-box{
    border:2px dashed #cbd5e1;
    border-radius:10px;
    padding:25px;
    text-align:center;
    background:#f8fafc;
    cursor:pointer;
}

.upload-box:hover{
    border-color:#2563eb;
    background:#eff6ff;
}

.upload-icon{
    font-size:35px;
    color:#2563eb;
    margin-bottom:8px;
}

.upload-text{
    font-size:14px;
    color:#475569;
}

.upload-info{
    font-size:12px;
    color:#94a3b8;
    margin-top:5px;
}

.submit-btn{
    width:100%;
    border:none;
    border-radius:8px;
    padding:12px;
    background:#2563eb;
    color:#fff;
    font-weight:600;
    margin-top:20px;
}

.submit-btn:hover{
    background:#1d4ed8;
}

.status{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
}

.status-pending{
    background:#fef3c7;
    color:#92400e;
}

.status-correction{
    background:#fee2e2;
    color:#dc2626;
}

.status-approved,
.status-completed{
    background:#dcfce7;
    color:#15803d;
}

.status-under_review{
    background:#dbeafe;
    color:#1d4ed8;
}


/* =====================================================
   STATUS CARD
===================================================== */

.status-card{
    text-align:center;
    padding:40px 25px;
}

.status-icon{
    font-size:60px;
    margin-bottom:15px;
}

.status-card h5{
    font-weight:700;
    color:#0f172a;
}

.status-card p{
    color:#64748b;
    font-size:14px;
}


/* =====================================================
   CORRECTION ALERT
===================================================== */

.correction-alert{
    background:#fff7ed;
    border:1px solid #fed7aa;
    color:#9a3412;
    border-radius:10px;
    padding:15px;
    margin-bottom:20px;
}


/* =====================================================
   CONFIRMATION MODAL
===================================================== */

.confirm-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.60);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
    padding:20px;
}

.confirm-overlay.show{
    display:flex;
}

.confirm-modal{
    width:100%;
    max-width:500px;
    background:#fff;
    border-radius:16px;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
    overflow:hidden;
    animation:modalShow .2s ease;
}

@keyframes modalShow{

    from{
        opacity:0;
        transform:translateY(-15px) scale(.97);
    }

    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }

}

.confirm-header{
    padding:20px 22px;
    border-bottom:1px solid #e2e8f0;
    display:flex;
    align-items:center;
    gap:12px;
}

.confirm-icon{
    width:45px;
    height:45px;
    border-radius:50%;
    background:#dbeafe;
    color:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
}

.confirm-header h5{
    margin:0;
    font-weight:700;
    color:#0f172a;
}

.confirm-body{
    padding:22px;
}

.confirm-body p{
    color:#64748b;
    font-size:14px;
}

.confirm-details{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:10px;
    padding:15px;
    margin-top:15px;
}

.confirm-item{
    display:flex;
    justify-content:space-between;
    gap:15px;
    padding:8px 0;
}

.confirm-item:not(:last-child){
    border-bottom:1px solid #e2e8f0;
}

.confirm-label{
    color:#64748b;
    font-size:13px;
}

.confirm-value{
    color:#0f172a;
    font-size:13px;
    font-weight:600;
    text-align:right;
    word-break:break-word;
}

.confirm-warning{
    margin-top:15px;
    padding:12px;
    background:#fff7ed;
    border:1px solid #fed7aa;
    color:#9a3412;
    border-radius:8px;
    font-size:13px;
}

.confirm-footer{
    padding:16px 22px;
    border-top:1px solid #e2e8f0;
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.cancel-btn{
    border:1px solid #cbd5e1;
    background:#fff;
    color:#475569;
    padding:10px 18px;
    border-radius:8px;
    font-weight:600;
}

.cancel-btn:hover{
    background:#f8fafc;
}

.confirm-submit-btn{
    border:none;
    background:#2563eb;
    color:#fff;
    padding:10px 18px;
    border-radius:8px;
    font-weight:600;
}

.confirm-submit-btn:hover{
    background:#1d4ed8;
}

</style>


<div class="research-container">


    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="research-header">

        <h4>
            Research Proposal
        </h4>

        <p>
            Submit your research proposal to your supervisor.
        </p>

    </div>


    {{-- =====================================================
        SUCCESS MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle-fill me-1"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
        ERROR MESSAGE
    ====================================================== --}}

    @if(session('error'))

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-circle-fill me-1"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- =====================================================
        VALIDATION ERRORS
    ====================================================== --}}

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


    {{-- =====================================================
        1. NO RESEARCH
        SHOW SUBMISSION FORM
    ====================================================== --}}

    @if(!$research)

        <div class="research-card">

            <form
                id="researchForm"
                action="{{ route('student.research.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- TITLE --}}

                <div class="mb-4">

                    <label class="form-label">
                        Research Title
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        placeholder="Enter your research title"
                        required
                    >

                    @error('title')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- DOCUMENT --}}

                <div class="mb-3">

                    <label class="form-label">
                        Research Document
                    </label>

                    <label
                        for="document"
                        class="upload-box d-block"
                    >

                        <div class="upload-icon">

                            <i class="bi bi-cloud-arrow-up"></i>

                        </div>

                        <div class="upload-text">

                            Click here to upload your research

                        </div>

                        <div class="upload-info">

                            PDF, DOC or DOCX 

                        </div>

                    </label>


                    <input
                        type="file"
                        id="document"
                        name="document"
                        class="d-none @error('document') is-invalid @enderror"
                        accept=".pdf,.doc,.docx"
                        onchange="showFileName(this)"
                        required
                    >


                    <div
                        id="fileName"
                        class="mt-2 text-muted small"
                    ></div>


                    @error('document')

                        <div class="text-danger small mt-1">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- SUBMIT --}}

                <button
                    type="button"
                    class="submit-btn"
                    onclick="openConfirmation()"
                >

                    <i class="bi bi-send me-1"></i>

                    Submit Research

                </button>

            </form>

        </div>


    {{-- =====================================================
        2. PENDING
        DO NOT SHOW FORM
    ====================================================== --}}

    @elseif($research->status === 'pending')

        <div class="research-card status-card">

            <div class="status-icon text-warning">

                <i class="bi bi-hourglass-split"></i>

            </div>

            <h5>
                Research Submitted
            </h5>

            <p>
                Your research has been submitted successfully
                and is waiting for your supervisor's review.
            </p>

            <span class="status status-pending">

                Pending

            </span>

        </div>


    {{-- =====================================================
        3. UNDER REVIEW
        DO NOT SHOW FORM
    ====================================================== --}}

    @elseif($research->status === 'under_review')

        <div class="research-card status-card">

            <div class="status-icon text-primary">

                <i class="bi bi-search"></i>

            </div>

            <h5>
                Research Under Review
            </h5>

            <p>
                Your supervisor is currently reviewing
                your research proposal.
            </p>

            <span class="status status-under_review">

                Under Review

            </span>

        </div>


    {{-- =====================================================
        4. CORRECTION
        SHOW FORM AGAIN
    ====================================================== --}}

    @elseif($research->status === 'correction')

        <div class="correction-alert">

            <div class="d-flex align-items-start">

                <i
                    class="bi bi-exclamation-circle-fill me-2"
                    style="font-size:20px"
                ></i>

                <div>

                    <strong>
                        Correction Required
                    </strong>

                    <div class="small mt-1">

                        Your supervisor has requested corrections
                        to your research. Please correct your research
                        document and submit it again.

                    </div>

                </div>

            </div>

        </div>


        {{-- CORRECTION FORM --}}

        <div class="research-card">

            <form
                id="researchForm"
                action="{{ route('student.research.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- TITLE --}}

                <div class="mb-4">

                    <label class="form-label">
                        Research Title
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $research->title) }}"
                        placeholder="Enter your research title"
                        required
                    >

                    @error('title')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- DOCUMENT --}}

                <div class="mb-3">

                    <label class="form-label">
                        Corrected Research Document
                    </label>

                    <label
                        for="document"
                        class="upload-box d-block"
                    >

                        <div class="upload-icon">

                            <i class="bi bi-cloud-arrow-up"></i>

                        </div>

                        <div class="upload-text">

                            Click here to upload the corrected research

                        </div>

                        <div class="upload-info">

                            PDF, DOC or DOCX — Maximum 10MB

                        </div>

                    </label>


                    <input
                        type="file"
                        id="document"
                        name="document"
                        class="d-none @error('document') is-invalid @enderror"
                        accept=".pdf,.doc,.docx"
                        onchange="showFileName(this)"
                        required
                    >


                    <div
                        id="fileName"
                        class="mt-2 text-muted small"
                    ></div>


                    @error('document')

                        <div class="text-danger small mt-1">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- RESUBMIT --}}

                <button
                    type="button"
                    class="submit-btn"
                    onclick="openConfirmation()"
                >

                    <i class="bi bi-arrow-repeat me-1"></i>

                    Resubmit Research

                </button>

            </form>

        </div>


    {{-- =====================================================
        5. APPROVED / COMPLETED
        DO NOT SHOW FORM
    ====================================================== --}}

    @elseif(
        in_array(
            $research->status,
            ['approved', 'completed']
        )
    )

        <div class="research-card status-card">

            <div class="status-icon text-success">

                <i class="bi bi-patch-check-fill"></i>

            </div>

            <h5>
                Research Approved
            </h5>

            <p>
                Congratulations! Your supervisor has approved
                your research proposal.
            </p>

            <span class="status status-approved">

                {{ ucfirst($research->status) }}

            </span>

        </div>

    @endif

</div>


{{-- =========================================================
    CONFIRMATION MODAL
========================================================= --}}

<div
    id="confirmationModal"
    class="confirm-overlay"
    onclick="closeConfirmation(event)"
>

    <div
        class="confirm-modal"
        onclick="event.stopPropagation()"
    >


        {{-- HEADER --}}

        <div class="confirm-header">

            <div class="confirm-icon">

                <i class="bi bi-send-check"></i>

            </div>

            <div>

                <h5>
                    Confirm Submission
                </h5>

            </div>

        </div>


        {{-- BODY --}}

        <div class="confirm-body">

            <p>

                Please confirm that the following research
                information is correct before submitting.

            </p>


            <div class="confirm-details">


                {{-- TITLE --}}

                <div class="confirm-item">

                    <span class="confirm-label">

                        Research Title

                    </span>

                    <span
                        class="confirm-value"
                        id="confirmTitle"
                    >
                        -
                    </span>

                </div>


                {{-- DOCUMENT --}}

                <div class="confirm-item">

                    <span class="confirm-label">

                        Document

                    </span>

                    <span
                        class="confirm-value"
                        id="confirmDocument"
                    >
                        -
                    </span>

                </div>


            </div>


            <div class="confirm-warning">

                <i class="bi bi-exclamation-triangle me-1"></i>

                Once submitted, your research will be sent
                to the supervisor for review.

            </div>

        </div>


        {{-- FOOTER --}}

        <div class="confirm-footer">

            <button
                type="button"
                class="cancel-btn"
                onclick="closeConfirmation()"
            >

                Cancel

            </button>


            <button
                type="button"
                class="confirm-submit-btn"
                id="confirmSubmitButton"
                onclick="confirmSubmit()"
            >

                <i class="bi bi-check-lg me-1"></i>

                Confirm & Submit

            </button>

        </div>

    </div>

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

/*
|--------------------------------------------------------------------------
| Show selected file
|--------------------------------------------------------------------------
*/

function showFileName(input)
{
    const fileName =
        document.getElementById('fileName');

    if(input.files.length > 0){

        fileName.innerHTML =
            '<i class="bi bi-file-earmark-text"></i> '
            + input.files[0].name;

    }else{

        fileName.innerHTML = '';

    }
}


/*
|--------------------------------------------------------------------------
| Open confirmation modal
|--------------------------------------------------------------------------
*/

function openConfirmation()
{
    const form =
        document.getElementById('researchForm');

    const title =
        document.getElementById('title');

    const documentInput =
        document.getElementById('document');

    const confirmTitle =
        document.getElementById('confirmTitle');

    const confirmDocument =
        document.getElementById('confirmDocument');


    if(!form || !title || !documentInput){

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Validate title
    |--------------------------------------------------------------------------
    */

    if(!title.value.trim()){

        title.focus();

        title.reportValidity();

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Document is required for both
    | NEW and CORRECTION
    |--------------------------------------------------------------------------
    */

    if(documentInput.files.length === 0){

        documentInput.click();

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Show information inside modal
    |--------------------------------------------------------------------------
    */

    confirmTitle.textContent =
        title.value;

    confirmDocument.textContent =
        documentInput.files[0].name;


    /*
    |--------------------------------------------------------------------------
    | Show modal
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('confirmationModal')
        .classList
        .add('show');
}


/*
|--------------------------------------------------------------------------
| Close confirmation
|--------------------------------------------------------------------------
*/

function closeConfirmation(event)
{
    if(
        event &&
        event.target !== event.currentTarget
    ){

        return;

    }


    document
        .getElementById('confirmationModal')
        .classList
        .remove('show');
}


/*
|--------------------------------------------------------------------------
| Confirm & Submit
|--------------------------------------------------------------------------
*/

function confirmSubmit()
{
    const form =
        document.getElementById('researchForm');

    const button =
        document.getElementById('confirmSubmitButton');


    if(!form){

        return;

    }


    button.disabled = true;

    button.innerHTML =
        '<span class="spinner-border spinner-border-sm me-1"></span>'
        + 'Submitting...';


    form.submit();
}


/*
|--------------------------------------------------------------------------
| Close modal with ESC
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'keydown',
    function(event)
    {

        if(event.key === 'Escape'){

            closeConfirmation();

        }

    }
);

</script>

@endsection