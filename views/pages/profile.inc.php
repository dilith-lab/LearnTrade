<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="../dist/img/default-user.png" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?php if (isset($_SESSION['first_name']))
                                                                            echo $_SESSION['first_name'] . " " . $_SESSION['last_name']  ?></h3>

                            <p class="text-muted text-center"><?php if (isset($_SESSION['role_name']))
                                                                    echo $_SESSION['role_name'];  ?></p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Account Status</b> <a class="float-right">Active</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Date of Join</b> <a class="float-right"><?php if (isset($_SESSION['created_at']))
                                                                    echo date_format(new DateTime($_SESSION['created_at']),"d F Y");  ?></a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="settings">
                                    <form class="form-horizontal" name="profile" id="profile" method="post" action="./profile.php">
                                        <div class="row">
                                            <label for="inputName" class="col-sm-2 col-form-label">First Name</label>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php if (isset($_SESSION['first_name'])) echo $_SESSION['first_name'];  ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php if (isset($_SESSION['last_name'])) echo $_SESSION['last_name'];  ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="form-group col-sm-10">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email'];  ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="<?php if (isset($_SESSION['mobile'])) echo $_SESSION['mobile'];  ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="role" class="col-sm-2 col-form-label">Role</label>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="role" name="role" placeholder="Role" value="<?php if (isset($_SESSION['role_name'])) echo $_SESSION['role_name'];  ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group offset-sm-2 col-sm-10">
                                                <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == '1') : ?>
                                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-secondary float-right" onclick="goBack()">Close</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->