<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>DCCI :: Member Details</title>
        <!-- Web Fonts -->
<!--        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>-->
        <!-- font-awesome CSS -->
        <!--<link href="css/font-awesome.min.css" rel="stylesheet">-->
        <!--<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">-->
<!--        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <!-- Flaticon CSS -->
<!--        <link href="fonts/flaticon/flaticon.css" rel="stylesheet">-->

        <!-- Offcanvas CSS -->
<!--        <link href="css/hippo-off-canvas.css" rel="stylesheet">-->
        <!-- animate CSS -->
<!--        <link href="css/animate.css" rel="stylesheet">-->
        <!-- language CSS -->
        <!--<link href="css/language-select.css" rel="stylesheet">-->
        <!-- owl.carousel CSS -->
<!--        <link href="css/owl.carousel.css" rel="stylesheet">-->
        <!-- magnific-popup -->
        <!--<link href="css/magnific-popup.css" rel="stylesheet">-->
        <!-- Main menu -->
<!--        <link href="css/menu.css" rel="stylesheet">-->
        <!-- Template Common Styles -->
<!--        <link href="css/members.css" rel="stylesheet" />
        <link href="css/template.css" rel="stylesheet">-->
        <!-- Custom CSS -->
<!--        <link href="css/style.css" rel="stylesheet">-->

        <!-- Responsive CSS -->
<!--        <link href="css/responsive.css" rel="stylesheet">-->
        <!--<script src="js/vendor/modernizr-2.8.1.min.js"></script>-->
        <!-- HTML5 Shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="js/vendor/html5shim.js"></script>
            <script src="js/vendor/respond.min.js"></script>
        <![endif]-->
        <link rel="icon" type="image/png" href="img/DCCI_image.png" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
//            $(document).ready(function () {
//            $("#offcanvasMenu li a").click(function (event) {
//            $('#offcanvasMenu li').removeClass('open');
//                    $(this).addClass('open');
//            });
            
//            $(document).ready(function(){
//                $("#myInput").on("keyup", function(){
//                  var value = $(this).val().toLowerCase();
//                  $("#myTable tr").filter(function(){
//                    $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)
//                  });
//                });
//              });
	      $(document).ready(function(){
		  $("#search_text").keyup(function(){
		      var txt=$("#search_text").val();
//                      alert(txt);
		      if(txt!=="")
		      {
			  $.ajax({
			      url:"fetch.php",
			      type: "post",
//			      data:{search:txt},
                              data:"txt="+txt,
			      success:function(data)
			      {
				  $("#result").html(data);
//                                  $("#search_text").val("");
			      }
			  });
		      }
		      else
		      {
			  $("#result").html("");
                          
		      }
		  });
	      });
//            $(document).ready(function(){
//                $('[data-toggle="tooltip"]').tooltip();
//            });
                    //Search data
                    //$('.search-box input[type="text"]').on("keyup input", function(){
                    /* Get input value on change */
                    /*var inputVal = $(this).val();
                     var resultDropdown = $(this).siblings(".resultbtn");
                     if(inputVal.length){
                     $.get("backend-search.php", {term: inputVal}).done(function(data){*/
                    // Display the returned data in browser
                    /* resultDropdown.html(data);
                     });
                     } else{
                     resultDropdown.empty();
                     }
                     });*/

                    // Set search input value on click of result item
                    /*$(document).on("click", ".resultbtn", function(){
                     $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                     $(this).parent(".resultbtn").empty();
                     });
                     });*/
        </script>
    </head>
    <body>
        
        <div class="container">
	    <br/>
	    <h2 align="center">Ajax live data search</h2>
	    <br/>
            
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" id="search_text" placeholder="search" class="form-control"/>
                    </div>
                </div>
                <br/>
                <ul id="result"></ul>
            
	</div>
        <!-- jQuery -->
<!--        <script src="js/jquery.js"></script>-->
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- owl.carousel -->
<!--        <script src="js/owl.carousel.min.js"></script>-->
        <!-- Tooltip-popup -->
<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>-->
        <!-- Magnific-popup -->
<!--        <script src="js/jquery.magnific-popup.min.js"></script>-->
        <!-- Offcanvas Menu -->
<!--        <script src="js/hippo-offcanvas.js"></script>-->
        <!-- inview -->
        <!--<script src="js/jquery.inview.min.js"></script>-->
        <!-- stellar -->
<!--        <script src="js/jquery.stellar.js"></script>-->
        <!-- countTo -->
<!--        <script src="js/jquery.countTo.js"></script>-->
        <!-- classie -->
        <!--<script src="js/classie.js"></script>-->
        <!-- selectFx -->
        <!--<script src="js/selectFx.js"></script>-->
        <!-- sticky kit -->
        <!--<script src="js/jquery.sticky-kit.min.js"></script>-->
        <!-- GOGLE MAP -->
<!--        <script src="https://maps.googleapis.com/maps/api/js"></script>-->
        <!--TWITTER FETCHER-->
        <!--<script src="js/twitterFetcher_min.js"></script>-->
        <!-- Custom Script -->
        <script src="js/scripts.js"></script>
    </body>
</html>
