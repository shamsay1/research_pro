<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Verify Token</title>

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

        .token-card {
            width:100%;
            max-width:450px;
            background:white;
            padding:35px;
            border-radius:20px;
            box-shadow:0 10px 40px rgba(0,0,0,.08);
        }

        .token-icon {
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

        .token-input {
            width:70px;
            height:70px;
            text-align:center;
            font-size:28px;
            font-weight:bold;
            border-radius:10px;
        }

        .verify-btn {
            height:50px;
            border-radius:10px;
            font-weight:600;
        }

    </style>

</head>

<body>

<div class="token-card">

    <div class="text-center mb-4">

        <div class="token-icon mb-3">

            <i class="bi bi-shield-lock"></i>

        </div>

        <h4 class="fw-bold">
            Verify Token
        </h4>

        <p class="text-muted">
            Enter the 4-digit token sent to your email.
        </p>

    </div>


    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            {{ $errors->first() }}

        </div>

    @endif


    <form
        action="{{ route('forgot.password.verify.token') }}"
        method="POST"
        id="tokenForm"
    >

        @csrf


        <div class="d-flex justify-content-center gap-2 mb-4">

            <input
                type="text"
                maxlength="1"
                class="form-control token-input"
                id="token1"
                inputmode="numeric"
                autocomplete="one-time-code"
                required
            >

            <input
                type="text"
                maxlength="1"
                class="form-control token-input"
                id="token2"
                inputmode="numeric"
                required
            >

            <input
                type="text"
                maxlength="1"
                class="form-control token-input"
                id="token3"
                inputmode="numeric"
                required
            >

            <input
                type="text"
                maxlength="1"
                class="form-control token-input"
                id="token4"
                inputmode="numeric"
                required
            >

        </div>


        <input
            type="hidden"
            name="token"
            id="fullToken"
        >


        <button
            type="submit"
            class="btn btn-success verify-btn w-100"
            id="verifyButton"
        >

            <span id="verifyText">
                Verify Token
            </span>

            <span
                id="verifySpinner"
                class="spinner-border spinner-border-sm d-none"
            ></span>

            <i
                class="bi bi-check2 ms-2"
                id="verifyIcon"
            ></i>

        </button>

    </form>


    <div class="text-center mt-4">

        <a
            href="{{ route('forgot') }}"
            class="text-decoration-none"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Request new token

        </a>

    </div>

</div>


<script>

    const inputs = document.querySelectorAll('.token-input');

    inputs.forEach(function(input, index) {

        input.addEventListener('input', function() {

            this.value = this.value.replace(/\D/g, '');

            if (this.value && index < inputs.length - 1) {

                inputs[index + 1].focus();

            }

        });


        input.addEventListener('keydown', function(event) {

            if (
                event.key === 'Backspace' &&
                !this.value &&
                index > 0
            ) {

                inputs[index - 1].focus();

            }

        });

    });


    document
        .getElementById('tokenForm')
        .addEventListener('submit', function(event) {

            let token = '';

            inputs.forEach(function(input) {

                token += input.value;

            });


            if (token.length !== 4) {

                event.preventDefault();

                alert('Please enter all 4 digits.');

                return;

            }


            document
                .getElementById('fullToken')
                .value = token;


            document
                .getElementById('verifyButton')
                .disabled = true;


            document
                .getElementById('verifyText')
                .textContent = 'Verifying...';


            document
                .getElementById('verifySpinner')
                .classList.remove('d-none');


            document
                .getElementById('verifyIcon')
                .classList.add('d-none');

        });

</script>

</body>

</html>