<?php 
    session_start();
    // include('db_conection.php');
    include('../inc/server.php');
    $errors = array();

    if (isset($_POST['request_log'])) {
       
        $startdate = mysqli_real_escape_string($conn, $_POST['startdate']);
        $enddate = mysqli_real_escape_string($conn, $_POST['enddate']);
        $item = mysqli_real_escape_string($conn, $_POST['selectBoxItem']);
        $product = mysqli_real_escape_string($conn, $_POST['selectBoxProduct']);

        unset($_SESSION['startdate']);
        unset($_SESSION['enddate']);
        unset($_SESSION['item']);
        unset($_SESSION['product']);
        unset($_SESSION['datesearch']);
    
        if ($startdate == ' ') {
            array_push($errors, "Start date is required");
        }
        if ($enddate == '') {
            array_push($errors, "End date is required");
        }

        if (count($errors) == 0) {
            $_SESSION['startdate'] = $startdate;
            $_SESSION['enddate'] = $enddate;
            $_SESSION['item'] = $item;
            $_SESSION['product'] = $product;
            $_SESSION['datesearch'] = TRUE;
            header("location: request-log.php");
        }else{
            // $_SESSION['startdate'] = "emty";
            // $_SESSION['enddate'] = "emty";
            unset($_SESSION['datesearch']);
            header("location: request-log.php");
        }
    }

?>