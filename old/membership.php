<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $company = $phone = $email = $address = $business = $message = "";
$name_err = $company_err = $phone_err = $email_err = $address_err = $business_err = $message_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

	// Validate company
	$input_company=trim($_POST["company"]);
	if(empty($input_company)){
		$company_err="Please enter a company name";
	}
	elseif(!filter_var($input_company, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
		$company_err="Please enter a valid company name.";
	}
	else{
		$company=$input_company;
	}

	// Validate phone
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter an phone number.";
    } else{
        $phone = $input_phone;
    }

	// Validate email
	$input_email=trim($_POST["email"]);
	if(empty($input_email)){
		$email_err="Please enter a email.";
	}
	elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL)){
		$email_err="Please enter a valid email.";
	}
	else{
		$email=$input_email;
	}

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";
    } else{
        $address = $input_address;
    }

	// Validate business
    $input_business = trim($_POST["business"]);
    if(empty($input_business)){
        $business_err = "Please enter an business.";
    } else{
        $business = $input_business;
    }

	// Validate message
    $input_message = trim($_POST["message"]);
    if(empty($input_message)){
        $message_err = "Please enter an message.";
    } else{
        $message = $input_message;
    }


    try
	{
		// Check input errors before inserting in database
		if(empty($name_err) && empty($company_err) && empty($phone_err) && empty($email_err) && empty($address_err) && empty($business_err) && empty($message_err)){
			// Prepare an insert statement
			$sql = "INSERT INTO memberdetails (MemberName, CompanyName, Phone, Email, Address, Business, Message) VALUES (:name, :company, :phone, :email, :address, :business, :message)";
 
			if($stmt = $pdo->prepare($sql)){
				// Bind variables to the prepared statement as parameters
				$stmt->bindParam(":name", $param_name);
				$stmt->bindParam(":company", $param_company);
				$stmt->bindParam(":phone", $param_phone);
				$stmt->bindParam(":email", $param_email);
				$stmt->bindParam(":address", $param_address);
				$stmt->bindParam(":business", $param_business);
				$stmt->bindParam(":message", $param_message);
            
				// Set parameters
				$param_name = $name;
				$param_company = $company;
				$param_phone = $phone;
				$param_email = $email;
				$param_address = $address;
				$param_business = $business;
				$param_message = $message;
            
				// Attempt to execute the prepared statement
				if($stmt->execute()){
					// Records created successfully. Redirect to landing page
					//echo "Records inserted successfully.";
					//die("Records inserted successfully.");
					header("location: membership_details.php");
					exit();
				} else{
					echo "Something went wrong. Please try again later.";
				}
			}
         
			// Close statement
			unset($stmt);
		}
	}
    catch(PDOException $e)
	{
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
    <title>DCCI :: Membership</title>
    <!-- Web Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Flaticon CSS -->
    <link href="fonts/flaticon/flaticon.css" rel="stylesheet">
    <!-- font-awesome CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
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

                <header id="header">
                    <div class="header-top">
                        <!-- /.top-bar -->
                        <div id="search">
                            <button type="button" class="close">×</button>
                            <form>
                                <input type="search" value="" placeholder="type keyword(s) here" />
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                        <div class="banner-bar">
                            <div class="overlay-bg2">
                                <div class="container">
                                    <div class="row">

                                        <div class="col-sm-8 col-xs-12">
                                            <!--<div class="call-to-action">
                                                <ul class="list-inline">
                                                    <li><a href="#"><i class="fa fa-phone"></i> +88 02 9552562</a></li>
                                                    <li><a href="#"><i class="fa fa-envelope"></i> info@dhakachamber.com</a></li>
                                                </ul>
                                            </div>-->
                                            <div class="banner-image">
                                                <a href="index.html"><img src="img/banner_final.jpg" alt="banner-photo" class="img-responsive"></a>
                                            </div>
                                        </div>



                                        <div class="col-sm-4 hidden-xs">
                                            <div class="topbar-right pull-right">
                                                <img src="img/iso_dcci.png" alt="iso-photo" class="img-responsive">
                                                <!--<div class="lang-support pull-right">
                                                    <a href="#search"><i class="img/aboutfa fa-search"></i></a>
                                                    <select class="cs-select cs-skin-elastic">
                                                        <option value="" disabled selected>Language</option>
                                                        <option value="united-kingdom" data-class="flag-uk">English</option>
                                                        <option value="france" data-class="flag-france">French</option>
                                                        <option value="spain" data-class="flag-spain">Spanish</option>
                                                        <option value="south-africa" data-class="flag-bd">Bengali</option>
                                                    </select>
                                                </div>
                                                <ul class="social-links list-inline pull-right">
                                                    <li><a href="https://www.facebook.com/DhakaCCI/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                                    <li><a href="https://www.youtube.com/channel/UCC5d7b-4nh4BYVeFjBNcJ9g/" target="_blank"><i class="fa fa-youtube"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-search"></i></a></li>
                                                </ul>
                                                <div class="search-icons list-inline pull-right">
                                                    <a href="#search"><i class="fa fa-search"></i></a>
                                                </div>-->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav class="navbar navbar-expand-md navbar-default" role="navigation">

                        <div class="container mainnav">
                            <!--<div class="navbar-header">
                                <div class="call-to-action">
                                    <ul class="list-inline">
                                        <li><a href="#"><i class="fa fa-phone"></i> +88 02 9552562</a></li>
                                        <li><a href="#"><i class="fa fa-envelope"></i> info@dhakachamber.com</a></li>
                                    </ul>
                                </div>
                            </div>-->
                            <!-- offcanvas-trigger -->
                            <button type="button" class="navbar-toggle pull-right navbar-toggler navbar-toggler-right" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" style="display: none;">
                                <span class="sr-only">Toggle navigation</span>
                                <i class="fa fa-bars"></i>
                            </button>

                            <div class="navbar-brand">
                                <a href="#"><i class="fa fa-phone"></i> +88 02 9552562</a>
                                <a href="#"><i class="fa fa-envelope"></i> info@dhakachamber.com</a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">


                                <!--<span class="search-button pull-right"><a href="#search"><i class="fa fa-search"></i></a></span>-->
                                <ul class="nav navbar-nav navbar-right">
                                    <!-- Home -->
                                    <!--<li class="dropdown active">
                                        <a href="#">Home</a>
                                    </li>-->
                                    <!-- /Home -->
                                    <!-- Pages -->
                                    <li class="dropdown mega-fw has-megamenu nav-item">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">About us</a>
                                        <!-- megamenu-wrapper -->
                                        <div class="submenu-wrapper megamenu-wrapper">
                                            <div class="submenu-inner megamenu-inner">

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <div class="mega-content">
                                                            <div class="row">

                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">About us</li>
                                                                        <li><a href="about.html" target="_blank">Brief About DCCI</a></li>
                                                                        <li><a href="#">Policy and Objectives</a></li>
                                                                        <li><a href="#">International Affiliations</a></li>
                                                                        <li><a href="#">DCCI Founders</a></li>
                                                                        <li><a href="#">Former Presidents</a></li>
                                                                        <li><a href="#">Achievements & Awards</a></li>
                                                                        <li><a href="#">DCCI Introducing 2018</a></li>
                                                                    </ul>
                                                                </div><!-- /.col -->


                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">Organizational Information</li>
                                                                        <li><a href="directors.html" target="_blank">Board of Directors</a></li>
                                                                        <li><a href="#">DCCI Standing Committee-2018</a></li>
                                                                        <li><a href="#">DCCI Secretariat</a></li>
                                                                        <li><a href="#">Bilateral MOU with DCCI</a></li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                    </ul>
                                                                </div><!-- /.col-->

                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">President</li>
                                                                        <li class="img-details">
                                                                            <a href="#">
                                                                                <img src="img/Abul_Kasem.jpg" alt="founder image" class="img-responsive" />

                                                                        </li>


                                                                        <p class="menu-pic">President Message</p>
                                                                        </a>


                                                                    </ul>
                                                                </div>
                                                                <div class="col-sm-3 mega-col">
                                                                    <p>
                                                                        <strong>Dhaka Chamber of Commerce & Industry (DCCI)</strong>, established in 1958 under companies Act 1913
                                                                        is the largest and most vibrant business chamber in Bangladesh. Its membership consists of
                                                                        industrial conglomerates, manufacturers, importers, exporters and traders mostly of small
                                                                        and medium enterprises (SMEs).
                                                                        <a href="#"><strong>More...</strong></a>
                                                                    </p>
                                                                </div><!-- /.col-->
                                                            </div><!-- /.row -->
                                                        </div><!-- /.mega-content -->
                                                    </li>
                                                </ul><!-- /.dropdown menu -->
                                            </div><!-- /.megamenu-inner -->
                                        </div> <!-- /.megamenu-wrapper -->
                                    </li> <!-- /MEGA MENU -->
                                    <!-- /Pages -->
                                    <!--Member-->
                                    <li class="dropdown nav-item">
                                        <a href="#" class="nav-link">Membership</a>
                                        <!-- submenu-wrapper -->
                                        <div class="submenu-wrapper">
                                            <div class="submenu-inner">
                                                <ul class="dropdown-menu">
                                                    <li><a href="membership.html" target="_blank">Become a Member</a></li>
                                                    <li><a href="#">Eligibility</a></li>
                                                    <li><a href="#">Application Procedure</a></li>
                                                    <li><a href="#">Membership Form</a></li>
                                                    <li><a href="#">Benefit of being a Member</a></li>
                                                    <li><a href="#">Member search</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /submenu-wrapper -->
                                    </li>
                                    <!--Project-->
                                    <li class="dropdown nav-item">
                                        <a href="#" class="nav-link">Projects</a>
                                    </li>
                                    <!-- Feature -->
                                    <!-- MEGA MENU -->
                                    <li class="dropdown mega-fw has-megamenu nav-item">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">Media</a>
                                        <!-- megamenu-wrapper -->
                                        <div class="submenu-wrapper megamenu-wrapper">
                                            <div class="submenu-inner megamenu-inner">

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <div class="mega-content">
                                                            <div class="row">

                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">Seminar & Workshop</li>
                                                                        <li><a href="#">Upcoming Seminar & Workshop</a></li>
                                                                        <li><a href="#">Previous Seminar & Workshop</a></li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                    </ul>
                                                                </div><!-- /.col -->


                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">Research & Publications</li>
                                                                        <li><a href="#">DCCI Budget proposal</a></li>
                                                                        <li><a href="#">Annual Reports</a></li>
                                                                        <li><a href="#">DCCI Review</a></li>
                                                                        <li><a href="#">Other DCCI Publications</a></li>
                                                                        <li><a href="#">Commercial History of Bangladesh</a></li>
                                                                        <li><a href="#">Economic Policy of CIPE, DCCI</a></li>
                                                                        <li><a href="#">Business Start-up Licenses</a></li>
                                                                    </ul>
                                                                </div><!-- /.col-->

                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">Downloads</li>
                                                                        <li><a href="#">Reports</a></li>
                                                                        <li><a href="#">Other Downloads</a></li>
                                                                        <li><a href="#">Other Presentation</a></li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                    </ul>
                                                                </div><!-- /.col-->

                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">Media Corner</li>
                                                                        <li><a href="#">Latest News</a></li>
                                                                        <li><a href="#">Events</a></li>
                                                                        <li><a href="#">News Link</a></li>
                                                                        <li><a href="#">Photo Gallery</a></li>
                                                                        <li><a href="#">Video Gallery</a></li>
                                                                        <li><a href="#">DCCI News Link</a></li>
                                                                        <li><a href="#">DCCI News Coverage (Electronic Media)</a></li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.col-->
                                                            </div><!-- /.row -->
                                                        </div><!-- /.mega-content -->
                                                    </li>
                                                </ul><!-- /.dropdown menu -->
                                            </div><!-- /.megamenu-inner -->
                                        </div> <!-- /.megamenu-wrapper -->
                                    </li> <!-- /MEGA MENU -->
                                    <!-- /Pages -->
                                    <!-- Blog -->
                                    <li class="dropdown mega-fw has-megamenu nav-item">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">Bangladesh</a>
                                        <!-- megamenu-wrapper -->
                                        <div class="submenu-wrapper megamenu-wrapper">
                                            <div class="submenu-inner megamenu-inner">

                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <div class="mega-content">
                                                            <div class="row">

                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">About Bangladesh</li>
                                                                        <li><a href="#">General Information</a></li>
                                                                        <li><a href="#">Business Opportunities in Bangladesh</a></li>
                                                                        <li><a href="#">Trade Information</a></li>
                                                                        <li><a href="#">Important Links</a></li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                    </ul>
                                                                </div><!-- /.col -->


                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <li class="dropdown-header">POLICY</li>
                                                                        <li><a href="#">Export Policy</a></li>
                                                                        <li><a href="#">Import Policy</a></li>
                                                                        <li><a href="#">Industry Policy</a></li>
                                                                        <li><a href="#">ICT Policy</a></li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                        <li>&nbsp;</li>
                                                                    </ul>
                                                                </div><!-- /.col-->

                                                                <div class="col-sm-3 mega-col">

                                                                    <ul>
                                                                        <li class="dropdown-header">BILATERAL TRADE</li>
                                                                        <li><a href="#">SAARC</a></li>
                                                                        <li><a href="#">Asian</a></li>
                                                                        <li><a href="#">ASEAN</a></li>
                                                                        <li><a href="#">Middle East</a></li>
                                                                        <li><a href="#">European Union</a></li>
                                                                        <li><a href="#">America</a></li>
                                                                        <li><a href="#">Middle East</a></li>

                                                                    </ul>
                                                                </div><!-- /.col-->
                                                                <div class="col-sm-3 mega-col">
                                                                    <ul>
                                                                        <!--<li class="dropdown-header"></li>-->
                                                                        <li class="img-about-details">
                                                                            <a href="#">
                                                                                <img src="img/img_map.jpg" alt="founder image" class="img-responsive" />
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div><!-- /.row -->
                                                        </div><!-- /.mega-content -->
                                                    </li>
                                                </ul><!-- /.dropdown menu -->
                                            </div><!-- /.megamenu-inner -->
                                        </div> <!-- /.megamenu-wrapper -->
                                    </li>
                                    <!-- Contact -->

                                </ul>

                            </div><!-- /.navbar-collapse -->

                        </div><!-- /.container -->

                    </nav>

                </header>


                <section class="page-title-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-header-wrap">
                                    <div class="page-header">
                                        <h1>DCCI Membership</h1>
                                    </div>
                                    <ol class="breadcrumb">
                                        <li><a href="index.html">Home</a></li>
                                        <li class="active">Membership</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Single-Service-Start -->
                <section class="single-service-contents">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-5 col-xs-12">
                                <div class="service-sidebar sidebar-wrapper">
                                    <div class="widget">
                                        <!--<h2 class="widget-title">About Us</h2>-->
                                        <ul class="service-list">
                                            <li class="active">Become a Member</li>
                                            <li><a href="#">Eligibility</a></li>
                                            <li><a href="#">Application Procedure</a></li>
                                            <li><a href="#">Membership Form</a></li>
                                            <li><a href="#">Benefit of being a Member</a></li>
                                            <li><a href="#">Member search</a></li>
                                        </ul>
                                    </div><!-- /.widget -->
                                    <div class="widget">
                                        <div class="download-wrap company">
                                            <a href="#">Projects <span>View details</span><i class="fa fa-download"></i></a>
                                        </div> <!-- /.download-wrap -->
                                        <div class="download-wrap annual">
                                            <a href="#">Seminar & Workshop <span>View details</span><i class="fa fa-download"></i></a>
                                        </div> <!-- /.download-wrap -->
                                        <div class="download-wrap brochure">
                                            <a href="#">Research & Publications <span>View details</span><i class="fa fa-download"></i></a>
                                        </div> <!-- /.download-wrap -->
                                    </div><!-- /.widget -->
                                    <!--<div class="widget">
                                        <h2 class="widget-title">Office Hours</h2>
                                        <div class="textwidget">
                                            <p>
                                                Monday -
                                                Friday: 9:00 - 18:00<br>
                                                Saturday: 9:00 - 2:00<br>
                                                Holidays: 9:00 - 12:00
                                            </p>
                                        </div>
                                    </div>-->
                                    <!-- /.widget -->
                                </div><!-- /.sidebar-wrapper -->
                            </div><!-- /.col -->
                            <div class="col-md-9 col-sm-7 col-xs-12">
                                <div class="single-service-content">
                                    <div class="single-service-thumb">
                                        <img src="img/member-thumb.jpg" alt="image" />
                                    </div>
                                    <!--<h2>Member</h2>-->
                                    <p>Persons, firms, companies (including multinational companies) and corporate bodies (including sector corporations, banks, insurance etc.) engaged in trade, industry or any other kind of business are eligible for membership of the Dhaka Chamber of Commerce and Industry (DCCI).</p>
                                    <p><strong>FOREIGN COMPANIES:</strong> Foreign Companies, Corporate Bodies operating in Bangladesh shall also be eligible for membership of the Dhaka Chamber of Commerce and Industry.</p>
                                    <P><strong>APPLICATION FOR MEMBERSHIP:</strong> Every candidate for membership shall sign and deliver the prescribed form to the Secretary General, duly proposed by a member and seconded by another, of the class to which the candidate wants to be admitted with admission fee and annual subscription.</P>
                                    <p>The DCCI authority holds the right to admit or decline a candidate for admission as a Member as they may think fit.</p>


                                </div><!-- /.single-service-content -->

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </section>
                <!-- Single-Service-End-->
                <!-- PHP code for form-->
				

                <!-- cta start -->
                <section class="cta-section">
                    <div class="container text-center">
                        <a id="myBtn" data-toggle="modal" data-target="#quoteModal" class="btn btn-primary quote-btn">Get a Membership</a>

                        <div class="modal fade" id="quoteModal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                        <h3 class="modal-title" id="quoteModalLabel">Get a Membership from DCCI</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
														<label for="name">Name</label>
														<input id="name" name="name" type="text" class="form-control" value="<?php echo $name; ?>" placeholder="">
															<span class="help-block"><?php echo $name_err;?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group <?php echo (!empty($company_err)) ? 'has-error' : ''; ?>">
														<label for="company">Company Name</label>
														<input id="company" name="company" type="text" class="form-control" value="<?php echo $company; ?>" placeholder="">
														<span class="help-block"><?php echo $company_err;?></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
														<label for="phone">Phone Number</label>
														<input id="phone" name="phone" type="tel" class="form-control" value="<?php echo $phone; ?>" placeholder="">
														<span class="help-block"><?php echo $phone_err;?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
														<label for="email">Email address</label>
														<input id="email" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="">
														<span class="help-block"><?php echo $email_err;?></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
														<label for="city">Address</label>
														<input id="city" name="address" type="text" class="form-control" value="<?php echo $address; ?>" placeholder="">
														<span class="help-block"><?php echo $address_err;?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group <?php echo (!empty($business_err)) ? 'has-error' : ''; ?>">
														<label for="subject">Business Type</label>
														<input id="subject" name="business" type="text" class="form-control" value="<?php echo $business; ?>"  placeholder="">
														<span class="help-block"><?php echo $business_err;?></span>
													</div>
												</div>
											</div>
											<div class="form-group text-area <?php echo (!empty($message_err)) ? 'has-error' : ''; ?>">
												<label for="message">Your Message</label>
												<textarea id="message" name="message" type="text" class="form-control" rows="6" value="<?php echo $message; ?>"  placeholder=""></textarea>
												<span class="help-block"><?php echo $message_err;?></span>
											</div>
											<input type="submit" class="btn btn-primary" value="Submit">
										</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- cta end -->
                <!-- footer-widget-section start -->
                <section class="footer-widget-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="footer-widget">
                                            <h3>QUICK LINK</h3>
                                            <ul>
                                                <li><a href="#">Home</a></li>
                                                <li><a href="#">About us</a></li>
                                                <li><a href="#">Publications</a></li>
                                                <li><a href="#">Media</a></li>
                                                <li><a href="#">Bangladesh</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="footer-widget">
                                            <h3>USEFUL LINK</h3>
                                            <ul>
                                                <li><a href="#" target="_blank">Latest News</a></li>
                                                <li><a href="#" target="_blank">Events</a></li>
                                                <li><a href="#" target="_blank">DCCI Review</a></li>
                                                <li><a href="#" target="_blank">Photo Gallery</a></li>
                                                <li><a href="#" target="_blank">Video Gallery</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.footer-widget -->
                            </div>
                            <!-- /.col-sm-4 -->

                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="footer-widget">
                                            <h3>MEMBERSHIP</h3>
                                            <ul>
                                                <li><a href="#">Eligibility</a></li>
                                                <li><a href="#">Application Procedure</a></li>
                                                <li><a href="#">Membership Form</a></li>
                                                <li><a href="#">Benefit of being a Member</a></li>
                                                <li><a href="#">Member search</a></li>
                                            </ul>
                                        </div>
                                        <!-- /.footer-widget -->
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="footer-widget">
                                            <h3>MEDIA</h3>
                                            <ul>
                                                <li><a href="#">Media Corner</a></li>
                                                <li><a href="#">Seminar & Workshop</a></li>
                                                <li><a href="#">Research & Publications</a></li>
                                            </ul>
                                        </div>
                                        <!-- /.footer-widget -->
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="footer-widget">
                                            <h3>DOWNLOAD</h3>
                                            <ul>
                                                <li><a href="#">Reports</a></li>
                                                <li><a href="#">Other Downloads</a></li>
                                                <li><a href="#">Other Presentation</a></li>
                                                <li><a href="#">DBI College</a></li>
                                                <li><a href="#">DCCI Business Institute</a></li>
                                            </ul>
                                        </div>
                                        <!-- /.footer-widget -->
                                    </div>
                                </div>

                                <!-- /.footer-widget -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container -->
                </section><!-- /.cta-section -->
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
        <div class="offcanvas-menu offcanvas-effect">
            <div class="offcanvas-wrap">
                <div class="off-canvas-header">
                    <button type="button" class="close" aria-hidden="true" data-toggle="offcanvas" id="off-canvas-close-btn">&times;</button>
                </div>
                <ul id="offcanvasMenu" class="list-unstyled visible-xs visible-sm">
                    <li class="active"><a href="index.html">Home<span class="sr-only">(current)</span></a></li>
                    <li>
                        <a href="#">About us</a>
                        <ul>
                            <li><a href="about.html" target="_blank">Brief About DCCI</a></li>
                            <li><a href="#">Policy and Objectives</a></li>
                            <li><a href="#">International Affiliations</a></li>
                            <li><a href="#">DCCI Founders</a></li>
                            <li><a href="#">Former Presidents</a></li>
                            <li><a href="#">Achievements & Awards</a></li>
                            <li><a href="#">DCCI Introducing 2018</a></li>
                            <li><a href="directors.html" target="_blank">Board of Directors</a></li>
                            <li><a href="#">DCCI Standing Committee-2018</a></li>
                            <li><a href="#">DCCI Secretariat</a></li>
                            <li><a href="#">Bilateral MOU with DCCI</a></li>
                        </ul>

                    </li>
                    <li>
                        <a href="#">Membership</a>
                        <ul>
                            <li><a href="membership.html" target="_blank">Become a Member</a></li>
                            <li><a href="#">Eligibility</a></li>
                            <li><a href="#">Application Procedure</a></li>
                            <li><a href="#">Membership Form</a></li>
                            <li><a href="#">Benefit of being a Member</a></li>
                            <li><a href="#">Member search</a></li>
                        </ul>

                    </li>
                    <li class="dropdown">
                        <a href="#">Projects</a>
                    </li>
                    <li>
                        <a href="#">Seminar</a>
                        <ul>
                            <li><a href="#">Upcoming Seminar & Workshop</a></li>
                            <li><a href="#">Previous Seminar & Workshop</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Publications</a>
                        <ul>
                            <li><a href="#">DCCI Budget proposal</a></li>
                            <li><a href="#">Annual Reports</a></li>
                            <li><a href="#">DCCI Review</a></li>
                            <li><a href="#">Other DCCI Publications</a></li>
                            <li><a href="#">Commercial History of Bangladesh</a></li>
                            <li><a href="#">Economic Policy of CIPE, DCCI</a></li>
                            <li><a href="#">Business Start-up Licenses</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#">Media</a>
                        <ul>
                            <li><a href="#">Latest News</a></li>
                            <li><a href="#">Events</a></li>
                            <li><a href="#">News Link</a></li>
                            <li><a href="#">Photo Gallery</a></li>
                            <li><a href="#">Video Gallery</a></li>
                            <li><a href="#">DCCI News Link</a></li>
                            <li><a href="#">DCCI News Coverage (Electronic Media)</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Downloads</a>
                        <ul>
                            <li><a href="#">Reports</a></li>
                            <li><a href="#">Other Downloads</a></li>
                            <li><a href="#">Other Presentation</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Bangladesh</a>
                        <ul>
                            <li><a href="#">General Information</a></li>
                            <li><a href="#">Business Opportunities in Bangladesh</a></li>
                            <li><a href="#">Trade Information</a></li>
                            <li><a href="#">Important Links</a></li>
                            <li><a href="#">Export Policy</a></li>
                            <li><a href="#">Import Policy</a></li>
                            <li><a href="#">Industry Policy</a></li>
                            <li><a href="#">ICT Policy</a></li>
                            <li><a href="#">SAARC</a></li>
                            <li><a href="#">Asian</a></li>
                            <li><a href="#">Middle East</a></li>
                            <li><a href="#">European Union</a></li>
                            <li><a href="#">America</a></li>
                            <li><a href="#">Africa</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
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
