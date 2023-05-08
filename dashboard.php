<?php include('header.php'); ?>
<link rel="stylesheet" href="css/style.css" type="text/css">
<style type="text/css">
    .user-info {
        background-color: #F0FFFF;
        color: #000;
    }

    .first-item-color{
        background-color: #F5F5DC;
    }
    .second-item-color{
        background-color: #FFFFE0;
    }
    .third-item-color{
        background-color: #A0D6B4;
    }
    .user-info .row{
        margin: 10px 0px;
    }

    .body {
        padding: 15px;
    }

    .center-item .card-title .card-img-alignright {
        display: block;
        margin: 0 auto;
    }

    a {
        text-decoration: none;
    }

    .card-img-alignright {
        width: 30%;
    }

    .missed {
        text-align: center;
    }
    .domains {
        text-align: center;
    }
    .top-space{
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
$id = $name = $email = $phone = $status = $department = $missedCall = $apiCall = "";
//prepare a select statement
$sql = "SELECT * from user_manage WHERE email=:email";
if ($stmt = $pdo->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

    // Set parameters
    $param_email = $_SESSION["email"];
    // echo $param_email;exit;
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
                $id = $row["id"];
                $name = $row["name"];
                $phone = $row["phone"];
                $designation = $row["designation"];
                $department = $row["department"];
                $status = $row["status"];
            }
        } else {
            //display an error message if email doesn't exit
            $email_err = "No account found with that email.";
        }
    } else {
        echo "Opps! something went wrong. Please try again later.";
    }
}

// Missed called
$sql = "SELECT count(accountcode) as missedCall FROM `cdr` WHERE 
            accountcode = 'MISSEDCALL' AND 
            calldate BETWEEN '" . date('y-m-d') . " 00:00:00' 
            AND '" . date('y-m-d') . " 23:59:59'";
if ($stmt = $pdo->prepare($sql)) {
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
                $missedCall = $row['missedCall'];
            }
        } else {
            //display an error message if email doesn't exit
            $email_err = "No account found with that email.";
        }
    } else {
        echo "Opps! something went wrong. Please try again later.";
    }
}

// Missed called
$sql = "SELECT count(apiCalling) as apiCall FROM `cdr` WHERE 
        `apiCalling` > 0  AND 
        calldate BETWEEN '" . date('y-m-d') . " 00:00:00' 
        AND '" . date('y-m-d') . " 23:59:59'";
if ($stmt = $pdo->prepare($sql)) {
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
                $apiCall = $row['apiCall'];
                // print_r($id);exit;
            }
        } else {
            //display an error message if email doesn't exit
            $email_err = "No account found with that email.";
        }
    } else {
        echo "Opps! something went wrong. Please try again later.";
    }
}

?>



<div class="container">
    <div class="row clearfix ">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card widget_2 big_icon user-info first-item-color" >
                <div class="card-body center-item">
                    <a href="#user-info">
                        <h5 class="card-title">User Manage</h5>
                        <img class="card-img-alignright" src="img/user-icon.png" alt="user image">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card widget_2 big_icon missed second-item-color">
                <div class="body">
                    <h5>Today Missed Call
                        <strong>
                            <?php echo $missedCall; ?>
                        </strong>
                    </h5>
                    <img class="card-img-alignright" src="img/missed-call.png" alt="missed image">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card widget_2 big_icon domains third-item-color">
                <div class="body">
                    <h5>Today API Call
                        <strong>
                            <?php echo $apiCall; ?>
                        </strong>
                    </h5>
                    <img class="card-img-alignright" src="img/api-call.png" alt="missed image">
                </div>
            </div>
        </div>
    </div>

    <!-- user info -->
    <div class="row  top-space">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card widget_2 big_icon user-info" id="user-info">
                <div class="card-body">
                    <h5 class="card-title">User Info</h5>

                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-sm-4 ">
                            <label>Name</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group">
                                <?php echo $name; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-sm-4 ">
                            <label>Email</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group">
                                <?php echo $_SESSION['email']; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-sm-4 ">
                            <label>Phone</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group">
                                <?php echo $phone; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-sm-4 ">
                            <label>Designation</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group">
                                <?php echo isset($designation) ? $designation : ""; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-sm-4 ">
                            <label>Department</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group">
                                <?php echo isset($department) ? $department : ''; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-sm-4 ">
                            <label>Status</label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="form-group">
                                <?php echo $status == 1 ? 'Active' : 'Inactive'; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-12 col-sm-12">
            <?php
            //prepare a select statement
            $sql = "SELECT * from cdr ORDER BY calldate DESC limit 20 ";
            $result = $pdo->query($sql);  ?>
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
                            foreach ($result as $row) {
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
                                unset($stmt);
                            } ?>
                        </tbody>
                    </table>
                </div>
            <?php

            
            // close connection
            unset($pdo);
            ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cdr-table').DataTable();
    });
</script>
<?php include('footer.php'); ?>