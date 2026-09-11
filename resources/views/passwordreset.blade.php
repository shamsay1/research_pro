<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Password Reset Token</title>

</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f7fb;
    font-family:Arial, Helvetica, sans-serif;
">

<div style="
    max-width:600px;
    margin:40px auto;
    background:#ffffff;
    padding:35px;
    border-radius:15px;
">

    <h2 style="
        margin-top:0;
        color:#198754;
    ">
        IPA Research Tracking System
    </h2>


    <p>
        Hello <strong>{{ $name }}</strong>,
    </p>


    <p>
        We received a request to reset your password.
    </p>


    <p>
        Your password reset verification token is:
    </p>


    <div style="
        text-align:center;
        margin:30px 0;
    ">

        <span style="
            display:inline-block;
            background:#f0faf4;
            color:#198754;
            font-size:35px;
            font-weight:bold;
            letter-spacing:10px;
            padding:15px 25px;
            border-radius:10px;
        ">

            {{ $token }}

        </span>

    </div>


    <p>
        This token will expire in
        <strong>10 minutes</strong>.
    </p>


    <p>
        If you did not request a password reset,
        please ignore this email.
    </p>


    <hr>


    <p style="
        color:#777;
        font-size:13px;
    ">

        IPA Research Tracking System

    </p>

</div>

</body>

</html>