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
$name = $email = $phone = $designation = $department =  $password = $confirm_password = "";
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
                // $id = $row["id"];
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            /* text-align: center;  */
            /*margin: 0 auto;*/
        }
        .page-header{
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">


        <div class="page-header">
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b></h1>
        </div>
        <div class="body ">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 mx-auto">

                    <div class="row ">
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <label>Email</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-4">
                            <div class="form-group">
                                <?php echo $_SESSION['email']; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <label>Phone</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-4">
                            <div class="form-group">
                                <?php echo $phone; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <label>Designation</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-4">
                            <div class="form-group">
                                <?php echo isset($designation) ? $designation : ""; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <label>Department</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-4">
                            <div class="form-group">
                                <?php echo isset($department) ? $department : ''; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <label>Status</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-4">
                            <div class="form-group">
                                <?php echo $status==1 ? 'Active':'Inactive'; ?>
                            </div>
                        </div>
                    </div>
                    <p>
                        <a href="update-user.php" class="btn btn-warning">Update User</a>
                        <a href="delete-user.php" class="btn btn-danger">Delete User</a>
                    </p>
                    <p>
                        <!-- <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a> -->
                        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
                    </p>
                </div>
                <div class="col-sm-3"></div>
            </div>

        </div>
    </div>
</body>

</html>