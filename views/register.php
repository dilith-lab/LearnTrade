<?php
session_start();
require_once '../config/config.inc.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['account_status'] == 2) {
        header('location: index.php');
        exit();
    }
}
include "../models/db.model.php";
include "../controllers/register.contr.php";

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
        if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {

            // Retrieve the inputs from the registration form
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            if (!empty($fname) && !empty($lname) && !empty($email) && !empty($mobile) && !empty($password) && !empty($password_confirm)) {

                if ($password !== $password_confirm) {
                    $status_code = 400;
                    $message = "Passwords do not match.";
                } else {
                    $password_hash = hash('SHA384', $password);  // Use hashing for password security

                    // Pass the Register model to the controller
                    $registerModel = new Register();
                    $registerContr = new RegisterContr($registerModel);

                    // Check if the email already exists and register the user
                    $result = $registerContr->register($fname, $lname, $email, $mobile, $password_hash);

                    if ($result['status_code'] === 100) {
                        $status_code = base64_encode(100);
                        $message = base64_encode($result['message']);
                        header("Location: login.php?status_code={$status_code}&message={$message}");
                        exit();
                    } else {
                        $status_code = $result['status_code'];
                        $message = $result['message'];
                    }
                }
            } else {
                $status_code = 400;
                $message = "All fields are required.";
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
        <?php echo APP_NAME; ?> | Register
    </title>
    <link rel="icon" type="image/png" href="../dist/img/rosh-chem-logo.png">
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
                <p class="login-box-msg">Register a new account</p>
                <form action="./register.php" name="register" id="register" method="post">
                    <div class="form-group input-group mb-3">
                        <input type="text" class="form-control" placeholder="First name" name="fname" id="fname">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group input-group mb-3">
                    <input type="text" class="form-control" placeholder="Last name" name="lname" id="lname">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-user"></span>
                        </div>
                    </div>
                    </div>
                    <div class="form-group input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group input-group mb-3">
                        <input type="text" class="form-control" placeholder="Mobile" name="mobile" id="mobile" data-inputmask="&quot;mask&quot;: &quot;0799999999&quot;" data-mask>
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    </div>
                    <div class="form-group input-group mb-3">
                    <input type="password" class="form-control" placeholder="Retype password" name="password_confirm" id="password_confirm">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group input-group mb-3">
                                <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" id="terms" value="agree">
                                <label for="agreeTerms">
                                I agree to the <a href="./terms.md" target="_blank">terms</a>
                                </label>
                            </div>
                            </div>
                        </div>
                    <!-- reCAPTCHA v2 widget -->
                    <div class="g-recaptcha mb-3" data-sitekey="<?php echo GOOGLE_CAPTCHA_SITE; ?>"></div>
                    <!-- /.col -->
                    <div class="col-4 mb-3">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1"><a href="./login.php">Login</a></p>
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