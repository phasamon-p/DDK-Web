<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - DDK Report</title>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <form action="register_db.php" method="post">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" type="text" name="name" placeholder="Enter your first name" />
                                                    <label for="inputFirstName">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="text" name="lastname" placeholder="Enter your last name" />
                                                    <label for="inputLastName">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" name="email" placeholder="example@email.com" />
                                            <label for="email">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUsername" type="text" name="username" placeholder="Enter your username" />
                                            <label for="username">Username</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" type="password" name="password_1" placeholder="Create a password" />
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" type="password" name="password_2" placeholder="Confirm password" />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php include('errors.php'); ?>
                                        <?php if (isset($_SESSION['error'])) : ?>
                                                <div class="error">
                                                    <h6 class="text-danger">
                                                        <?php 
                                                            echo $_SESSION['error'];
                                                            unset($_SESSION['error']);
                                                        ?>
                                                    </h6>
                                                </div>
                                            <?php endif ?>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" name="reg_user" class="btn btn-primary btn-block">Create Account</button>
                                                <!-- <a class="btn btn-primary btn-block" href="login.html">Create Account</a> -->
                                            </div>
                                        </div>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a href="../index.php">Dashboard</a></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include('../inc/footer.php');?>