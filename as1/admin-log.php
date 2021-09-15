<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
include('../inc/config.inc.php');
// $_SESSION['permission'] = 1;
$errors = array();
if (isset($_SESSION['startdate']) && isset($_SESSION['enddate']) ){
    $_SESSION['admin_startdate'] = $_SESSION['startdate'];
    $_SESSION['admin_enddate'] = $_SESSION['enddate'];
    unset($_SESSION['startdate']);
    unset($_SESSION['enddate']);
    $Query = "SELECT adminid, date_login, time_login, date_logout, time_logout FROM admin_log WHERE date_login BETWEEN '".$_SESSION['admin_startdate']."' AND '".$_SESSION['admin_enddate']."'";
}else{
    $Query = "SELECT adminid, date_login, time_login, date_logout, time_logout FROM admin_log";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Log - DDK Report</title>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">DDK REPORT</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../index.php?logout='1'">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="../index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseDepartmentAS1" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            <?php echo $department ?>
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDepartmentAS1" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="user.php">User Information</a>
                                <a class="nav-link" href="products.php">Product Information</a>
                                <a class="nav-link" href="request-log.php">Request Log</a>
                                <a class="nav-link" href="admin-log.php">Admin Log</a>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="../signin/register.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Create account
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['name'] . ' ' . $_SESSION['lname']; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Admin Log</h1>
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admin Log</li>
                    </ol>
                    <form action="admin_db.php" method="post">
                        <div class="row mb-4">
                            <div class="col-xl-4 col-md-6">
                                <label for="usr">Start Date:</label>
                                <input type="text" class="form-control" name="startdate" id="startdatepicker">
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <label for="usr">End Date:</label>
                                <input type="text" class="form-control" name="enddate" id="enddatepicker">
                            </div>
                            <div class="btn-group col-xl-4 col-md-6">
                                <button type="submit" name="admin_log" class="btn btn-success mt-4">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mb-4">
                        <div class="btn-group    col-xl-3 col-md-3" style="float:left;">
                            <button type="button" class="btn btn-primary dataExport" data-type="excel"
                                data-filename="Admin Log">Export XLS</button>
                        </div>
                    </div>
                    <table id="dataTable" class="table table-striped">
                        <thead style="vertical-align: top;">
                            <tr>
                                <th>Admin ID</th>
                                <th>Name</th>
                                <th>Last name</th>
                                <th>Department</th>
                                <th>permission</th>
                                <th>Date / Time login</th>
                                <th>Date / Time logout</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
				// $Query = "SELECT adminid, date_login, time_login, date_logout, time_logout FROM admin_log WHERE date_login = '2021-08-13'";
				$result = mysqli_query($conn, $Query) or die("database error:". mysqli_error($conn));
				while( $row = mysqli_fetch_assoc($result) ) {
                    $Query2 = "SELECT name, lname, department, permission FROM person WHERE personid = '".$row['adminid']."'";
				    $result2 = mysqli_query($conn, $Query2) or die("database error:". mysqli_error($conn));
                    while( $row2 = mysqli_fetch_assoc($result2) ) {
				?>
                            <tr>
                                <td>
                                    <?php echo $row['adminid']; ?>
                                </td>
                                <td>
                                    <?php echo $row2['name']; ?>
                                </td>
                                <td>
                                    <?php echo $row2['lname']; ?>
                                </td>
                                <td>
                                    <?php echo $row2['department']; ?>
                                </td>
                                <td>
                                    <?php echo $row2['permission']; ?>
                                </td>
                                <td>
                                    <?php if (empty($row['date_login'])){
                                        echo " - ";
                                    }else{
                                        echo $row['date_login']. ", ".$row['time_login'];
                                    } 
                                    ?>
                                </td>
                                <td>
                                    <?php if (empty($row['date_logout'])){
                                        echo " - ";
                                    }else{
                                        echo $row['date_logout']. ", ".$row['time_logout'];
                                    } 
                                    ?>
                                </td>
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>
    <script src="../tableExport/tableExport.js"></script>
    <script type="text/javascript" src="../tableExport/jquery.base64.js"></script>
    <script src="../js/export.js"></script>
    <script>
    $(function() {
        $("#startdatepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        //selecting the button and adding a click event
        $("#alert").click(function() {
            //alerting the value inside the textbox
            var date = $("#startdatepicker").datepicker("getDate");
            startdate = $.datepicker.formatDate("yy-mm-dd", date);
            alert(startdate);
        });
    });
    </script>
    <script>
    $(function() {
        $("#enddatepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        //selecting the button and adding a click event
        $("#alert").click(function() {
            //alerting the value inside the textbox
            var date = $("#enddatepicker").datepicker("getDate");
            var enddate = $.datepicker.formatDate("dd-mm-yy", date);
            alert(enddate);
        });
    });
    </script>
    <?php include('../inc/footer.php');?>