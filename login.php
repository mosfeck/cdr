<?php
//initialize the session
// session_start();

//check if the user is already logged in, if yes the redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

//include config file
require_once "config.php";

//define variable
$email = "";
$password = "";
$email_err = "";
$password_err = "";

//processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    //validate credentials
    if (empty($email_err) && empty($password_err)) {
        //prepare a select statement
        $sql = "select * from user_manage where email=:email";


        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $email = $row["email"];
                        $name = $row["name"];
                        // echo $name;exit;
                        // print_r($name);exit;
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {
                            //password is correct, so start a new session
                            session_start();

                            //store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            // echo $_SESSION["email"];exit;
                            $_SESSION["name"] = $name;
                            // echo $_SESSION["name"];exit;
                            // echo "Login successfuly";

                            //redirect user to welcome page
                            header("location: dashboard.php");
                        } else {
                            //display an error message if password is not valid
                            $password_err = "The password you entered was not correct";
                        }
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
    }
    unset($pdo);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon-96x96.png">
<style type="text/css">
    body {
        font: 14px sans-serif;
    }

    .wrapper {
        /* width: 350px;  */
        padding: 20px;
        margin: auto;
    }

    .form-group {
        margin: 10px;
        padding: 5px;
    }

    label {
        margin-bottom: 5px;
    }
    .card-body img{
        width: 150%;
    }
</style>
</head>

<body>
    <!-- <div class="d-flex align-items-center justify-content-center"> -->
    <div class="container mx-auto">
        <!-- <div class="d-flex align-items-center justify-content-center" style="width: 1200px;"> -->


        <div class="row ">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <!-- <h2 class="text-center">Login</h2> -->
                        <div class="card-header">
                        <img class="img-fluid" src="img/logon-logo3.png" alt="login image">
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="email" class="form-control col-md-8" value="<?php echo $email; ?>">
                                        <span class="help-block"><?php echo $email_err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Password</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="password" name="password" class="form-control">
                                        <span class="help-block"><?php echo $password_err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Login">
                                </div>
                                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3"></div>
        </div>
        <!-- </div> -->
    </div>
    <!-- </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>