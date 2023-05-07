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

    /* .card-img-bottom{
        width: 30%;
    } */
    /* .center-item {
        text-align: center;

    } */

    .center-item .card-title .card-img-alignright {
        display: block;
        margin: 0 auto;
    }

    a {
        /* color: #fff; */
        text-decoration: none;
    }

    .card-img-alignright {
        width: 30%;
    }

    .missed {
        text-align: center;
        /* background-color: red; */
    }

    .domains {
        text-align: center;
        /* background-color: green; */
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
$id = $name = $email = $phone = $designation = $department =  $password = $confirm_password = $missedCall = $apiCall = "";
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
                // echo $name;exit;
                // print_r($name);exit;
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
$sql = "SELECT count(accountcode) as missedCall FROM `cdr` WHERE accountcode = 'MISSEDCALL'";
if ($stmt = $pdo->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    // $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

    // Set parameters
    // $param_email = $_SESSION["email"];
    // echo $param_email;exit;
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
                $missedCall = $row['missedCall'];
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

// Missed called
$sql = "SELECT count(apiCalling) as apiCall FROM `cdr` WHERE `apiCalling` > 0";
if ($stmt = $pdo->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    // $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

    // Set parameters
    // $param_email = $_SESSION["email"];
    // echo $param_email;exit;
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
//close statement
// unset($stmt);
// unset($pdo);
?>



<div class="container">
    
    <div class="row clearfix ">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card widget_2 big_icon user-info first-item-color">
                <div class="card-body center-item">
                    <a href="user.php">
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
            <div class="card widget_2 big_icon user-info">
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
            $result = $pdo->query($sql); { ?>
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
                                    <!-- <td style="max-width: 60px;"><a href="update_user.php?id=<?php //echo $id; 
                                                                                                    ?>" title="Edit" ><img src="img/edit.png" alt="edit image" style="width:20%;margin-right: 5px;"></a>
                                <a href="delete_user.php?id=<?php //echo $id; 
                                                            ?>" onclick="return confirm('Are you sure you want to Delete?')" title="Delete"><img src="img/clear.png" alt="edit image" style="width:20%"></a>
                            </td> -->
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $row['uniqueid']; ?></td>
                                    <td><?php echo $row['calldate']; ?></td>
                                    <td><?php echo $row['srcmain']; ?></td>
                                    <td><?php echo $row['apiTime']; ?></td>
                                    <td><?php echo $row['apiCalling'] == 1 ? 'Yes' : 'No'; ?></td>
                                </tr>
                            <?php
                                unset($pdo);
                            } ?>
                        </tbody>
                    </table>
                </div>
            <?php

            }
            // close connection
            unset($pdo);
            ?>
        </div>
    </div>
</div>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" /> -->

<script>
    $(document).ready(function() {
        $('#cdr-table').DataTable();
    });
</script>
<!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> -->
<?php include('footer.php'); ?>