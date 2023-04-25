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
$id = $name = $email = $phone = $designation = $department =  $password = $confirm_password = "";
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
//close statement
unset($stmt);
unset($pdo);
?>
<?php include('header.php'); ?>
<style type="text/css">
    .user-info {
        background-color: blue;
        /* font: 14px sans-serif; */
    }

    .body {
        padding: 15px;
    }

    .card-img-bottom{
        width: 30%;
    }
    /*.page-header{
            text-align: center;
        }
        h1{
            border-bottom: 1px solid;
        }
        .row{
            margin: 5px;
        }
        .action_button{
            margin-top: 15px;
        } */
</style>


<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card widget_2 big_icon user-info">
                <div class="card-body">
                    <h5 class="card-title">User Manage</h5>
                    <img class="card-img-bottom" src="img/user-icon.png" alt="user image">
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card widget_2 big_icon sales">
                <div class="body">
                    <h6>Sales</h6>
                    <h2>12% <small class="info">of 100</small></h2>
                    <small>6% higher than last month</small>
                    <div class="progress">
                        <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: 38%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card widget_2 big_icon email">
                <div class="body">
                    <h6>Email</h6>
                    <h2>39 <small class="info">of 100</small></h2>
                    <small>Total Registered email</small>
                    <div class="progress">
                        <div class="progress-bar l-purple" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 39%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card widget_2 big_icon domains">
                <div class="body">
                    <h6>Domains</h6>
                    <h2>8 <small class="info">of 10</small></h2>
                    <small>Total Registered Domain</small>
                    <div class="progress">
                        <div class="progress-bar l-green" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- user info -->
    <div class="row  mt-5">
        <div class="col-lg-3 col-md-6 col-sm-12">
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

        <div class="col-lg-9 col-md-12 col-sm-12">

        </div>
    </div>
</div>
<?php include('footer.php'); ?>