<?php
//initialize the session
session_start();

//check if the user is already logged in, if yes the redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: membership_login.php");
    exit;
}

//include config file
require_once "config.php";

//define variable
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";



// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    $input_new_password = trim($_POST["new_password"]);
    if (empty($input_new_password)) {
        $new_password_err = "Please enter a new password.";
    } elseif (strlen($input_new_password) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } else {
        $new_password = $input_new_password;
    }

    // Validate confirm password
    $input_confirm_password = trim($_POST["confirm_password"]);
    if (empty($input_confirm_password)) {
        $confirm_password_err = "Please confirm the new password.";
    } else {
        $confirm_password = $input_confirm_password;
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }


    try {
        //validate credentials
        if (empty($new_password_err) && empty($confirm_password_err)) {
            //prepare a update statement
            $sql = "update users set password=:password where id=:id";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

                // Set parameters
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_id = $_SESSION["id"];

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    //password updated successfuly, destroy the session,
                    //and redirect to login page
                    //echo "Password updated successfuly";
                    session_destroy();
                    header("location: membership_login.php");
                    exit;
                } else {
                    echo "Opps! Something went wrong. Please try again later.";
                }
            }
            // Close statement
            unset($stmt);
        }
    } catch (PDOException $e) {
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    }
    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>DCCI :: Member Login</title>
        <!-- Web Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <!-- font-awesome CSS -->
        <!--<link href="css/font-awesome.min.css" rel="stylesheet">-->
        <!--<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">-->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <!-- Flaticon CSS -->
        <link href="fonts/flaticon/flaticon.css" rel="stylesheet">

        <!-- Offcanvas CSS -->
        <link href="css/hippo-off-canvas.css" rel="stylesheet">
        <!-- animate CSS -->
        <link href="css/animate.css" rel="stylesheet">
        <!-- language CSS -->
        <!--<link href="css/language-select.css" rel="stylesheet">-->
        <!-- owl.carousel CSS -->
        <link href="css/owl.carousel.css" rel="stylesheet">
        <!-- magnific-popup -->
        <!--<link href="css/magnific-popup.css" rel="stylesheet">-->
        <!-- Main menu -->
        <link href="css/menu.css" rel="stylesheet">
        <!-- Template Common Styles -->
        <link href="css/members.css" rel="stylesheet" />
        <link href="css/template.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/style.css" rel="stylesheet">

        <!-- Responsive CSS -->
        <link href="css/responsive.css" rel="stylesheet">
        <!--<script src="js/vendor/modernizr-2.8.1.min.js"></script>-->
        <!-- HTML5 Shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="js/vendor/html5shim.js"></script>
            <script src="js/vendor/respond.min.js"></script>
        <![endif]-->
        <link rel="icon" type="image/png" href="img/DCCI_image.png" />
        <script>
            $(document).ready(function () {
                $("#offcanvasMenu li a").click(function (event) {
                    $('#offcanvasMenu li').removeClass('open');
                    $(this).addClass('open');
                });
            });
        </script>
    </head>

    <body id="page-top">
        <div id="st-container" class="st-container">
            <div class="st-pusher">
                <div class="st-content">




                    <section class="page-title-section mt-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="page-header-wrap">
                                        <div class="page-header">
                                            <h1>DCCI Member Login</h1>
                                        </div>
                                        <ol class="breadcrumb">
                                            <li><a href="index.html">Home/ </a></li>
                                            <li class="active"> Reset Password</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>




                    <!-- Member details start -->
                    <div class="wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="page-header clearfix">
                                        <h2>Reset Password</h2>
                                        <p>Please fill out this form to reset your password.</p>
                                    </div>                  

                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                                    <label>New Password</label>
                                                    <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>" />
                                                    <span class="help-block">
                                                        <?php echo $new_password_err; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                                    <label>Confirm Password</label>
                                                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" />
                                                    <span class="help-block">
                                                        <?php echo $confirm_password_err; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                            <a class="btn btn-link" href="membership_details_Copy.php">Cancel</a>
                                        </div>

                                    </form>
                                </div>
                                <div class="col-md-offset-4 col-md-4">
                                </div>
                            </div>        
                        </div>
                    </div>
                    <!-- Member details end -->
                    <!-- footer-widget-section start -->
                    <!-- /.cta-section -->
                    <!-- footer-widget-section end -->
                    <!-- copyright-section start -->
                    <footer class="copyright-section">
                        <div class="container">
                            <div class="agileinfo_copy_right_left">
                                <p>© 2018 All rights reserved by DCCI</p>
                            </div>
                            <div class="agileinfo_copy_right_right">
                                <p>Developed by <a href="http://www.bdcom.com" target="_blank">BDCOM</a></p>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <!-- /.container -->
                    </footer>
                    <!-- copyright-section end -->
                </div> <!-- .st-content -->
            </div> <!-- .st-pusher -->
            <!-- OFF CANVAS MENU -->
            <!-- .offcanvas-menu -->

        </div><!-- /st-container -->
        <!-- Preloader -->
        <!-- jQuery -->
        <script src="js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- owl.carousel -->
        <script src="js/owl.carousel.min.js"></script>
        <!-- Magnific-popup -->
        <script src="js/jquery.magnific-popup.min.js"></script>
        <!-- Offcanvas Menu -->
        <script src="js/hippo-offcanvas.js"></script>
        <!-- inview -->
        <!--<script src="js/jquery.inview.min.js"></script>-->
        <!-- stellar -->
        <script src="js/jquery.stellar.js"></script>
        <!-- countTo -->
        <script src="js/jquery.countTo.js"></script>
        <!-- classie -->
        <!--<script src="js/classie.js"></script>-->
        <!-- selectFx -->
        <!--<script src="js/selectFx.js"></script>-->
        <!-- sticky kit -->
        <!--<script src="js/jquery.sticky-kit.min.js"></script>-->
        <!-- GOGLE MAP -->
        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <!--TWITTER FETCHER-->
        <!--<script src="js/twitterFetcher_min.js"></script>-->
        <!-- Custom Script -->
        <script src="js/scripts.js"></script>
    </body>
</html>
