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
// Set session
$uniqueid = $calldate_from = $calldate_to = '';

if (isset($_POST['submit'])) {
    $uniqueid = $_POST['uniqueid'];
    $calldate_from = $_POST['calldate_from'];
    $calldate_to = $_POST['calldate_to'];
}

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}
$total_records_per_page = 50;
if (isset($_POST['submit']) && $_POST['submit'] == 'Search') {
    $sql = "SELECT * from cdr WHERE 1";
    if (isset($_POST['uniqueid']) && !empty($_POST['uniqueid'])) {
        $sql .= " AND uniqueid like '{$_POST['uniqueid']}' ";
    }
    if (isset($_POST['calldate_from']) && !empty($_POST['calldate_from']) && (isset($_POST['calldate_to']) && !empty($_POST['calldate_to']))) {
        $sql .= " AND calldate  BETWEEN '" . $_POST['calldate_from'] . " 00:00:00' and '" . $_POST['calldate_to'] . " 23:59:59' ";
    }
    $_SESSION['search_cdr'] = $sql;
    $_SESSION['currentPage'] = $page_no;
} elseif (isset($_GET['page_no'])  && isset($_SESSION['search_cdr']) && $_SESSION['search_cdr'] != '') {
    $sql = $_SESSION['search_cdr'];
    $page_no = $_GET['page_no'];
} else {
    $sql = "SELECT * from cdr where calldate BETWEEN '" . date('y-m-d') . " 00:00:00' AND '" . date('y-m-d') . " 23:59:59'";
    unset($_SESSION['search_cdr']);
    $_SESSION['search_cdr'] = $sql;
}
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$total_records = $stmt->rowCount();
$total_no_of_pages = ceil($total_records / $total_records_per_page);
// total page minus 1
$second_last = $total_no_of_pages - 1;

$sqlSelect = $sql . ' LIMIT ' . $offset . ', ' . $total_records_per_page;
$stmt1 = $pdo->query($sqlSelect);
$results = $stmt1->fetchAll();
?>
<div class="container ">
    <div class="row mt-3 mb-5 pb-3">
        <div class="col-lg-12 col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center">Missed Call Report</div>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input type="text" name="uniqueid" class="form-control" value="<?php echo (isset($uniqueid)) ? $uniqueid : ''; ?>" placeholder="Unique Id">
                                </div>
                            </div>
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
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Search">
                                    <a href="missed_call_export.php" class="btn btn-info btn-sm text-white">Export</a>
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
                            <th> API Calling Time </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = $offset + 1;
                        if ($results) {
                            foreach ($results as $row) {
                        ?>
                                <tr <?php echo $sl % 2 == 0 ? ' class="table-info"' : 'class="table-success"'; ?>>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $row['uniqueid']; ?></td>
                                    <td><?php echo $row['calldate']; ?></td>
                                    <td><?php echo $row['srcmain']; ?></td>
                                    <td><?php echo $row['apiTime']; ?></td>
                                </tr>
                            <?php
                                $sl++;
                            }
                        } else { ?>
                            <tr>
                                <td colspan="10" class="text-center">No Information Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div style='padding: 10px 20px 12px; border-top: dotted 1px #CCC;'>
                    <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation example mt-5">
                    <ul class="pagination">
                        <?php if($page_no > 1){ echo "<li><a class='page-link' href='?page_no=1'>First Page</a></li>"; } 
                        ?>

                        <li class="page-item <?php if ($page_no <= 1) {
                                                    echo "class='disabled'";
                                                } ?>">
                            <a class="page-link" <?php if ($page_no > 1) {
                                                        echo "href='?page_no=$previous_page'";
                                                    } ?>>Previous</a>
                        </li>

                        <?php
                        if ($total_no_of_pages <= 10) {
                            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='page-link active'><a>$counter</a></li>";
                                } else {
                                    echo "<li ><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                }
                            }
                        } elseif ($total_no_of_pages > 10) {

                            if ($page_no <= 4) {
                                for ($counter = 1; $counter < 8; $counter++) {
                                    if ($counter == $page_no) {
                                        echo "<li class='page-link active'><a>$counter</a></li>";
                                    } else {
                                        echo "<li><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                    }
                                }
                                echo "<li><a class='page-link' >...</a></li>";
                                echo "<li><a  class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                                echo "<li><a  class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                            } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                                echo "<li><a  class='page-link' href='?page_no=1'>1</a></li>";
                                echo "<li><a  class='page-link' href='?page_no=2'>2</a></li>";
                                echo "<li><a class='page-link' >...</a></li>";
                                for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                    if ($counter == $page_no) {
                                        echo "<li class='page-link active'><a>$counter</a></li>";
                                    } else {
                                        echo "<li><a  class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                    }
                                }
                                echo "<li><a class='page-link' >...</a></li>";
                                echo "<li><a class='page-link'  href='?page_no=$second_last'>$second_last</a></li>";
                                echo "<li><a  class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                            } else {
                                echo "<li><a class='page-link'  href='?page_no=1'>1</a></li>";
                                echo "<li><a class='page-link'  href='?page_no=2'>2</a></li>";
                                echo "<li><a class='page-link' >...</a></li>";

                                for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                    if ($counter == $page_no) {
                                        echo "<li class='page-link active'><a>$counter</a></li>";
                                    } else {
                                        echo "<li><a  class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                    }
                                }
                            }
                        }
                        ?>

                        <li <?php if ($page_no >= $total_no_of_pages) {
                                echo "class='disabled'";
                            } ?>>
                            <a class="page-link" <?php if ($page_no < $total_no_of_pages) {
                                                        echo "href='?page_no=$next_page'";
                                                    } ?>>Next</a>
                        </li>
                        <?php if ($page_no < $total_no_of_pages) {
                            echo "<li><a  class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                        } ?>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>
<?php
// close connection
unset($pdo);
?>
<?php include('footer.php'); ?>