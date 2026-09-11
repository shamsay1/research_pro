<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Research Tracking System</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        /* ==========================
   GOOGLE FONT
========================== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

/* ==========================
   RESET
========================== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background: lightblue;
    min-height:100vh;
}

/* ==========================
   MAIN CONTAINER
========================== */
.login-container{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* ==========================
   LOGIN CARD
========================== */
.login-box{
    width:100%;
    max-width:800px;
    height:490px;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 15px 35px rgba(0,0,0,.12);
}

/* ==========================
   LEFT SIDE
========================== */
.left-section{
    position:relative;
    height:560px;
    background:url("https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80");
    background-size:cover;
    background-position:center;
}

.overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(rgba(13,31,64,.85),rgba(37,99,235,.75));
}

.left-content{
    position:relative;
    z-index:2;
    height:100%;
    color:#fff;
    padding:35px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:22px;
    font-weight:700;
}

.logo i{
    font-size:28px;
}

.left-text h1{
    font-size:36px;
    line-height:1.2;
    margin-bottom:18px;
}

.left-text p{
    font-size:14px;
    line-height:1.7;
    color:rgba(255,255,255,.85);
    margin-bottom:22px;
}

.features{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.feature{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:14px;
}

.feature i{
    color:#8bffb4;
}

.copyright-left{
    font-size:12px;
    color:rgba(255,255,255,.7);
}

/* ==========================
   RIGHT SIDE
========================== */
.right-section{
    display:flex;
    align-items:center;
    background:#fff;
}

.login-form-container{
    width:100%;
    padding:40px 50px;
}

.mobile-logo{
    display:none;
}

.welcome{
    margin-bottom:25px;
}

.welcome h2{
    font-size:27px;
    color:#0f172a;
    font-weight:700;
}

.welcome p{
    font-size:13px;
    color:#64748b;
}

/* ==========================
   FORM
========================== */
.form-label{
    font-size:13px;
    font-weight:600;
    color:#334155;
}

.password-label{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.forgot-password{
    text-decoration:none;
    font-size:12px;
    color:#2563eb;
    font-weight:500;
}

.forgot-password:hover{
    text-decoration:underline;
}

.custom-input{
    height:48px;
}

.custom-input .input-group-text{
    background:#f8fafc;
    border:1px solid #dbe3ec;
    color:#64748b;
}

.custom-input .form-control{
    border:1px solid #dbe3ec;
    background:#f8fafc;
    font-size:14px;
}

.custom-input .form-control:focus{
    background:#fff;
    border-color:#2563eb;
    box-shadow:none;
}

.custom-input:focus-within .input-group-text{
    border-color:#2563eb;
    color:#2563eb;
}

.password-toggle{
    cursor:pointer;
}

.remember-row{
    margin:18px 0 22px;
}

.form-check-label{
    font-size:13px;
    color:#64748b;
}

.form-check-input:checked{
    background:#2563eb;
    border-color:#2563eb;
}

#errorMessage{
    font-size:13px;
    border-radius:8px;
}

/* ==========================
   BUTTON
========================== */
.login-btn{
    height:48px;
    background:#2563eb;
    border:none;
    color:#fff;
    font-size:14px;
    font-weight:600;
    border-radius:8px;
    transition:.3s;
}

.login-btn:hover{
    background:#1d4ed8;
    transform:translateY(-2px);
    box-shadow:0 10px 18px rgba(37,99,235,.25);
}

.login-footer{
    text-align:center;
    margin-top:10px;
}

.login-footer p{
    font-size:12px;
    color:#64748b;
    margin-bottom:3px;
}

.login-footer span{
    font-size:11px;
    color:#94a3b8;
}

/* ==========================
   TABLET
========================== */
@media(max-width:992px){

    .login-box{
        max-width:760px;
        height:520px;
    }

    .left-section{
        height:520px;
    }

    .left-content{
        padding:28px;
    }

    .left-text h1{
        font-size:30px;
    }

    .login-form-container{
        padding:35px;
    }

}

/* ==========================
   MOBILE
========================== */
@media(max-width:768px){

    .login-container{
        padding:0;
    }

    .login-box{
        max-width:100%;
        height:100vh;
        border-radius:0;
        box-shadow:none;
    }

    .left-section{
        display:none;
    }

    .right-section{
        min-height:100vh;
        justify-content:center;
    }

    .login-form-container{
        max-width:420px;
        padding:30px 24px;
    }

    .mobile-logo{
        display:flex;
        flex-direction:column;
        align-items:center;
        margin-bottom:28px;
    }

    .mobile-logo-icon{
        width:58px;
        height:58px;
        border-radius:14px;
        background:#e8f0ff;
        color:#2563eb;
        display:flex;
        justify-content:center;
        align-items:center;
        font-size:28px;
        margin-bottom:10px;
    }

    .mobile-logo h4{
        font-size:18px;
        color:#0f172a;
        font-weight:700;
        text-align:center;
    }

    .welcome{
        text-align:center;
    }

    .welcome h2{
        font-size:24px;
    }

}

/* ==========================
   SMALL PHONE
========================== */
@media(max-width:400px){

    .login-form-container{
        padding:24px 18px;
    }

    .welcome h2{
        font-size:22px;
    }

    .welcome p{
        font-size:12px;
    }

}
    </style>
</head>

<body>

<div class="login-container">

    <div class="row g-0 login-box">

        <!-- ================= LEFT SIDE ================= -->
        <div class="col-lg-6 left-section">

            <div class="overlay"></div>

            <div class="left-content">

                <div class="logo">
                    <i class="bi bi-mortarboard-fill"></i>
                    <span>RSTS</span>
                </div>

                <div class="left-text">

                    <h1>
                        Research Supervision Tracking System
                    </h1>

                    <p>
                        Manage, track and monitor your research
                        journey from proposal to completion.
                    </p>

                    <div class="features">

                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Track Research Progress</span>
                        </div>

                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Manage Research Projects</span>
                        </div>

                        <div class="feature">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Monitor Submission Status</span>
                        </div>

                    </div>

                </div>

                <div class="copyright-left">
                    © 2026 Research Tracking System
                </div>

            </div>

        </div>


        <!-- ================= RIGHT SIDE ================= -->
        <div class="col-lg-6 right-section">

            <div class="login-form-container">

                <div class="mobile-logo">
                    <div class="mobile-logo-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>

                    <h4>Research Supervision Tracking System</h4>
                </div>


                <div class="welcome">
                    <div style="text-align: center">
                    <img src="{{ asset('images/ipalogo1.png') }}" width="100px" height="80px" style="float: center">
                    </div>
                    <h3 style="text-align: center;color: green;font-family: 'Times New Roman', Times, serif;font-size: 16px">INSTITUTE OF PUBLIC<br>ADMINISTRATION</h3>

                </div>


                <!-- Login Form -->
                <p style="text-align: center">
                    @if(session('error'))
                    <span style="color: red">{{ session('error') }}</span>
                    @endif
                </p>
                <p style="text-align: center">
                    @if(session('success'))
                    <span style="color: green">{{ session('success') }}</span>
                    @endif
                </p>
               <form action="{{ route('login') }}" method="POST">

    @csrf

    <!-- Email -->
    <div class="mb-4">

        <label for="email" class="form-label">
            Email Address
        </label>

        <div class="input-group custom-input">

            <span class="input-group-text">
                <i class="bi bi-envelope"></i>
            </span>

            <input
                type="email"
                class="form-control"
                name="email"
                placeholder="Enter your email"
                required
            >

        </div>

    </div>


    <!-- Password -->
    <div class="mb-3">

        <div class="password-label">

            <label for="password" class="form-label">
                Password
            </label>

            <a href="{{ route('forgot') }}" class="forgot-password">
                Forgot Password?
            </a>

        </div>

        <div class="input-group custom-input">

            <span class="input-group-text">
                <i class="bi bi-lock"></i>
            </span>

            <input
                type="password"
                class="form-control"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button
                type="submit"
                class="input-group-text password-toggle"
            >
                <i class="bi bi-eye" id="eyeIcon"></i>
            </button>

        </div>

    </div>


    <!-- Error -->
    <div
        id="errorMessage"
        class="alert alert-danger d-none"
    >
        <i class="bi bi-exclamation-circle"></i>
        <span id="errorText">
            Invalid email or password.
        </span>
    </div>


    <!-- Login Button -->
    <button
        type="submit"
        class="btn login-btn w-100"
        id="loginButton"
    >

        <span id="loginText">
            Login
        </span>

        <span
            id="loadingSpinner"
            class="spinner-border spinner-border-sm d-none"
        ></span>

        <i
            class="bi bi-arrow-right ms-2"
            id="loginIcon"
        ></i>

    </button>

</form>


                <!-- Footer -->
                <div class="login-footer">

                    <p>
                        © 2026 Research Tracking System v.1.0.0
                    </p>

            

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>



</body>
</html>