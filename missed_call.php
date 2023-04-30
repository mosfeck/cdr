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
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Set session
// session_start();
$uniqueid = $calldate_from = $calldate_to = '';
if (isset($_POST['records-limit'])) {
    $_SESSION['records-limit'] = $_POST['records-limit'];
}
if(isset($_POST['submit']))
{
    $uniqueid=$_POST['uniqueid'];
    $calldate_from=$_POST['calldate_from'];
    $calldate_to=$_POST['calldate_to'];
}

$conn = new mysqli('localhost', 'root', 'password', 'kothacdr');
// $results = array();
$limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 10;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$paginationStart = ($page - 1) * $limit;
$sql = '';
$sqlCount = '';
$allRecords = 0;
if (empty($_POST['uniqueid']) && empty($_POST['calldate_from']) && empty($_POST['calldate_to'])) {
    $sql = "SELECT * from cdr where calldate between DATE('y-m-d 00:00:00') AND DATE('y-m-d 23:59:59')";
} else {

    // $wheres = array();
    $sql = "SELECT * FROM cdr WHERE 1";
    $sqlCount = "SELECT count(*) FROM cdr WHERE 1";

    if (isset($_POST['uniqueid']) && !empty($_POST['uniqueid'])) {
        $sql .= " AND uniqueid like '{$_POST['uniqueid']}' ";
        $sqlCount .= " AND uniqueid like '{$_POST['uniqueid']}' ";
    }
    
    if (isset($_POST['calldate_from']) && !empty($_POST['calldate_from']) && (isset($_POST['calldate_to']) && !empty($_POST['calldate_to']))) {
        $sql .= " AND calldate  between '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59' ";
        $sqlCount .= " AND calldate  between '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59' ";
    }
    // echo $sql;exit;
    $sql .= "LIMIT $paginationStart, $limit";

    // $sql = "SELECT * from cdr where ";
    // $sqlCount = "SELECT count(*) from cdr where ";
    // // print_r($_POST['uniqueid']);exit;
    // if (isset($_POST['uniqueid']) and !empty($_POST['uniqueid'])) {
    //     $wheres[] = "uniqueid like '{$_POST['uniqueid']}'";
    // }

    // if (isset($_POST['calldate_from']) and !empty($_POST['calldate_from']) && (isset($_POST['calldate_to']) and !empty($_POST['calldate_to']))) {
    //     $wheres[] = "calldate  between '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59' ";
    // }

    // foreach ($wheres as $where) {
    //     $sql .= $where . ' AND ';   //  you may want to make this an OR
    //     $sqlCount .= $where . ' AND ';
    // }
    // $sql = rtrim(substr($sql, 0, -5) . " LIMIT $paginationStart, $limit");

    // $sqlCount = rtrim($sqlCount, ' AND');
    // echo $sql;exit;

    // print_r($result);exit;    
}
// echo $sql;exit;
$results = $conn->query($sql);
// print_r($results);exit;

if (!$results) {
    die("Query failed: " . $conn->error);
}
// $allRecords =  mysqli_num_rows($results);
// echo $allRecords;exit;
if ($sqlCount !== "") {
    $all_results = $conn->query($sqlCount);
    $row = mysqli_fetch_row($all_results);
    if (!$all_results) {
        die("Query failed: " . $conn->error);
    }

    $allRecords = $row[0];
}
// echo $allRecords;exit;

// Calculate total pages
$totoalPages = ceil($allRecords / $limit);
// Prev + Next
$prev = $page - 1;
$next = $page + 1;
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
                                    <input type="text" name="uniqueid" class="form-control" value = "<?php echo (isset($uniqueid))?$uniqueid:'';?>" placeholder="Unique Id">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input name="calldate_from" class="form-control datetimepicker" value = "<?php echo (isset($calldate_from))?$calldate_from:'';?>" type="date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input name="calldate_to" class="form-control datetimepicker" value = "<?php echo (isset($calldate_to))?$calldate_to:'';?>"  type="date">
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
                </table>
                <!-- Pagination -->
                <nav aria-label="Page navigation example mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if ($page <= 1) {
                                                    echo 'disabled';
                                                } ?>">
                            <a class="page-link" href="<?php if ($page <= 1) {
                                                            echo '#';
                                                        } else {
                                                            echo "?page=" . $prev;
                                                        } ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $totoalPages; $i++) : ?>
                            <li class="page-item <?php if ($page == $i) {
                                                        echo 'active';
                                                    } ?>">
                                <a class="page-link" href="missed_call.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php if ($page >= $totoalPages) {
                                                    echo 'disabled';
                                                } ?>">
                            <a class="page-link" href="<?php if ($page >= $totoalPages) {
                                                            echo '#';
                                                        } else {
                                                            echo "?page=" . $next;
                                                        } ?>">Next</a>
                        </li>
                    </ul>
                </nav>
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
        $('#records-limit').change(function() {
            $('form').submit();
        })
    });
</script>
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