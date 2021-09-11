<?php
    session_start();
    include('../inc/server.php');
    include('../inc/header.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="login_db.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="username" placeholder="name@example.com" />
                                                <label for="username" >Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
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
                                            <!-- <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div> -->
                                            <div  class="d-flex justify-content-center mt-4 mb-0">
                                                <!-- <a class="small" href=""></a> -->
                                                <button type="submit" name="login_user" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        <?php include('../inc/footer.php');?>
