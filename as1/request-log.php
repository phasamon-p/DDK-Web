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
    if (isset($_SESSION['item'])){
        $_SESSION['request_item'] = $_SESSION['item'];
        unset($_SESSION['item']);
    }
    if (isset($_SESSION['product'])){
        $_SESSION['request_product'] = $_SESSION['product'];
        unset($_SESSION['product']);
    }
}else{
    unset($_SESSION['request_startdate']);
    unset($_SESSION['request_enddate']);
    unset($_SESSION['request_item']);
    unset($_SESSION['request_product']);
    unset($_SESSION['datesearch']);
    $Query = "SELECT date, time, personid, qrcode, request, recheck FROM request_log";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Request Log - DDK Report</title>
    <script type="text/javascript">
    function changeFuncProduct() {
        var selectBox = document.getElementById("selectBoxProduct");
        var productselectedValue = selectBox.options[selectBox.selectedIndex].value;
        alert("Product Number : " + productselectedValue);
    }

    function changeFuncItem() {
        var selectBox = document.getElementById("selectBoxItem");
        var itemselectedValue = selectBox.options[selectBox.selectedIndex].value;
        alert("Item Name : " + itemselectedValue);
    }
    </script>
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
                    <h1 class="mt-4">Request Log</h1>
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="../index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Request Log</li>
                    </ol>
                    <form action="request_db.php" method="post">
                        <div class="row mb-4">
                            <div class="col-xl-6 col-md-6">
                                <label for="usr">Start Date:</label>
                                <input type="date" class="form-control" name="startdate" id="startdatepicker"
                                    value="<?php if (isset($_SESSION['datesearch'])){ echo $_SESSION['request_startdate'];}else{echo "";}?>">
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <label for="usr">End Date:</label>
                                <input type="date" class="form-control" name="enddate" id="enddatepicker"
                                    value="<?php if (isset($_SESSION['datesearch'])){ echo $_SESSION['request_enddate'];}else{echo "";}?>">
                            </div>
                        </div>
                        <?php if (isset($_SESSION['datesearch'])){?>
                        <div class="row mb-4">
                            <div class="col-xl-6 col-md-6">
                                <label for="usr">Item number:</label>
                                <select id="selectBoxItem" name="selectBoxItem" class="form-control">
                                    <option value="<?php echo $_SESSION['request_item'];?>" selected disabled hidden>
                                        <?php if($_SESSION['request_item'] == ""){ echo "Choose Here";}else{echo $_SESSION['request_item'];}?>
                                    </option>
                                    <?php 
                                    $result = mysqli_query($conn, $Query) or die("database error:". mysqli_error($conn));
                                    while( $row = mysqli_fetch_assoc($result) ) {
                                        $Query2 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."'";
                                        $result2 = mysqli_query($conn, $Query2) or die("database error:". mysqli_error($conn));
                                        while( $row2 = mysqli_fetch_assoc($result2) ) { ?>
                                    <option value="<?php echo $row2['item_no'];?>"><?php echo $row2['item_no'];?>
                                    </option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="col-xl-6 col-md-6 from-group">
                                <label for="usr">Product name:</label>
                                <select id="selectBoxProduct" name="selectBoxProduct" class="form-control">
                                    <option
                                        value="<?php if($_SESSION['request_product'] == ""){ echo "";}else{echo $_SESSION['request_product'];}?>"
                                        selected disabled hidden>
                                        <?php if($_SESSION['request_product'] == ""){ echo "Choose Here";}else{echo $_SESSION['request_product'];}?>
                                    </option>
                                    <?php 
                                    $result = mysqli_query($conn, $Query) or die("database error:". mysqli_error($conn));
                                    while( $row = mysqli_fetch_assoc($result) ) {
                                        $Query2 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."'";
                                        $result2 = mysqli_query($conn, $Query2) or die("database error:". mysqli_error($conn));
                                        while( $row2 = mysqli_fetch_assoc($result2) ) { ?>
                                    <option value="<?php echo $row2['product_name'];?>">
                                        <?php echo $row2['product_name'];?>
                                    </option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row mb-4">
                            <div class="btn-group    col-xl-12 col-md-12" style="float:left;">
                                <button type="submit" name="request_log" class="btn btn-success">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mb-4">
                        <div class="btn-group    col-xl-12 col-md-12" style="float:left;">
                            <button type="button" class="btn btn-primary dataExport" data-type="excel"
                                data-filename="Request Log">Export XLS</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <ol class="breadcrumb mb-1">
                                <li>Duration :
                                    <?php if (isset($_SESSION['request_startdate']) && isset($_SESSION['request_enddate']) ){ 
                                                echo  "   " .$_SESSION['request_startdate']. " - " . $_SESSION['request_enddate'];
                                            }else{
                                                echo  "All time";
                                            } ?>
                                </li>
                            </ol>
                            <?php if ($_SESSION['request_item'] != ""){ ?>
                            <ol class="breadcrumb mb-1">
                                <li>Item Number :
                                    <?php echo  "   " .$_SESSION['request_item'];?>
                                </li>
                            </ol>
                            <?php } ?>
                            <?php if ($_SESSION['request_product'] != ""){ ?>
                            <ol class="breadcrumb mb-1">
                                <li>Product Number :
                                    <?php echo  "   " .$_SESSION['request_product'];?>
                                </li>
                            </ol>
                            <?php } ?>
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
                                    <th>Date</th>
                                    <th>Time</th>
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
                        if (($_SESSION['request_item'] != "") && ($_SESSION['request_product'] != "")){
                            $Query3 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."' AND item_no = '".$_SESSION['request_item']."' AND product_name = '".$_SESSION['request_product']."'";
                            echo '<script>';
                            echo 'console.log("Request item and product")';
                            echo '</script>';
                        }
                        elseif (($_SESSION['request_item'] != "")){
                            $Query3 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."' AND item_no = '".$_SESSION['request_item']."'";
                            echo '<script>';
                            echo 'console.log("Request item only")';
                            // echo 'console.log('.$_SESSION['request_item'].')';
                            echo '</script>';
                        }
                        elseif (($_SESSION['request_product'] != "")){
                            $Query3 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."' AND product_name = '".$_SESSION['request_product']."'";
                            echo '<script>';
                            echo 'console.log("Request product only")';
                            echo '</script>';
                        }
                        else{
                            $Query3 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."'";
                            echo '<script>';
                            echo 'console.log("Do not Request")';
                            echo '</script>';
                        }

                        // $Query3 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."'";
                        // $Query3 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."' AND item_no = 'A412003054'";
                        // $Query3 = "SELECT section, item_no, product_name, part_no, part_name, drawing_no, locker, quantity FROM products WHERE qr_code = '".$row['qrcode']."' AND item_no = 'A412003054' AND product_name = '21D6X12'";
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
                                        <?php echo $row['date']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['time']; ?>
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
                                        <?php if($department == "PR"){
                                        switch ($row4['pl_locker']) {
                                            case 1:
                                                echo "A";
                                                break;
                                            case 2:
                                                echo "B";
                                                break;
                                            case 16:
                                                echo "C";
                                                break;
                                            case 4:
                                                echo "D";
                                                break;
                                            case 5:
                                                echo "E";
                                                break;
                                            case 6:
                                                echo "F";
                                                break;
                                            case 7:
                                                echo "G";
                                                break;
                                            case 8:
                                                echo "H";
                                                break;
                                            case 9:
                                                echo "I";
                                                break;
                                            case 10:
                                                echo "J";
                                                break;
                                            case 11:
                                                echo "K";
                                                break;
                                            case 12:
                                                echo "L";
                                                break;
                                            case 13:
                                                echo "M";
                                                break;
                                            case 14:
                                                echo "N";
                                                break;
                                            case 15:
                                                echo "O";
                                                break;
                                            case 3:
                                                echo "P";
                                                break;
                                            default:
                                                echo "-";} 
                                    }else{
                                        switch ($row4['pl_locker']) {
                                            case 1:
                                                echo "A";
                                                break;
                                            case 2:
                                                echo "B";
                                                break;
                                            case 3:
                                                echo "C";
                                                break;
                                            case 4:
                                                echo "D";
                                                break;
                                            case 5:
                                                echo "E";
                                                break;
                                            case 6:
                                                echo "F";
                                                break;
                                            case 7:
                                                echo "G";
                                                break;
                                            case 8:
                                                echo "H";
                                                break;
                                            case 9:
                                                echo "I";
                                                break;
                                            case 10:
                                                echo "J";
                                                break;
                                            case 11:
                                                echo "K";
                                                break;
                                            case 12:
                                                echo "L";
                                                break;                               
                                            default:
                                                echo "-";} 
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <?php } } } }?>
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
    <!-- <script>
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
    </script> -->

    <?php include('../inc/footer.php');?>