<?php 
    session_start();
    // include('db_conection.php');
    include('../inc/server.php');
    $errors = array();

    if (isset($_POST['request_log'])) {
       
        $startdate = mysqli_real_escape_string($conn, $_POST['startdate']);
        $enddate = mysqli_real_escape_string($conn, $_POST['enddate']);
    
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
            header("location: request-log.php");
        }else{
            // $_SESSION['startdate'] = "emty";
            // $_SESSION['enddate'] = "emty";
            header("location: request-log.php");
        }
    }

?>