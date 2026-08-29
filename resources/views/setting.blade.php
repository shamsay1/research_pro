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
   BUTTON
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
   RESPONSIVE
========================================================= */

@media(max-width:768px){

    .settings-grid{
        grid-template-columns:1fr;
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
         SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success custom-alert">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
         ERROR
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


            {{-- PROFILE TOP --}}

            <div class="profile-top">


                <div class="profile-avatar">

                    @php

                        $name =
                            $user->name
                            ?? $user->full_name
                            ?? 'U';

                        $words =
                            preg_split(
                                '/\s+/',
                                trim($name)
                            );

                        $initials = '';

                        foreach(array_slice($words, 0, 2) as $word){

                            $initials .=
                                strtoupper(
                                    substr($word, 0, 1)
                                );

                        }

                    @endphp


                    {{ $initials ?: 'U' }}

                </div>


                <div class="profile-name">

                    {{ $name }}

                </div>


                <span class="profile-role">

                    @if($guard === 'student')

                        Student

                    @else

                        {{ $user->role ?? 'System User' }}

                    @endif

                </span>

            </div>


            {{-- PROFILE INFORMATION --}}

            <div class="profile-info">


                {{-- NAME --}}

                <div class="profile-item">

                    <span class="profile-label">

                        Full Name

                    </span>

                    <span class="profile-value">

                        {{ $name }}

                    </span>

                </div>


                {{-- EMAIL --}}

                <div class="profile-item">

                    <span class="profile-label">

                        Email

                    </span>

                    <span class="profile-value">

                        {{ $user->email ?? 'Not provided' }}

                    </span>

                </div>


                {{-- STUDENT ID --}}

                @if($guard === 'student')

                    <div class="profile-item">

                        <span class="profile-label">

                            Student ID

                        </span>

                        <span class="profile-value">

                            {{ $user->student_id ?? $user->registration_number ?? $user->id }}

                        </span>

                    </div>

                @endif


                {{-- ROLE --}}

                @if($guard === 'web')

                    <div class="profile-item">

                        <span class="profile-label">

                            Role

                        </span>

                        <span class="profile-value">

                            {{ $user->role ?? 'System User' }}

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
                            onclick="togglePassword('current_password', this)"
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
                            onclick="togglePassword('password', this)"
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


                {{-- BUTTON --}}

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
| Toggle Password
|--------------------------------------------------------------------------
*/

function togglePassword(
    inputId,
    button
){

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
| Password Submit Loading
|--------------------------------------------------------------------------
*/

document
    .getElementById('passwordForm')
    .addEventListener(
        'submit',
        function(){

            const button =
                document.getElementById(
                    'updatePasswordButton'
                );

            button.disabled = true;

            button.innerHTML =
                '<span class="spinner-border spinner-border-sm me-1"></span>'
                + 'Updating Password...';

        }
    );

</script>

@endsection