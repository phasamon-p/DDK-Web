<?php 
    session_start();
    // include('db_conection.php');
    include('../inc/server.php');
    $errors = array();

    if (isset($_POST['admin_log'])) {
       
        $startdate = mysqli_real_escape_string($conn, $_POST['startdate']);
        $enddate = mysqli_real_escape_string($conn, $_POST['enddate']);
        
        unset($_SESSION['startdate']);
        unset($_SESSION['enddate']);
        unset($_SESSION['search']);

        if ($startdate == ' ') {
            array_push($errors, "Start date is required");
        }
        if ($enddate == '') {
            array_push($errors, "End date is required");
        }

        if (count($errors) == 0) {
            $_SESSION['startdate'] = $startdate;
            $_SESSION['enddate'] = $enddate;
            $_SESSION['search'] = $search;
            header("location: admin-log.php");
        }else{
            // $_SESSION['startdate'] = "emty";
            // $_SESSION['enddate'] = "emty";
            header("location: admin-log.php");
        }
    }

?>