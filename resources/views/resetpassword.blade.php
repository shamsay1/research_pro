<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reset Password</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            min-height:100vh;
            background:#f4f7fb;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .reset-card {
            width:100%;
            max-width:450px;
            background:#ffffff;
            padding:35px;
            border-radius:20px;
            box-shadow:0 10px 40px rgba(0,0,0,.08);
        }

        .reset-icon {
            width:70px;
            height:70px;
            border-radius:50%;
            background:#eaf7ef;
            color:#198754;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
            font-size:30px;
        }

        .custom-input .input-group-text,
        .custom-input .form-control {
            height:50px;
        }

        .reset-btn {
            height:50px;
            border-radius:10px;
            font-weight:600;
        }

    </style>

</head>

<body>

<div class="reset-card">

    <div class="text-center mb-4">

        <div class="reset-icon mb-3">

            <i class="bi bi-lock"></i>

        </div>

        <h4 class="fw-bold">
            Reset Password
        </h4>

        <p class="text-muted">
            Create a new password for your account.
        </p>

    </div>


    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            {{ $errors->first() }}

        </div>

    @endif


    <form
        action="{{ route('forgot.password.update') }}"
        method="POST"
        id="resetForm"
    >

        @csrf


        {{-- NEW PASSWORD --}}

        <div class="mb-3">

            <label
                class="form-label fw-semibold"
                for="password"
            >
                New Password
            </label>

            <div class="input-group custom-input">

                <span class="input-group-text">

                    <i class="bi bi-lock"></i>

                </span>

                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Enter new password"
                    required
                >

                <button
                    type="button"
                    class="input-group-text"
                    onclick="togglePassword('password', 'eye1')"
                >

                    <i
                        class="bi bi-eye"
                        id="eye1"
                    ></i>

                </button>

            </div>

        </div>


        {{-- CONFIRM PASSWORD --}}

        <div class="mb-4">

            <label
                class="form-label fw-semibold"
                for="password_confirmation"
            >
                Confirm Password
            </label>

            <div class="input-group custom-input">

                <span class="input-group-text">

                    <i class="bi bi-lock-fill"></i>

                </span>

                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirm new password"
                    required
                >

                <button
                    type="button"
                    class="input-group-text"
                    onclick="togglePassword(
                        'password_confirmation',
                        'eye2'
                    )"
                >

                    <i
                        class="bi bi-eye"
                        id="eye2"
                    ></i>

                </button>

            </div>

        </div>


        <button
            type="submit"
            class="btn btn-success reset-btn w-100"
            id="resetButton"
        >

            <span id="resetText">
                Reset Password
            </span>

            <span
                id="resetSpinner"
                class="spinner-border spinner-border-sm d-none"
            ></span>

            <i
                class="bi bi-check-circle ms-2"
                id="resetIcon"
            ></i>

        </button>

    </form>

</div>


<script>

    function togglePassword(inputId, iconId)
    {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);


        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('bi-eye');

            icon.classList.add('bi-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('bi-eye-slash');

            icon.classList.add('bi-eye');

        }
    }


    document
        .getElementById('resetForm')
        .addEventListener('submit', function() {

            document
                .getElementById('resetButton')
                .disabled = true;

            document
                .getElementById('resetText')
                .textContent = 'Updating...';

            document
                .getElementById('resetSpinner')
                .classList.remove('d-none');

            document
                .getElementById('resetIcon')
                .classList.add('d-none');

        });

</script>

</body>

</html>