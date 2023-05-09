<?php include('header.php'); ?>

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
$calldate_from = $calldate_to = '';
$report_type = "Daily";
if (isset($_POST['submit'])) {
    $report_type = $_POST['report_type'];
    $calldate_from = $_POST['calldate_from'];
    $calldate_to = $_POST['calldate_to'];
}
$sql = '';
$_SESSION['report_type'] = $report_type;
if (isset($_POST['submit']) && $_POST['submit'] == 'Search') {
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
} else {
    $sql = "SELECT date(calldate) `Daily`, 
    count(*) as `missedCall`, 
    SUM(apiCalling) as `apiCall` 
    FROM cdr WHERE 
    calldate between DATE('y-m-d 00:00:00') AND DATE('y-m-d 23:59:59') 
    GROUP BY `Daily`";
}
$_SESSION['summary_cdr'] = $sql;
// use the connection here
$stmt = $pdo->query($sql);

// fetch all rows into array, by default PDO::FETCH_BOTH is used
$results = $stmt->fetchAll();
?>
<div class="container ">
    <div class="row mt-3 mb-5 pb-3">
        <div class="col-lg-12 col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center">Missed Call Summary Report</div>
                </div>
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
                                    <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Search">
                                    <a href="missed_call_summary_export.php" class="btn btn-info btn-sm text-white">Export</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive mb-3 pb-3">
                    <table class="table table-bordered table-striped table-hovered" id="cdr-table">
                        <thead>
                            <tr class="table-success">
                                <th>SL</th>
                                <th><?php echo $report_type; ?></th>
                                <th>Missed Call</th>
                                <th>API Called</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($results) {
                                $sl = 1;
                                $TotalMissedCall = $TotalApiCall = 0;
                                foreach ($results as $row) {
                                    $TotalMissedCall += (int)$row['missedCall'];
                                    $TotalApiCall += (int)$row['apiCall'];
                            ?>
                                    <tr <?php echo $sl % 2 == 0 ? ' class="table-info"' : 'class="table-success"'; ?>>
                                        <td><?php echo $sl++; ?></td>
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
                                }
                                unset($stmt);
                                ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total</td>
                                <td><?php echo $TotalMissedCall; ?></td>
                                <td><?php echo $TotalApiCall; ?></td>
                            </tr>
                        </tfoot>
                    <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// close connection
unset($pdo);
?>
<?php include('footer.php'); ?>