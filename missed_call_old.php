<?php include('header.php'); ?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.3.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-guEcIlwzfs7V3qKjy7cG1HioTH03t0yhBO5d5cbtX9D5Qz1bL5gkFz1yB40wYrgRJa7NNzbodQccRVV3c9fZ8A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<style type="text/css">
    body {
        font: 14px sans-serif;
        color: #fff;
        /* text-align: center;  */
        /*margin: 0 auto;*/
    }

    table {
        color: #fff;
    }

    .page-header {
        text-align: center;
    }

    /* h1 {
        border-bottom: 1px solid;
    } */

    .row {
        margin: 5px;
    }

    .action_button {
        margin-top: 15px;
    }

    .h-center {
        text-align: center;
    }

    .h-center .btn {
        display: initial;
        margin: 0 auto;
    }

    .top-space {
        margin-top: 30px;
    }
</style>
<?php
// Initialize the session
session_start();
//include config file
require_once "config.php";

$records_per_page = 10; // Change this value to set the number of records per page
$total_pages = 50;

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$conn = new mysqli('localhost', 'root', 'password', 'kothacdr');

// Check for errors
if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') '
            . $conn->connect_error);
}
// $results = array();
$sql = '';
if (empty($_POST['uniqueid']) && empty($_POST['calldate_from']) && empty($_POST['calldate_to'])) {
    $sql = "SELECT * from cdr where calldate = DATE(NOW())";
    
    $result = $conn->query("SELECT COUNT(*) as total FROM cdr where calldate = DATE(NOW())");
    $row = $result->fetch_assoc();
    $total_records = $row['total'];

    $total_pages = ceil($total_records / $records_per_page);

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $starting_record = ($current_page - 1) * $records_per_page;

    // Retrieve the records for the current page
    $result = $conn->query("SELECT * FROM cdr LIMIT $starting_record, $records_per_page");

    // print_r($result);exit;
    // Display the pagination links
    // for ($i = 1; $i <= $total_pages; $i++) {
    //     echo '<a href="?page=' . $i . '">' . $i . '</a> ';
    // }
} else {

    $wheres = array();

    $sql = "select * from cdr where ";

    // print_r($_POST['uniqueid']);exit;
    if (isset($_POST['uniqueid']) and !empty($_POST['uniqueid'])) {
        $wheres[] = "uniqueid like '{$_POST['uniqueid']}'";
    }

    if (isset($_POST['calldate_from']) and !empty($_POST['calldate_from']) && (isset($_POST['calldate_to']) and !empty($_POST['calldate_to']))) {
        $wheres[] = "calldate  between '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59' ";
    }

    foreach ($wheres as $where) {
        $sql .= $where . ' AND ';   //  you may want to make this an OR
    }
    $sql = rtrim($sql, "AND ");


    // print_r($result);exit;    
}
$results = $conn->query($sql);

if (!$results) {
    die("Query failed: " . $conn->error);
}
?>
<div class="container ">
    <div class="row mt-3 mb-5 pb-3">
        <div class="col-lg-12 col-md-12 col-sm-12 ">
            <div class="card">
                <!-- <div class="card-header">
                    <div class="card-title text-center">CDR Search</div>
                </div> -->
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input type="text" name="uniqueid" class="form-control" placeholder="Unique Id">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input  name="calldate_from" class="form-control datetimepicker" type="date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input  name="calldate_to" class="form-control datetimepicker" type="date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Search">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="table-responsive mb-3 pb-3">
                <table class="table table-bordered table-striped table-hovered" id="cdr-table">
                    <thead>
                        <tr class="table-success">
                            <th> SL</th>
                            <th> Unique Id </th>
                            <th> Calldate</th>
                            <th> Source Number </th>
                            <th> API Calling </th>
                            <th> API Calling Time </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = 1;
                        foreach ($results as $row) {
                        ?>
                            <tr <?php echo $sl % 2 == 0 ? ' class="table-info"' : 'class="table-success"'; ?>>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $row['uniqueid']; ?></td>
                                <td><?php echo $row['calldate']; ?></td>
                                <td><?php echo $row['srcmain']; ?></td>
                                <td><?php echo $row['apiTime']; ?></td>
                                <td><?php echo $row['apiCalling'] == 1 ? 'Yes' : 'No'; ?></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                    <tfoot>
                        <?php  
                            for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <tr>
                            echo '<a href="?page=' . $i . '">' . $i . '</a> ';
                        </tr>
                        <?php } ?>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>
<?php


// }
// close connection
$conn->close();
?>

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" /> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-fQ+tkptA94pi+gKYFpXZlrn8HJbuOVnUIg6fH/+kMEEw+2c1JzegbGYORZKWElXG+TE8ZgdfCNRNGDx3v4fWvw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.3.2/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-GIuGdzHXXABnYuyFfVnPE5Xd/Ak7gL9XmDnQMF1mIzRGxtdDQZMcd9fWsXKj+dCddOSpArF+tFN1/kdptCT8eA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script>
    $(document).ready(function() {
        $('#user-table').DataTable();
    });
</script>
<script>
    // $(document).ready(function() {
    //     $('.datetimepicker').datetimepicker({
    //         format: 'YYYY-MM-DD HH:mm:ss' // Specify the format of the datetime string
    //     });
    // });
</script>
<!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> -->
<?php include('footer.php'); ?>