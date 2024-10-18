<?php
session_start();
require_once '../config/config.inc.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['account_status'] == 2) {
        header('location: index.php');
    }
}
include "../models/db.model.php";
include "../controllers/login.contr.php";

if (isset($_GET['status_code']) && isset($_GET['message'])) {
    $status_code = base64_decode($_GET['status_code']);
    $message = base64_decode($_GET['message']);
}

if (isset($_POST['g-recaptcha-response'])) {
    // Receive the reCAPTCHA v2 response
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Use the secret key for reCAPTCHA v2
    $recaptcha_secret_key = GOOGLE_CAPTCHA_SECRET;

    // Verify the reCAPTCHA response with Google's API
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = array(
        'secret' => $recaptcha_secret_key,
        'response' => $recaptcha_response
    );

    $recaptcha_options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($recaptcha_data)
        )
    );

    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_response_data = json_decode($recaptcha_result, true);

    // Check if reCAPTCHA was successful
    if ($recaptcha_response_data['success']) {
        // reCAPTCHA passed, proceed with the rest of your form handling logic
        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            if (!empty($email)) {
                $loginModel = new Login;
                $loginContr = new LoginContr($loginModel);
                
                try {
                    $fetch = $loginContr->checkEmail($email);
                    if ($fetch) {
                        $user_id = $fetch['user_id'];
                        $passwordResetToken = $loginContr->createPasswordResetReq($user_id);
                        $template = file_get_contents('password-reset-template.php');
                        $loginContr->sendMail($template, $email, $passwordResetToken);
                    }
                } catch (\Throwable $th) {
                    $status_code = 400;
                    $message = "Request failed.";
                }
                $status_code = 100;
                $message = "Password reset link sent to your email.";
            } else {
                $status_code = 400;
                $message = "Email cannot be blank.";
            }
        }
    } else {
        // reCAPTCHA verification failed
        $status_code = 400;
        $message = "reCAPTCHA verification failed.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo APP_NAME; ?> | Forgot Password
    </title>
    <link rel="icon" type="image/png" href="<?php echo APP_LOGO; ?>">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="lockscreen-logo">
            <img src="<?php echo APP_LOGO; ?>" alt="<?php echo APP_NAME; ?> Logo" width="70px">
        </div>
        <?php if (isset($status_code) && $status_code == 400) : ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                <?php echo $message; ?>
            </div>
        <?php elseif (isset($status_code) && $status_code == 100) : ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="./index.php" class="h1"><b><?php echo APP_NAME; ?></a></b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <form action="./forgot-password.php" name="forgot-password" id="forgot-password" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email" autocomplete="on">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <!-- reCAPTCHA v2 widget -->
                    <div class="g-recaptcha mb-3" data-sitekey="<?php echo GOOGLE_CAPTCHA_SITE; ?>"></div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block" type="submit">Reset password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mt-3 mb-1"><a href="./login.php">Login</a></p>
                <p class="mb-0"><a href="./register.php" class="text-center">Register a new account</a></p>
            </div>
            <!-- /.login-card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- Scripts -->
    <?php
    include("./includes/scripts.inc.php")
    ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>