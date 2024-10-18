<?php
session_start();
require_once '../config/config.inc.php';
include "../models/db.model.php";
include "../controllers/login.contr.php";

$loginModel = new Login; // Instantiate the Login model
$loginContr = new LoginContr($loginModel); // Pass the model instance to the controller

if (!isset($_GET['t'])) {

  # Change password in the first login
  if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
  } else if (isset($_SESSION['status']) && $_SESSION['status'] == 1) {
    header('location: index.php');
  }

  $user_id = $_SESSION['user_id'];
} else {

  # Change password using password reset link

  $token = $_GET['t'];
  $token_validation = $loginContr->checkUIDToken($token);
  #var_dump($token_validation);

  $isValidToken = $token_validation['token_valid'];
  if ($isValidToken) {
    $user_id = $token_validation['user_id'];
  } else {
    $status_code = base64_encode(400);
    $message = base64_encode("Password expire link is expired.");
    header("location: forgot-password.php?status_code='$status_code'&message='$message'");
  }
}

if (isset($_POST['password1']) && isset($_POST['password2'])) {
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];

  if (!empty($password1) && !empty($password1)) {
    if ($password1 == $password2) {
      $password_hash = hash('SHA384', $password1);

      $login_id = $loginContr->changePassword($user_id, $password_hash);
      $verify = $loginContr->changeVerification($user_id);
      $_SESSION['status'] = 2;
      $status_code = 100;
      $message = "Password saved successfully.";
      header('location: index.php');
    } else {
      $status_code = 400;
      $message = "Password and verify password does not match.";
    }
  } else {
    $status_code = 400;
    $message = "Passwords cannot be blank.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php echo APP_NAME; ?> | Log in
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
        <a href="../index.php" class="h1"><b>
            <?php echo APP_NAME; ?></a>
      </div>

      <div class="card-body">
        <p class="login-box-msg">Change password</p>
        <form action="./change-password.php<?php if (isset($token)) echo "?t=$token"; ?>" id="change-password" method="post">
          <div class="form-group input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password1" id="password1">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="form-group input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirm Password" name="password2" id="password2">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Change password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="./login.php">Login</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <?php
  include("./includes/scripts.inc.php")
  ?>
</body>

</html>