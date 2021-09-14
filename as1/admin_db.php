<?php 
    session_start();
    // include('db_conection.php');
    include('../inc/server.php');
    $errors = array();

    if (isset($_POST['admin_log'])) {
       
        $startdate = mysqli_real_escape_string($conn, $_POST['startdate']);
        $enddate = mysqli_real_escape_string($conn, $_POST['enddate']);
        // echo '<script>';
        // echo 'console.log('. $startdate .')';
        // echo '</script>';
        // echo '<script>';
        // echo 'console.log('. $enddate .')';
        // echo '</script>';
        // // echo $startdate;
        // // echo $enddate;
        // if ($startdate == ' ') {
        //     $_SESSION['startdate'] = "emty";
        //     $_SESSION['enddate'] = "emty";
        //     header("location: admin-log.php");
       
        // }elseif{
        //     $_SESSION['startdate'] = $startdate;
        //     $_SESSION['enddate'] = $enddate;
        //     header("location: admin-log.php");
        // }
        
        unset($_SESSION['startdate']);
        unset($_SESSION['enddate']);

        if ($startdate == ' ') {
            array_push($errors, "Start date is required");
        }
        if ($enddate == '') {
            array_push($errors, "End date is required");
        }

        if (count($errors) == 0) {
            $_SESSION['startdate'] = $startdate;
            $_SESSION['enddate'] = $enddate;
            header("location: admin-log.php");
        }else{
            // $_SESSION['startdate'] = "emty";
            // $_SESSION['enddate'] = "emty";
            header("location: admin-log.php");
        }
    }

?>