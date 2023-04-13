

<?php 
	require_once "config.php";

	$MemberName = $CompanyName = $Phone = $Email = $Address = $Business = $Message =  "";
	$MemberName_err = $CompanyName_err = $Phone_err = $Email_err = $Address_err = $Business_err = $Message_err = $Image_load_err = "";

    

    //$MemberName= $_POST["MemberName"];
    //$CompanyName=$_POST["CompanyName"];
    //$Phone=$_POST["Phone"];
    //$Email=$_POST["Email"];
    //$Address=$_POST["Address"];
    //$Business=$_POST["Business"];
    //$Message=$_POST["Message"];

    //if ($_POST["clear"])
    //{
    //    $MemberName="";
    //    $CompanyName="";
    //    $Phone="";
    //    $Email="";
    //    $Address="";
    //    $Business="";
    //    $Message="";
    //}
    
    

	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
        if(isset($_FILES['upImage'])) {
            $errors     = "";
            $maxsize    = 51200;
            $acceptable = array(
                'application/pdf',
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png'
            );

            //if($_FILES["upImage"]["size"] == 0) {
            //    $errors = 'No file is selected.';
            //    $Image_load_err="No file is selected.";
            //    echo '<script>alert("'.$errors.'");</script>';
            //}

            if($_FILES['upImage']['size'] >= $maxsize) {
                //$errors = 'File size must be less than 30 killobytes.';
                $Image_load_err="File size must be less than 50 killobytes.";
                //echo '<script>alert("'.$errors.'");</script>';
            }
            

            if((!in_array($_FILES['upImage']['type'], $acceptable)) && (!empty($_FILES["upImage"]["type"]))) {
                //$errors = 'Invalid file type. Only JPG type are accepted.';
                $Image_load_err="Invalid file type. Only JPG type are accepted.";
                //echo '<script>alert("'.$errors.'");</script>';
            }

            //if(count($errors) === 0) {
            //    move_uploaded_file($_FILES['upImage']['tmp_name'], '/store/to/location.file');
            //} else {
            //    foreach($errors as $error) {
            //        echo '<script>alert("'.$error.'");</script>';
            //    }

            //    die(); //Ensure no more processing is done
            //}
        }

        // Image validation
        //$imagesize=$_FILES['upImage']['size'];
        //if ($imagesize==0) 
        //{ 
        //    //die("No file selected"); 
        //    $Image_load_err="Please select an Image";
        //    exit();
        //}
        //elseif ($imagesize > 20) 
        //{ 
        //    //die("No file selected"); 
        //    $Image_load_err="Image size must be below 20 killo byte";
        //    exit();
        //}
        //$imageName=$_FILES['upImage']['tmp_name'];
        //if (exif_imagetype($imageName)==false) 
        //{ 
        //    //die("Not an image"); 
        //    $Image_load_err="Invalid Image";
        //    exit();
        //}

        //Validate image
        
        //$image = $_FILES['upImage']['tmp_name'];
        //$allowed =  array('jpeg','jpg');
        //$ext = pathinfo($image, PATHINFO_EXTENSION);
        //if(!in_array($ext, $allowed)) 
        //{
        //    $Image_load_err = "Invalid file! Please insert a jpeg file only";
        //}
        

        //// Validate data
        //function test_input($data) 
        //{
        //    $data = trim($data);
        //    $data = stripslashes($data);
        //    $data = htmlspecialchars($data);
        //    return $data;
        //}

        //$allowed =  array('gif','png' ,'jpg');
        //$filename = $_FILES['upImage']['name'];
        //$ext = pathinfo($filename, PATHINFO_EXTENSION);
        //if(!in_array($ext, $allowed) ) {
        //    $Image_load_err = "Please insert a jpeg file only";
        //}
        //elseif(empty($_POST["upImage"]) ) {
        //    $Image_load_err = "Please select an Image";
        //}

		// Validate MemberName
		$input_MemberName = trim($_POST["MemberName"]);
		if(empty($input_MemberName))
		{
			$MemberName_err = "Please enter a Member Name.";
		} 
		elseif(!filter_var($input_MemberName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
		{
			$MemberName_err = "Please enter a valid Member Name.";
		} 
		else
		{
			$MemberName = $input_MemberName;
		}

		// Validate CompanyName
		$input_CompanyName = trim($_POST["CompanyName"]);
		if(empty($input_CompanyName))
		{
			$CompanyName_err = "Please enter a Company Name.";
		} 
		else
		{
			$CompanyName = $input_CompanyName;
		}
		
		// Validate address
		$input_Phone = trim($_POST["Phone"]);
		if(empty($input_Phone))
		{
			$Phone_err = "Please enter a Phone number.";
		}
		else
		{
			$Phone = $input_Phone;
		}

		// Validate email
		$input_Email = trim($_POST["Email"]);
		if(empty($input_Email))
		{
			$Email_err = "Please enter a Email";
		}
		elseif(!filter_var($input_Email, FILTER_VALIDATE_EMAIL))
		{
			$Email_err = "Please enter a valid email.";
		}
		else
		{
			$Email = $input_Email;
		}

		// Validate address
		$input_address = trim($_POST["Address"]);
		if(empty($input_address))
		{
			$Address_err = "Please enter an address.";
		} 
		else
		{
			$Address = $input_address;
		}

		// Validate business
		$input_business = trim($_POST["Business"]);
		if(empty($input_business))
		{
			$Business_err = "Please enter an business.";
		} 
		else
		{
			$Business = $input_business;
		}

		// Validate message
		$input_message = trim($_POST["Message"]);
		if(empty($input_message))
		{
			$Message_err = "Please enter an message.";
		} 
		else
		{
			$Message = $input_message;
		}

		try{
            
            
            //$file = addslashes(file_get_contents($_FILES["upImage"]["tmp_name"]));
            ////validation image
            //$allowed =  array('gif','png' ,'jpg');
            ////$filename = $_FILES['upImage']['name'];
            //$ext = pathinfo($file, PATHINFO_EXTENSION);
            //if(!in_array($ext, $allowed) ) {
            //    $Image_load_err = "Please insert a jpeg file only";
            //}
            $imageName=$_FILES["upImage"]["tmp_name"];
            if($imageName != "")
            {
                $file = addslashes(file_get_contents($imageName));
                
            }
            else{
                //$errors = 'File is empty.';
                //echo '<script>alert("'.$errors.'");</script>';
                $Image_load_err = "Please select an Image.";
                //exit();
            }
            //elseif(empty($_POST["upImage"]) ) {
            //    $Image_load_err = "Please select an Image";
            //}
            
			// Check input errors before updating in database
			if(empty($MemberName_err) && empty($CompanyName_err) && empty($Phone_err) && empty($Email_err) && empty($Address_err) && empty($Business_err) && empty($Message_err) && empty($Image_load_err))
			{
				// Prepare an update statement
			    
				$sql = "INSERT INTO Memberdetails (MemberName, CompanyName, Phone, Email, Address, Business, Message, imageData) VALUES (:MemberName, :CompanyName, :Phone, :Email, :Address, :Business, :Message, '$file')";

				if($stmt = $pdo->prepare($sql))
				{
					// Bind variables to the prepared statement as parameters
					$stmt->bindParam(":MemberName", $param_MemberName);
					$stmt->bindParam(":CompanyName", $param_CompanyName);
					$stmt->bindParam(":Phone", $param_Phone);
					$stmt->bindParam(":Email", $param_Email);
					$stmt->bindParam(":Address", $param_Address);
					$stmt->bindParam(":Business", $param_Business);
					$stmt->bindParam(":Message", $param_Message);
                    //$stmt->bindParam(":imageData", $param_imageData);
				
			
					// Set parameters
					$param_MemberName = $MemberName;
					$param_CompanyName = $CompanyName;
					$param_Phone = $Phone;
					$param_Email = $Email;
					$param_Address = $Address;
					$param_Business = $Business;
					$param_Message = $Message;
                    //$param_imageData = '$file';
				

					// Attempt to execute the prepared statement
					if($stmt->execute())
					{
						// Records updated successfully. Redirect to landing page
                                                echo '<script>alert("Image inserted into database");</script>';
						header("location: membership_details_Copy.php");
						exit();
					}
					else
					{
						echo "Something went wrong. Please try again later.";
					}
				}
				// Close statement
				unset($stmt);
			}
		}catch(PDOException $e){
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
    <title>DCCI :: Member Entry</title>
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(90)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        
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
                                    <!--Project-->
                                    <!--<li class="dropdown nav-item">
                                        <a href="membership_logout.php" class="nav-link">Logout</a>
                                    </li>-->
                                    <?php
                                        if (isset($_SESSION['id'])) {
                                            //echo '<a class="link" href="login.php?action=logout" style="text-decoration:none">logout</a>';
                                            echo '<li class="dropdown nav-item">
                                                <a href="membership_login.php?action=logout" class="nav-link">Logout</a>
                                                    </li>';
                                        } else {
                                            //echo '<a class="link" href="login.php" style="text-decoration:none">logout</a>';
                                            echo '<li class="dropdown nav-item">
                                                    <a href="membership_logout.php" class="nav-link">logout</a>
                                                </li>';
                                        }
                                    ?>
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
                                        <h1>DCCI Member Entry</h1>
                                    </div>
                                    <ol class="breadcrumb">
                                        <li><a href="index.html">Home/ </a></li>
                                        <li class="active"> Member Entry</li>
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
                                                    <div class="col-md-offset-2 col-md-2">
                                                    </div>
							<div class="col-md-8">
								<div class="page-header clearfix">
									<!--<h2>Insert Record</h2>-->
								</div>                  
								
								<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group <?php echo (!empty($Image_load_err)) ? 'has-error' :''; ?>">
												<label>Upload Image File:</label>
												<input type="file" name="upImage" id="upImage" class="btn btn-info" onchange="readURL(this);" /><br/>
												<span class="help-block"><?php echo $Image_load_err ?></span>
											</div>
										</div>
										<div class="col-md-6">
                                                                                    <img id="blah" src="#" alt="Not an image" class="imagesize"/>
										</div>
									</div>
                                    <div class="row">
										<div class="col-md-6">
											<div class="form-group <?php echo (!empty($MemberName_err)) ? 'has-error' :''; ?>">
												<label>Member Name</label>
												<input type="text" name="MemberName" class="form-control" value="<?php echo $MemberName ?>">
												<span class="help-block"><?php echo $MemberName_err ?></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group <?php echo (!empty($CompanyName_err)) ? 'has-error' :''; ?>">
												<label>Company Name</label>
												<input type="text" name="CompanyName" class="form-control" value="<?php echo $CompanyName ?>">
												<span class="help-block"><?php echo $CompanyName_err ?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group <?php echo (!empty($Phone_err)) ? 'has-error' :''; ?>">
												<label>Phone</label>
												<input type="text" name="Phone" class="form-control" value="<?php echo $Phone ?>">
												<span class="help-block"><?php echo $Phone_err ?></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group <?php echo (!empty($Email_err)) ? 'has-error' :''; ?>">
												<label>Email</label>
												<input type="text" name="Email" class="form-control" value="<?php echo $Email ?>">
												<span class="help-block"><?php echo $Email_err ?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group <?php echo (!empty($Address_err)) ? 'has-error' :''; ?>">
												<label>Address</label>
												<input type="text" name="Address" class="form-control" value="<?php echo $Address ?>">
												<span class="help-block"><?php echo $Address_err ?></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group <?php echo (!empty($Business_err)) ? 'has-error' :''; ?>">
												<label>Business</label>
												<input type="text" name="Business" class="form-control" value="<?php echo $Business ?>">
												<span class="help-block"><?php echo $Business_err ?></span>
											</div>
										</div>
									</div>
									<div class="form-group <?php echo (!empty($Message_err)) ? 'has-error' :''; ?>">
										<label>Message</label>
										<input type="text" name="Message" class="form-control" value="<?php echo $Message ?>">
										<span class="help-block"><?php echo $Message_err ?></span>
									</div>
									
									<input type="submit" class="btn btn-primary" value="Submit" id="insert"/>
                                                                        <a href="#">
                                                                            <input type="reset" class="btn btn-info" value="Cancel" data-command="reset"/>
                                                                        </a>
                                                                        <a href="membership_details_Copy.php" class="btn">Back</a>
								</form>
							 </div>
                                                    <div class="col-md-offset-2 col-md-2">
                                                    </div>
						</div>        
					</div>
				</div>
                <!-- Member details end -->
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
    <script language="javascript">
        $('[data-command="reset"]').click(function () {
        window.location.href = window.location.href;
    });
    </script>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
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
