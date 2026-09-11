<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Forgot Password</title>

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
            min-height: 100vh;
            background: #f4f7fb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .forgot-card {
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,.08);
        }

        .forgot-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #eaf7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 30px;
        }

        .custom-input .form-control,
        .custom-input .input-group-text {
            height: 50px;
            border-color: #dee2e6;
        }

        .custom-input .input-group-text {
            background: #f8f9fa;
        }

        .login-btn {
            height: 50px;
            border-radius: 10px;
            font-weight: 600;
        }

        .type-card {
            cursor: pointer;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px;
            transition: .2s;
        }

        .type-card:hover {
            border-color: #198754;
        }

        .type-card.active {
            border-color: #198754;
            background: #f0faf4;
        }

        .type-card input {
            display: none;
        }

    </style>

</head>

<body>

<div class="forgot-card">

    <div class="text-center mb-4">

        <div class="forgot-icon mb-3">

            <i class="bi bi-key"></i>

        </div>

        <h4 class="fw-bold mb-2">
            Forgot Password?
        </h4>

        <p class="text-muted mb-0">
            Select your account type and enter your email
            to receive a verification token.
        </p>

    </div>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- ERROR MESSAGE --}}

    @if(session('error'))

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- VALIDATION ERRORS --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('forgot.password.send') }}"
        method="POST"
        id="forgotPasswordForm"
    >

        @csrf


        {{-- ACCOUNT TYPE --}}

        <label class="form-label fw-semibold mb-2">
            Account Type
        </label>


        <div class="row g-2 mb-3">


            {{-- STUDENT --}}

            <div class="col-6">

                <label
                    class="type-card w-100 active"
                    id="studentCard"
                >

                    <input
                        type="radio"
                        name="user_type"
                        value="student"
                        checked
                    >

                    <div class="text-center">

                        <i class="bi bi-mortarboard fs-3 text-success"></i>

                        <div class="fw-semibold mt-1">
                            Student
                        </div>

                    </div>

                </label>

            </div>


            {{-- ADMIN/SUPERVISOR --}}

            <div class="col-6">

                <label
                    class="type-card w-100"
                    id="staffCard"
                >

                    <input
                        type="radio"
                        name="user_type"
                        value="staff"
                    >

                    <div class="text-center">

                        <i class="bi bi-person-badge fs-3 text-primary"></i>

                        <div class="fw-semibold mt-1">
                            Admin / Supervisor
                        </div>

                    </div>

                </label>

            </div>

        </div>


        {{-- EMAIL --}}

        <div class="mb-4">

            <label
                for="email"
                class="form-label fw-semibold"
            >
                Email
            </label>

            <div class="input-group custom-input">

                <span class="input-group-text">

                    <i class="bi bi-envelope"></i>

                </span>

                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    placeholder="Enter your email"
                    value="{{ old('email') }}"
                    required
                >

            </div>

        </div>


        {{-- BUTTON --}}

        <button
            type="submit"
            class="btn btn-success login-btn w-100"
            id="sendButton"
        >

            <span id="buttonText">
                Send Token
            </span>

            <span
                id="buttonSpinner"
                class="spinner-border spinner-border-sm d-none"
            ></span>

            <i
                class="bi bi-arrow-right ms-2"
                id="buttonIcon"
            ></i>

        </button>


    </form>


    <div class="text-center mt-4">

        <a
            href="{{ route('login1') }}"
            class="text-decoration-none"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Back to login

        </a>

    </div>

</div>


<script>

    const studentCard = document.getElementById('studentCard');
    const staffCard = document.getElementById('staffCard');

    const radios = document.querySelectorAll(
        'input[name="user_type"]'
    );


    radios.forEach(function(radio) {

        radio.addEventListener('change', function() {

            studentCard.classList.remove('active');
            staffCard.classList.remove('active');


            if (this.value === 'student') {

                studentCard.classList.add('active');

            } else {

                staffCard.classList.add('active');

            }

        });

    });


    document
        .getElementById('forgotPasswordForm')
        .addEventListener('submit', function() {

            document
                .getElementById('sendButton')
                .disabled = true;

            document
                .getElementById('buttonText')
                .textContent = 'Sending...';

            document
                .getElementById('buttonSpinner')
                .classList.remove('d-none');

            document
                .getElementById('buttonIcon')
                .classList.add('d-none');

        });

</script>

</body>
</html>