@extends('layout.app')

@section('content')

<style>

/* =========================================================
   SETTINGS CONTAINER
========================================================= */

.settings-container{
    max-width:1000px;
    margin:auto;
}


/* =========================================================
   HEADER
========================================================= */

.settings-header{
    margin-bottom:25px;
}

.settings-header h4{
    margin:0;
    font-size:24px;
    font-weight:700;
    color:#0f172a;
}

.settings-header p{
    margin-top:6px;
    color:#64748b;
    font-size:14px;
}


/* =========================================================
   GRID
========================================================= */

.settings-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}


/* =========================================================
   CARD
========================================================= */

.settings-card{
    background:#fff;
    border-radius:15px;
    padding:25px;
    box-shadow:0 3px 15px rgba(0,0,0,.07);
    border:1px solid #f1f5f9;
}


/* =========================================================
   CARD HEADER
========================================================= */

.card-header-custom{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:25px;
}

.card-icon{
    width:45px;
    height:45px;
    border-radius:12px;

    background:#dbeafe;
    color:#2563eb;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:21px;
}

.card-header-custom h5{
    margin:0;
    color:#0f172a;
    font-size:17px;
    font-weight:700;
}

.card-header-custom p{
    margin:3px 0 0;
    color:#64748b;
    font-size:12px;
}


/* =========================================================
   PROFILE
========================================================= */

.profile-top{
    text-align:center;
    padding-bottom:20px;
    border-bottom:1px solid #e2e8f0;
    margin-bottom:20px;
}

.profile-avatar{
    width:85px;
    height:85px;
    margin:auto;

    border-radius:50%;

    background:#2563eb;
    color:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:32px;
    font-weight:700;
}

.profile-name{
    margin-top:12px;
    font-size:19px;
    font-weight:700;
    color:#0f172a;
}

.profile-role{
    display:inline-block;
    margin-top:5px;

    padding:5px 12px;

    border-radius:20px;

    background:#dbeafe;
    color:#1d4ed8;

    font-size:11px;
    font-weight:700;
}


/* =========================================================
   PROFILE INFORMATION
========================================================= */

.profile-info{
    display:flex;
    flex-direction:column;
    gap:14px;
}

.profile-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;

    padding-bottom:12px;

    border-bottom:1px solid #f1f5f9;
}

.profile-item:last-child{
    border-bottom:none;
}

.profile-label{
    color:#64748b;
    font-size:13px;
}

.profile-value{
    color:#0f172a;
    font-size:13px;
    font-weight:600;
    text-align:right;
    word-break:break-word;
}


/* =========================================================
   EDIT PROFILE BUTTON
========================================================= */

.edit-profile-btn{
    width:100%;
    border:none;
    border-radius:9px;

    padding:12px;

    background:#2563eb;
    color:#fff;

    font-size:14px;
    font-weight:600;

    transition:.2s;
}

.edit-profile-btn:hover{
    background:#1d4ed8;
    color:#fff;
}

.edit-profile-btn:disabled{
    opacity:.7;
    cursor:not-allowed;
}


/* =========================================================
   FORM
========================================================= */

.form-group{
    margin-bottom:18px;
}

.form-label-custom{
    display:block;
    margin-bottom:7px;

    color:#334155;
    font-size:13px;
    font-weight:600;
}

.form-control{
    border-radius:8px;
    padding:11px 13px;
}

.form-control:focus{
    border-color:#2563eb;

    box-shadow:
        0 0 0 3px rgba(37,99,235,.1);
}


/* =========================================================
   PASSWORD
========================================================= */

.password-wrapper{
    position:relative;
}

.password-wrapper .form-control{
    padding-right:45px;
}

.password-toggle{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);

    border:none;
    background:transparent;

    color:#64748b;

    cursor:pointer;
}

.password-toggle:hover{
    color:#2563eb;
}


/* =========================================================
   PASSWORD REQUIREMENT
========================================================= */

.password-info{
    margin-top:15px;

    padding:12px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:9px;

    color:#64748b;

    font-size:12px;
}

.password-info div{
    margin-bottom:4px;
}

.password-info div:last-child{
    margin-bottom:0;
}


/* =========================================================
   PASSWORD BUTTON
========================================================= */

.update-password-btn{
    width:100%;

    border:none;
    border-radius:8px;

    padding:12px;

    background:#2563eb;
    color:#fff;

    font-weight:600;

    margin-top:5px;
}

.update-password-btn:hover{
    background:#1d4ed8;
}

.update-password-btn:disabled{
    opacity:.7;
    cursor:not-allowed;
}


/* =========================================================
   ALERT
========================================================= */

.custom-alert{
    border-radius:9px;
    font-size:14px;
}


/* =========================================================
   MODAL
========================================================= */

#editProfileModal .modal-content{
    border-radius:16px;
    overflow:hidden;
}

#editProfileModal .modal-header{
    padding:20px 24px;
    border-bottom:1px solid #e2e8f0;
}

#editProfileModal .modal-body{
    padding:24px;
}

#editProfileModal .modal-footer{
    padding:16px 24px;
    border-top:1px solid #e2e8f0;
}

#editProfileModal .form-control{
    min-height:45px;
}

.profile-readonly{
    background:#f8fafc !important;
    color:#64748b;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:768px){

    .settings-grid{
        grid-template-columns:1fr;
    }

    .settings-container{
        padding:0 10px;
    }

}

</style>


<div class="settings-container">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="settings-header">

        <h4>
            Settings
        </h4>

        <p>
            Manage your profile information and account password.
        </p>

    </div>



    {{-- =====================================================
         SUCCESS MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success custom-alert">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

        </div>

    @endif



    {{-- =====================================================
         ERROR MESSAGE
    ====================================================== --}}

    @if($errors->any())

        <div class="alert alert-danger custom-alert">

            <i class="bi bi-exclamation-circle me-1"></i>

            Please correct the errors below.

        </div>

    @endif



    <div class="settings-grid">


        {{-- =================================================
             PROFILE CARD
        ================================================== --}}

        <div class="settings-card">


            {{-- CARD HEADER --}}

            <div class="card-header-custom">

                <div class="card-icon">

                    <i class="bi bi-person"></i>

                </div>

                <div>

                    <h5>
                        My Profile
                    </h5>

                    <p>
                        Your account information
                    </p>

                </div>

            </div>



            {{-- =================================================
                 PROFILE TOP
            ================================================== --}}

            <div class="profile-top">


                {{-- AVATAR --}}

                <div class="profile-avatar">

                    @php

                        $name = trim(
                            ($user->firstname ?? '') . ' ' .
                            ($user->middlename ?? '') . ' ' .
                            ($user->lastname ?? '')
                        );

                        if(empty(trim($name))) {
                            $name = 'User';
                        }

                        $words = preg_split(
                            '/\s+/',
                            trim($name)
                        );

                        $initials = '';

                        foreach(
                            array_slice($words, 0, 2)
                            as $word
                        ){

                            if(!empty($word)){

                                $initials .= strtoupper(
                                    substr($word, 0, 1)
                                );

                            }

                        }

                    @endphp


                    {{ $initials ?: 'U' }}

                </div>



                {{-- NAME --}}

                <div class="profile-name">

                    {{ $name }}

                </div>



                {{-- ROLE --}}

                <span class="profile-role">

                    @if($guard === 'student')

                        Student

                    @else

                        {{ ucfirst($user->role ?? 'System User') }}

                    @endif

                </span>

            </div>



            {{-- =================================================
                 PROFILE INFORMATION
            ================================================== --}}

            <div class="profile-info">


                {{-- FIRST NAME --}}

                <div class="profile-item">

                    <span class="profile-label">

                        First Name

                    </span>

                    <span class="profile-value">

                        {{ $user->firstname }}

                    </span>

                </div>



                {{-- MIDDLE NAME --}}

                <div class="profile-item">

                    <span class="profile-label">

                        Middle Name

                    </span>

                    <span class="profile-value">

                        {{ $user->middlename ?: 'Not provided' }}

                    </span>

                </div>



                {{-- LAST NAME --}}

                <div class="profile-item">

                    <span class="profile-label">

                        Last Name

                    </span>

                    <span class="profile-value">

                        {{ $user->lastname }}

                    </span>

                </div>



                {{-- EMAIL --}}

                <div class="profile-item">

                    <span class="profile-label">

                        Email

                    </span>

                    <span class="profile-value">

                        {{ $user->email }}

                    </span>

                </div>



                {{-- PHONE --}}

                <div class="profile-item">

                    <span class="profile-label">

                        Phone

                    </span>

                    <span class="profile-value">

                        {{ $user->phone ?: 'Not provided' }}

                    </span>

                </div>



                {{-- STUDENT REGISTRATION NUMBER --}}

                @if($guard === 'student')

                    <div class="profile-item">

                        <span class="profile-label">

                            Registration Number

                        </span>

                        <span class="profile-value">

                            {{ $user->reg_number }}

                        </span>

                    </div>

                @endif



                {{-- SYSTEM USER ROLE --}}

                @if($guard === 'web')

                    <div class="profile-item">

                        <span class="profile-label">

                            Role

                        </span>

                        <span class="profile-value">

                            {{ ucfirst($user->role ?? 'System User') }}

                        </span>

                    </div>

                @endif



                {{-- ACCOUNT ID --}}

                <div class="profile-item">

                    <span class="profile-label">

                        Account ID

                    </span>

                    <span class="profile-value">

                        #{{ $user->id }}

                    </span>

                </div>


            </div>



            {{-- =================================================
                 EDIT PROFILE BUTTON
            ================================================== --}}

            <div class="mt-4">

                <button
                    type="button"
                    class="edit-profile-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#editProfileModal"
                >

                    <i class="bi bi-pencil-square me-1"></i>

                    Edit Profile

                </button>

            </div>


        </div>



        {{-- =================================================
             PASSWORD CARD
        ================================================== --}}

        <div class="settings-card">


            <div class="card-header-custom">

                <div
                    class="card-icon"
                    style="background:#fef3c7;color:#d97706;"
                >

                    <i class="bi bi-shield-lock"></i>

                </div>

                <div>

                    <h5>
                        Change Password
                    </h5>

                    <p>
                        Update your account password
                    </p>

                </div>

            </div>



            <form
                action="{{ route('settings.password') }}"
                method="POST"
                id="passwordForm"
            >

                @csrf

                @method('PUT')


                {{-- CURRENT PASSWORD --}}

                <div class="form-group">

                    <label class="form-label-custom">

                        Current Password

                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="current_password"
                            id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            placeholder="Enter current password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'current_password',
                                this
                            )"
                        >

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>


                    @error('current_password')

                        <div class="text-danger small mt-1">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- NEW PASSWORD --}}

                <div class="form-group">

                    <label class="form-label-custom">

                        New Password

                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter new password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'password',
                                this
                            )"
                        >

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>


                    @error('password')

                        <div class="text-danger small mt-1">

                            {{ $message }}

                        </div>

                    @enderror

                </div>



                {{-- CONFIRM PASSWORD --}}

                <div class="form-group">

                    <label class="form-label-custom">

                        Confirm New Password

                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Confirm new password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'password_confirmation',
                                this
                            )"
                        >

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                </div>



                {{-- PASSWORD INFO --}}

                <div class="password-info">

                    <div>

                        <i class="bi bi-check2"></i>

                        Password must contain at least 8 characters.

                    </div>

                    <div>

                        <i class="bi bi-check2"></i>

                        New password must be different from the old password.

                    </div>

                    <div>

                        <i class="bi bi-check2"></i>

                        Make sure you remember your new password.

                    </div>

                </div>



                {{-- PASSWORD BUTTON --}}

                <button
                    type="submit"
                    class="update-password-btn"
                    id="updatePasswordButton"
                >

                    <i class="bi bi-shield-check me-1"></i>

                    Update Password

                </button>


            </form>


        </div>


    </div>


</div>



{{-- =========================================================
     EDIT PROFILE MODAL
========================================================= --}}

<div
    class="modal fade"
    id="editProfileModal"
    tabindex="-1"
    aria-labelledby="editProfileModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow">


            {{-- MODAL HEADER --}}

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title fw-bold"
                        id="editProfileModalLabel"
                    >

                        <i class="bi bi-person-gear text-primary me-2"></i>

                        Edit My Profile

                    </h5>

                    <small class="text-muted">

                        Update your personal account information

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>



            {{-- =================================================
                 PROFILE FORM
            ================================================== --}}

            <form
                action="{{ route('settings.profile') }}"
                method="POST"
                id="profileForm"
            >

                @csrf

                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">


                        {{-- FIRST NAME --}}

                        <div class="col-md-4">

                            <label class="form-label fw-semibold">

                                First Name

                            </label>

                            <input
                                type="text"
                                name="firstname"
                                class="form-control @error('firstname') is-invalid @enderror"
                                value="{{ old('firstname', $user->firstname) }}"
                                placeholder="First name"
                                required
                            >

                            @error('firstname')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- MIDDLE NAME --}}

                        <div class="col-md-4">

                            <label class="form-label fw-semibold">

                                Middle Name

                            </label>

                            <input
                                type="text"
                                name="middlename"
                                class="form-control @error('middlename') is-invalid @enderror"
                                value="{{ old('middlename', $user->middlename) }}"
                                placeholder="Middle name"
                            >

                            @error('middlename')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- LAST NAME --}}

                        <div class="col-md-4">

                            <label class="form-label fw-semibold">

                                Last Name

                            </label>

                            <input
                                type="text"
                                name="lastname"
                                class="form-control @error('lastname') is-invalid @enderror"
                                value="{{ old('lastname', $user->lastname) }}"
                                placeholder="Last name"
                                required
                            >

                            @error('lastname')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- EMAIL --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Email Address

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                placeholder="Email address"
                                required
                            >

                            @error('email')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- PHONE --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Phone Number

                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="Phone number"
                            >

                            @error('phone')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- =================================================
                             STUDENT REGISTRATION NUMBER
                        ================================================== --}}

                        @if($guard === 'student')

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Registration Number

                                </label>

                                <input
                                    type="text"
                                    class="form-control profile-readonly"
                                    value="{{ $user->reg_number }}"
                                    readonly
                                >

                                <small class="text-muted">

                                    Registration number cannot be changed here.

                                </small>

                            </div>

                        @endif



                        {{-- =================================================
                             SYSTEM USER ROLE
                        ================================================== --}}

                        @if($guard === 'web')

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Role

                                </label>

                                <input
                                    type="text"
                                    class="form-control profile-readonly"
                                    value="{{ ucfirst($user->role ?? 'System User') }}"
                                    readonly
                                >

                                <small class="text-muted">

                                    Your role cannot be changed from your profile.

                                </small>

                            </div>

                        @endif


                    </div>

                </div>



                {{-- =================================================
                     MODAL FOOTER
                ================================================== --}}

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >

                        <i class="bi bi-x-circle me-1"></i>

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="updateProfileButton"
                    >

                        <i class="bi bi-check-circle me-1"></i>

                        Update Profile

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>



{{-- =========================================================
     SWEETALERT
========================================================= --}}

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



{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>


/*
|--------------------------------------------------------------------------
| TOGGLE PASSWORD
|--------------------------------------------------------------------------
*/

function togglePassword(inputId, button)
{

    const input =
        document.getElementById(inputId);

    const icon =
        button.querySelector('i');


    if(input.type === 'password'){

        input.type = 'text';

        icon.classList.remove(
            'bi-eye'
        );

        icon.classList.add(
            'bi-eye-slash'
        );

    }else{

        input.type = 'password';

        icon.classList.remove(
            'bi-eye-slash'
        );

        icon.classList.add(
            'bi-eye'
        );

    }

}



/*
|--------------------------------------------------------------------------
| PROFILE UPDATE LOADING
|--------------------------------------------------------------------------
*/

const profileForm =
    document.getElementById('profileForm');


if(profileForm){

    profileForm.addEventListener(
        'submit',
        function(){

            const button =
                document.getElementById(
                    'updateProfileButton'
                );


            button.disabled = true;


            button.innerHTML =
                '<span class="spinner-border spinner-border-sm me-1"></span>' +
                'Updating Profile...';

        }
    );

}



/*
|--------------------------------------------------------------------------
| PASSWORD UPDATE LOADING
|--------------------------------------------------------------------------
*/

const passwordForm =
    document.getElementById('passwordForm');


if(passwordForm){

    passwordForm.addEventListener(
        'submit',
        function(){

            const button =
                document.getElementById(
                    'updatePasswordButton'
                );


            button.disabled = true;


            button.innerHTML =
                '<span class="spinner-border spinner-border-sm me-1"></span>' +
                'Updating Password...';

        }
    );

}

</script>



{{-- =========================================================
     OPEN PROFILE MODAL AFTER VALIDATION ERROR
========================================================= --}}

@if(
    $errors->has('firstname') ||
    $errors->has('middlename') ||
    $errors->has('lastname') ||
    $errors->has('email') ||
    $errors->has('phone')
)

<script>

document.addEventListener(
    'DOMContentLoaded',
    function(){

        const modalElement =
            document.getElementById(
                'editProfileModal'
            );


        if(modalElement){

            const modal =
                new bootstrap.Modal(
                    modalElement
                );

            modal.show();

        }

    }
);

</script>

@endif


@endsection