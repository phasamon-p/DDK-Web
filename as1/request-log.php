<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
include('../inc/config.inc.php');
$errors = array();
if (isset($_SESSION['startdate']) && isset($_SESSION['enddate']) ){
    $_SESSION['request_startdate'] = $_SESSION['startdate'];
    $_SESSION['request_enddate'] = $_SESSION['enddate'];
    unset($_SESSION['startdate']);
    unset($_SESSION['enddate']);
    $Query = "SELECT date, time, personid, qrcode, request, recheck FROM request_log WHERE date BETWEEN '".$_SESSION['request_startdate']."' AND '".$_SESSION['request_enddate']."'";
}else{
    unset($_SESSION['request_startdate']);
    unset($_SESSION['request_enddate']);
    $Query = "SELECT date, time, personid, qrcode, request, recheck FROM request_log";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Request Log - DDK Report</title>
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
                            data-bs-target="#collapseDepartment" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            <?php echo $department ?>
                            <!-- AS1 -->
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseDepartment" aria-labelledby="headingOne"
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
                    <h1 class="mt-4">Request Log</h1>
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Request Log</li>
                    </ol>
                    <form action="request_db.php" method="post">
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
                                <button type="submit" name="request_log" class="btn btn-success mt-4">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mb-4">
                        <div class="btn-group    col-xl-3 col-md-3" style="float:left;">
                            <button type="button" class="btn btn-primary dataExport" data-type="excel"
                                data-filename="Request Log">Export XLS</button>
                        </div>
                    </div>
                    <ol class="breadcrumb mb-2">
                        <li>Duration :
                            <?php if (isset($_SESSION['request_startdate']) && isset($_SESSION['request_enddate']) ){ 
                            echo  "   " .$_SESSION['request_startdate']. " - " . $_SESSION['request_enddate'];
                        }else{
                            echo  "All time";
                        } ?>
                        </li>

                    </ol>
                    <table id="dataTable" class="table table-striped">
                        <thead style="vertical-align: top;">
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Last name</th>
                                <th>Department</th>
                                <th>Date / Time</th>
                                <th>Request</th>
                                <th>Recheck</th>
                                <th>Section</th>
                                <th>Item number</th>
                                <th>Product name</th>
                                <th>Part number</th>
                                <th>Part name</th>
                                <th>Drawing number</th>
                                <th>Quantity</th>
                                <th>Locker</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
				// $Query = "SELECT date, time, personid, qrcode, request, recheck FROM request_log";
				$result = mysqli_query($conn, $Query) or die("database error:". mysqli_error($conn));
				while( $row = mysqli_fetch_assoc($result) ) {
                    $Query2 = "SELECT name, lname, department, permission FROM person WHERE personid = '".$row['personid']."'";
				    $result2 = mysqli_query($conn, $Query2) or die("database error:". mysqli_error($conn));
                    while( $row2 = mysqli_fetch_assoc($result2) ) {
                        $Query3 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."'";
                        $result3 = mysqli_query($conn, $Query3) or die("database error:". mysqli_error($conn));
                        while( $row3 = mysqli_fetch_assoc($result3) ) {
                            $Query4 = "SELECT pl_locker FROM products_lockers WHERE pl_products = '".$row3['item_no']."'";
                            $result4 = mysqli_query($conn, $Query4) or die("database error:". mysqli_error($conn));
                            while( $row4 = mysqli_fetch_assoc($result4) ) {
				?>
                            <tr>
                                <td>
                                    <?php echo $row['personid']; ?>
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
                                    <?php echo $row['date']. ", ".$row['time']; ?>
                                </td>
                                <td>
                                    <?php echo $row['request']; ?>
                                </td>
                                <td>
                                    <?php echo $row['recheck']; ?>
                                </td>
                                <td>
                                    <?php echo $row3['section']; ?>
                                </td>
                                <td>
                                    <?php echo $row3['item_no']; ?>
                                </td>
                                <td>
                                    <?php echo $row3['product_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row3['part_no']; ?>
                                </td>
                                <td>
                                    <?php echo $row3['part_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row3['drawing_no']; ?>
                                </td>
                                <td>
                                    <?php echo $row3['quantity']; ?>
                                </td>
                                <td>
                                    <?php echo $row4['pl_locker']; ?>
                                </td>
                            </tr>
                            <?php } } } }?>
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