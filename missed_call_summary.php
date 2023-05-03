<?php include('header.php'); ?>
<style type="text/css">
    body {
        font: 14px sans-serif;
        color: #fff;
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
$report_type = $calldate_from = $calldate_to = '';
if (isset($_POST['records-limit'])) {
    $_SESSION['records-limit'] = $_POST['records-limit'];
}
if (isset($_POST['submit'])) {
    $report_type = $_POST['report_type'];
    $calldate_from = $_POST['calldate_from'];
    $calldate_to = $_POST['calldate_to'];
}

$conn = new mysqli('localhost', 'root', 'password', 'kothacdr');
if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $conn -> connect_error;
    exit();
  }

$limit = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 10;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$paginationStart = ($page - 1) * $limit;
$url = 'missed_call.php?type=search';
$sql = '';
$sqlCount = '';
$allRecords = 0;

if (isset($_POST['submit']) && $_POST['submit'] == 'Search') {
    // print_r($_POST);
    // $url .= '&type=search';
    if (isset($_POST['calldate_from']) && !empty($_POST['calldate_from']) && (isset($_POST['calldate_to']) && !empty($_POST['calldate_to']))) {
        if ($_POST['report_type'] == "Daily") {
            $sql = "SELECT date(calldate) `Daily`, 
                count(*) as `missedCall`, 
                SUM(apiCalling) as `apiCall` 
                FROM cdr
                WHERE calldate  between '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59'
                GROUP BY `Daily`";
        }
        if ($_POST['report_type'] == "Monthly") {
            $sql = "SELECT date_format(calldate, '%Y-%m') `Monthly`, 
                count(*) as `missedCall`, 
                SUM(apiCalling) as `apiCall` 
                FROM cdr
                WHERE calldate  between '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59'
                GROUP BY `Monthly`";
        }
        if ($_POST['report_type'] == "Yearly") {
            $sql = "SELECT year(calldate) `Yearly`, 
                count(*) as `missedCall`, 
                SUM(apiCalling) as `apiCall` 
                FROM cdr
                WHERE calldate  between '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59'
                GROUP BY `Yearly`";
        }
    }
}
else {
    $sql = "SELECT date(calldate) `Daily`, 
    count(*) as `missedCall`, 
    SUM(apiCalling) as `apiCall` 
    FROM cdr WHERE 
    calldate between DATE('y-m-d 00:00:00') AND DATE('y-m-d 23:59:59') 
    GROUP BY `Daily`";
}

//echo $sql;// exit;
$results = $conn->query($sql);
// print_r($results);exit;

if (!$results) {
    die("Query failed: " . $conn->error);
}

?>
<div class="container ">
    <div class="row mt-3 mb-5 pb-3">
        <div class="col-lg-12 col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input name="calldate_from" class="form-control datetimepicker" value="<?php echo (isset($calldate_from)) ? $calldate_from : ''; ?>" type="date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input name="calldate_to" class="form-control datetimepicker" value="<?php echo (isset($calldate_to)) ? $calldate_to : ''; ?>" type="date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <select name="report_type" class="form-control form-select">
                                    <?php
                                    $report_type_opt = array(
                                        "Daily" => "Daily",
                                        "Monthly" => "Monthly",
                                        "Yearly" => "Yearly"
                                    );
                                    // loop through the options to create the <option> tags
                                    foreach ($report_type_opt as $key => $type) {
                                        echo "<option value=\"$key\">$type</option>";
                                    }
                                    ?>
                                </select>
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
                            <th> SL.</th>
                            <th> Report Type </th>
                            <th> Calldate</th>
                            <th> Total Missed Call </th>
                            <th> Total API Called </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = 1;
                        foreach ($results as $row) {
                        ?>
                            <tr <?php echo $sl % 2 == 0 ? ' class="table-info"' : 'class="table-success"'; ?>>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $report_type; ?></td>
                                <td><?php if ($report_type == "Daily") {
                                        echo $row['Daily'];
                                    } elseif ($report_type == "Monthly") {
                                        echo $row['Monthly'];
                                    } elseif ($report_type == "Yearly") {
                                        echo $row['Yearly'];
                                    } ?></td>
                                <td><?php echo $row['missedCall']; ?></td>
                                <td><?php echo $row['apiCall']; ?></td>
                            </tr>
                        <?php
                            
                        } ?>
                    </tbody>
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


<script>
    // $(document).ready(function() {
    //     $('#cdr-table').DataTable();
    // });
</script>
<?php include('footer.php'); ?>