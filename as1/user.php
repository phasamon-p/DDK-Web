<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
include('../inc/config.inc.php');
$errors = array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Information - DDK Report</title>
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
                            <?php echo $department;?>
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
                                <a class="nav-link" href="emergency-log.php">Emergency Log</a>
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
                    <h1 class="mt-4">User Information</h1>
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Information</li>
                    </ol>
                    <div class="row mb-2">
                        <div class="btn-group    col-xl-12 col-md-12" style="float:left;">
                            <button type="button" class="btn btn-primary dataExport" data-type="excel"
                                data-filename="User Log">Export XLS</button>
                        </div>
                    </div>
                    <div style="overflow-x:auto;">
                        <table id="dataTable" class="table table-striped">
                            <thead style="vertical-align: top;">
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Last name</th>
                                    <th>Department</th>
                                    <th>Permission</th>
                                    <th>Locker access</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
				$Query = "SELECT personid, name, lname, department, permission FROM person";
				$result = mysqli_query($conn, $Query) or die("database error:". mysqli_error($conn));
				while( $row = mysqli_fetch_assoc($result) ) {
                    $Query2 = "SELECT pl_locker FROM person_locker WHERE pl_person = '".$row['personid']."'";
				    $result2 = mysqli_query($conn, $Query2) or die("database error:". mysqli_error($conn));
                    $locker = "";
                    while( $row2 = mysqli_fetch_assoc($result2) ) {
                        if (strlen($locker) > 0) {
                            switch ($row2['pl_locker']) {
                                case 1:
                                    $locker = $locker. ", " .strval("A");
                                    break;
                                case 2:
                                    $locker = $locker. ", " .strval("B");
                                    break;
                               case 3:
                                    $locker = $locker. ", " .strval("C");
                                    break;
                                case 4:
                                    $locker = $locker. ", " .strval("D");
                                    break;
                                case 5:
                                    $locker = $locker. ", " .strval("E");
                                    break;
                                case 6:
                                    $locker = $locker. ", " .strval("F");
                                    break;
                                case 7:
                                    $locker = $locker. ", " .strval("G");
                                    break;
                                case 8:
                                    $locker = $locker. ", " .strval("H");
                                    break;
                                case 9:
                                    $locker = $locker. ", " .strval("I");
                                    break;
                                case 10:
                                    $locker = $locker. ", " .strval("J");
                                    break;
                                case 11:
                                    $locker = $locker. ", " .strval("K");
                                    break;
                                case 12:
                                    $locker = $locker. ", " .strval("L");
                                    break;
                                case 13:
                                    $locker = $locker. ", " .strval("M");
                                    break;
                                case 14:
                                    $locker = $locker. ", " .strval("N");
                                    break;
                                case 15:
                                    $locker = $locker. ", " .strval("O");
                                    break;
                                case 16:
                                    $locker = $locker. ", " .strval("P");
                                    break;
                                default:
                                    echo "-";} 
                        }else{
                            switch ($row2['pl_locker']) {
                                case 1:
                                    $locker = $locker. "" .strval("A");
                                    break;
                                case 2:
                                    $locker = $locker. "" .strval("B");
                                    break;
                               case 3:
                                    $locker = $locker. "" .strval("C");
                                    break;
                                case 4:
                                    $locker = $locker. "" .strval("D");
                                    break;
                                case 5:
                                    $locker = $locker. "" .strval("E");
                                    break;
                                case 6:
                                    $locker = $locker. "" .strval("F");
                                    break;
                                case 7:
                                    $locker = $locker. "" .strval("G");
                                    break;
                                case 8:
                                    $locker = $locker. "" .strval("H");
                                    break;
                                case 9:
                                    $locker = $locker. "" .strval("I");
                                    break;
                                case 10:
                                    $locker = $locker. "" .strval("J");
                                    break;
                                case 11:
                                    $locker = $locker. "" .strval("K");
                                    break;
                                case 12:
                                    $locker = $locker. "" .strval("L");
                                    break;
                                case 13:
                                    $locker = $locker. "" .strval("M");
                                    break;
                                case 14:
                                    $locker = $locker. "" .strval("N");
                                    break;
                                case 15:
                                    $locker = $locker. "" .strval("O");
                                    break;
                                case 16:
                                    $locker = $locker. "" .strval("P");
                                    break;
                                default:
                                    echo "-";}
                        }    
                    }
				?>
                                <tr>
                                    <td>
                                        <?php echo $row['personid']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['lname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['department']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['permission']; ?>
                                    </td>
                                    <td>
                                        <?php echo $locker; ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="../tableExport/tableExport.js"></script>
    <script type="text/javascript" src="../tableExport/jquery.base64.js"></script>
    <script src="../js/export.js"></script>
    <?php include('../inc/footer.php');?>