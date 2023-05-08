<?php include('header.php'); ?>
<style>
	.form-group {
            margin: 10px;
            padding: 5px;
        }
		.center-item {
            text-align: center;
        }
        .center-item .center-align{
            display: block;
            margin: 0 auto;
        } 
        .card-header{
            background-color: #fff;
        }
</style>
<?php

//inisialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//include config file
require_once "config.php";

//define variables and initialize with empty values
$new_password=$confirm_password="";
$new_password_err=$confirm_password_err="";

//processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	//validate new password
	if(empty(trim($_POST["new_password"])))
	{
		$new_password_err="Please enter the new password.";
	}
	elseif (strlen(trim($_POST["new_password"])) < 6) {
		$new_password_err="Password must have atleast 6 characters.";
	}
	else
	{
		$new_password=trim($_POST["new_password"]);
	}

	//validate confirm password
	if(empty(trim($_POST["confirm_password"])))
	{
		$confirm_password_err="Please confirm the new password.";
	}
	else
	{
		$confirm_password=trim($_POST["confirm_password"]);
		if(empty($new_password_err) && ($new_password!=$confirm_password))
		{
			$confirm_password_err="Password did not match.";
		}
	}

	//check input errors before updating the database
	if(empty($new_password_err) && empty($confirm_password_err))
	{
		//prepare an update statement
		$sql="update user_manage set password=:password where id=:id";
		if($stmt=$pdo->prepare($sql))
		{
			// Bind variables to the prepared statement as parameters
			$stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
			$stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

			//Set parameters
			$param_password=password_hash($new_password, PASSWORD_DEFAULT);
			$param_id=$_SESSION["id"];

			// Attempt to execute the prepared statement
			if($stmt->execute())
			{
				//password updated successfuly, destroy the session,
				//and redirect to login page
				session_destroy();
				header("location: login.php");
				exit;
			}
			else
			{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		//close statement
		unset($stmt);
	}
	//close connection
    unset($pdo);
}
?>
<div class="container mx-auto">
        <div class="row ">
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2"></div>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
							Change Password
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>New Password</label>
                                    </div>
                                    <div class="col-md-8">
									<input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                                        <span class="help-block"><?php echo $new_password_err; ?></span>
                                    </div>
                                </div>
                            </div>
							<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Confirm Password</label>
                                    </div>
                                    <div class="col-md-8">
									<input type="password" name="confirm_password" class="form-control">
                                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="center-item">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary center-align" value="Submit">
                                                <!-- <p class="center-align mt-2">Don't have an account? <a href="create_user.php">Sign up now</a>.</p> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2"></div>
        </div>
    </div>

    <!-- <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>     -->
<?php include('footer.php'); ?>