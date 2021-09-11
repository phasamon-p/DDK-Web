<?php
session_start();
include('../inc/server.php');
include('../inc/header.php');
$errors = array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product Information - DDK Report</title>
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
                            AS1
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
                    <h1 class="mt-4">Product Information</h1>
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Information</li>
                    </ol>
                    <div class="btn-group mb-2 " style="float:right;">
                        <button type="button" class="btn btn-primary dataExport" data-type="excel" data-filename="Product Inforamtion">Export XLS</button>
                    </div>
                    <table id="dataTable" class="table table-striped">
                        <thead style="vertical-align: top;">
                            <tr>
                                <th>Section</th>
                                <th>Item Number</th>
                                <th>Product name</th>
                                <th>Part number</th>
                                <th>Part name</th>
                                <th>Drawing number</th>
                                <th>Locker</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
				$Query = "SELECT section, qr_code, product_name, part_no, part_name, drawing_no, locker, quantity FROM products";
				$result = mysqli_query($conn, $Query) or die("database error:". mysqli_error($conn));
				while( $row = mysqli_fetch_assoc($result) ) {
                    $Query2 = "SELECT pl_locker FROM products_lockers WHERE pl_products = '".$row['qr_code']."'";
				    $result2 = mysqli_query($conn, $Query2) or die("database error:". mysqli_error($conn));
                    while( $row2 = mysqli_fetch_assoc($result2) ) {
				?>
                            <tr>
                                <td>
                                    <?php echo $row['section']; ?>
                                </td>
                                <td>
                                    <?php echo $row['qr_code']; ?>
                                </td>
                                <td>
                                    <?php echo $row['product_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['part_no']; ?>
                                </td>
                                <td>
                                    <?php echo $row['part_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['drawing_no']; ?>
                                </td>
                                <td>
                                    <?php echo $row2['pl_locker']; ?>
                                </td>
                                <td>
                                    <?php echo $row['quantity']; ?>
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
    <?php include('../inc/footer.php');?>