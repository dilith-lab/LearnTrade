<?php
session_start();
require_once '../config/config.inc.php';
include "../models/db.model.php";
include "../controllers/login.contr.php";

// Function to handle login success
function handleLoginSuccess($fetch)
{
  $_SESSION['user_id'] = $fetch['user_id'];
  $_SESSION['email'] = $fetch['email'];
  $_SESSION['first_name'] = $fetch['fname'];
  $_SESSION['last_name'] = $fetch['lname'];
  $_SESSION['mobile'] = $fetch['mobile'];
  $_SESSION['role_id'] = $fetch['role_id'];
  $_SESSION['role_name'] = $fetch['role_name'];
  $_SESSION['account_status'] = $fetch['account_status'];
  $_SESSION['created_at'] = $fetch['created_at'];

  switch ($_SESSION['account_status']) {
    case 1:
      header('location: change-password.php');
      break;
    case 2:
      header('location: index.php');
      break;
    case 0:
    default:
      return [
        'status_code' => 400,
        'message' => 'Invalid account status.'
      ];
  }

  return [
    'status_code' => 100,
    'message' => 'User logged in successfully.'
  ];
}

// Function to handle errors
function handleError($status_code, $message)
{
  return [
    'status_code' => $status_code,
    'message' => $message
  ];
}

// Display message if passed via GET parameters
if (isset($_GET['status_code']) && isset($_GET['message'])) {
  $status_code = base64_decode($_GET['status_code']);
  $message = base64_decode($_GET['message']);
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? null;
  $password = $_POST['password'] ?? null;
  $password_hash = hash('SHA384', $password);

  if (!empty($email) && !empty($password)) {
    $loginModel = new Login();  // Instantiate the Login model
    $loginContr = new LoginContr($loginModel);  // Pass the model instance to the controller

    $fetch = $loginContr->checkCredentials($email, $password_hash);

    if ($fetch) {
      // Handle successful login
      $response = handleLoginSuccess($fetch);
    } else {
      // Handle invalid credentials
      $response = handleError(400, "Invalid username or password.");
    }
  } else {
    // Handle missing email or password
    $response = handleError(400, "Username or password cannot be blank.");
  }

  // Set the status code and message for display
  $status_code = $response['status_code'];
  $message = $response['message'];
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
        <a href="./index.php" class="h1"><b><?php echo APP_NAME; ?></b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Login</p>
        <form action="./login.php" id="login" method="post">
          <div class="form-group input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" id="email" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
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
          <div class="row mb-3">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
        <?php if (ACC_RECOVERY): ?>
          <p class="mb-1"><a href="./forgot-password.php">Forgot password</a></p>
        <?php endif; ?>
        <?php if (ACC_REGISTRATION): ?>
          <p class="mb-0"><a href="./register.php" class="text-center">Register a new account</a></p>
        <?php endif; ?>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- Scripts -->
  <?php
  //include("./includes/scripts.inc.php")
  ?>
</body>

</html>