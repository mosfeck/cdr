<?php include('header.php');
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

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

    /* pagination */
    table {
        border-collapse: collapse;
    }

    .inline {
        display: inline-block;
        /* float: right;    */
        margin: 20px 0px;
    }

    input,
    button {
        height: 34px;
    }

    .pagination {
        display: inline-block;
    }

    .pagination a {
        font-weight: bold;
        font-size: 18px;
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid black;
    }

    .pagination a.active {
        background-color: pink;
    }

    .pagination a:hover:not(.active) {
        background-color: skyblue;
    }
</style>
<?php

//include config file
require_once "config.php";
$total_pages = 10;
$per_page_record = 10;
$pagLink = '';
$total_records = 0;
$page = 0;
// echo $_GET["page"];exit;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}
// echo $page;exit;

$conn = new mysqli('localhost', 'root', 'password', 'kothacdr');
// Check for errors
if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') '
        . $conn->connect_error);
}

// $results = array();
$sql = '';
$sqlCount = '';
// $resultCount = '';
if (empty($_POST['uniqueid']) && empty($_POST['calldate_from']) && empty($_POST['calldate_to'])) {
    $sql = "select * from cdr where calldate = DATE(NOW())";
} else {
    //determine the sql LIMIT starting number for the results on the displaying page  
    $start_from = ($page - 1) * $per_page_record;
    // echo $start_from;exit;
    //    $query = "SELECT * FROM student LIMIT $start_from, $per_page_record";     
    //     $rs_result = mysqli_query ($conn, $query); 

    $wheres = array();

    $sql = "SELECT * from cdr where ";
    $sqlCount = "SELECT count(*) from cdr where ";
    // print_r($_POST['uniqueid']);exit;
    if (isset($_POST['uniqueid']) and !empty($_POST['uniqueid'])) {
        $wheres[] = "uniqueid like '{$_POST['uniqueid']}'";
    }
    if (isset($_POST['calldate_from']) and !empty($_POST['calldate_from']) && (isset($_POST['calldate_to']) and !empty($_POST['calldate_to']))) {
        $wheres[] = "calldate  between '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59' ";
    }

    foreach ($wheres as $where) {
        $sql .= $where . ' AND ';   //  you may want to make this an OR
        // if ($sqlCount !== '') {
        $sqlCount .= $where . ' AND ';
        // }
    }
    $sql = rtrim(substr($sql, 0, -5) . " LIMIT $start_from, $per_page_record");
    $sqlCount = rtrim($sqlCount, ' AND');
    // print_r($sqlCount);exit;   
    // $sqlCount = rtrim($sqlCount, "AND LIMIT $start_from, $per_page_record");


}
$results = $conn->query($sql);
if ($sqlCount !== "") {
    $rs_result = mysqli_query($conn, $sqlCount);
    $row = mysqli_fetch_row($rs_result);
    $total_records = $row[0];
}
// echo $total_records;exit;
// $total_records =  mysqli_num_rows($rs_result);
// print_r($total_records);exit;
// $query = "SELECT COUNT(*) FROM cdr";     
// $rs_result = mysqli_query($conn, $query);     
// $row = mysqli_fetch_row($rs_result);     
// $total_records = $row[0];

// print_r($total_records);exit;
// $total_records = 0;
// print_r($sqlCount);exit;
// if ($sqlCount !== '') {
// $resultCount = $conn->query($sqlCount);
// $rowcount=mysqli_num_rows($resultCount);
// echo $rowcount;exit;
// echo $resultCount->num_rows();
// print_r($resultCount);exit;
// $row = $resultCount -> fetch_row();

// $total_records = $conn->num_rows();
// }
// echo $total_records;exit;
// if (!$resultCount) {
//     die("Query failed: " . $conn->error);
// }
// print_r($resultCount);exit;

// print_r($row[0]);exit;

// print_r($total_records);exit;
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
                                    <input name="calldate_from" class="form-control datetimepicker" type="date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input name="calldate_to" class="form-control datetimepicker" type="date">
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
                            // unset($pdo);
                        } ?>
                    </tbody>
                    <tfoot>
                        <div class="pagination">
                            <?php
                            // Number of pages required.   
                            $total_pages = ceil($total_records / $per_page_record);
                            // $pagLink = "";

                            if ($page >= 2) {
                                echo "<a href='missed_call.php?page=" . ($page - 1) . "'>  Prev </a>";
                            }

                            for ($i = 1; $i <= $total_pages; $i++) {
                                if ($i == $page) {
                                    $pagLink .= "<a class = 'active' href='missed_call.php?page="
                                        . $i . "'>" . $i . " </a>";
                                } else {
                                    $pagLink .= "<a href='missed_call.php?page=" . $i . "'>   
                                                                    " . $i . " </a>";
                                }
                            };
                            echo $pagLink;

                            if ($page < $total_pages) {
                                echo "<a href='missed_call.php?page=" . ($page + 1) . "'>  Next </a>";
                            }
                            ?>
                        </div>
                        <tr>
                            <div class="inline">
                                <input id="page" type="number" min="1" max="<?php echo $total_pages ?>" placeholder="<?php echo $page . "/" . $total_pages; ?>" required>
                                <button onClick="go2Page();">Go</button>
                            </div>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>
<?php


// }
// close connection
unset($pdo);
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
    function go2Page() {
        var page = document.getElementById("page").value;
        page = ((page > <?php echo $total_pages; ?>) ? <?php echo $total_pages; ?> : ((page < 1) ? 1 : page));
        window.location.href = 'missed_call.php?page=' + page;
    }
</script>
<script>
    // $(document).ready(function() {
    //     $('.datetimepicker').datetimepicker({
    //         format: 'YYYY-MM-DD HH:mm:ss' // Specify the format of the datetime string
    //     });
    // });
</script>

<?php include('footer.php'); ?>