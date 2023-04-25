<?php
//initialize the session
// session_start();

//check if the user is already logged in, if yes the redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
{
	header("location: login.php");
	exit;
}

//include config file
require_once "config.php";

//define variable
$id = "";
$id_err = "";
try {
//processing form data when form is submitted
if (isset($_GET["id"]) && !empty($_GET["id"])) {

    // Get URL parameter
    $id = trim($_GET["id"]);
// // Check if email is empty
    // if(empty(trim($_POST["email"]))){
    //     $email_err = "Please enter email.";
    // } else{
    //     $email = trim($_POST["email"]);
    // }
    
    // // Check if password is empty
    // if(empty(trim($_POST["password"]))){
    //     $password_err = "Please enter your password.";
    // } else{
    //     $password = trim($_POST["password"]);
    // }

    //validate credentials
    // if(empty($id_err) && empty($password_err))
    // {
    	//prepare a select statement
    	$sql="DELETE from user_manage WHERE id=:id";


    	if($stmt = $pdo->prepare($sql))
    	{
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
            
            // Set parameters
            $param_id = trim($_GET["id"]);

            // Attempt to execute the prepared statement
            if($stmt->execute())
            {
                if($stmt->rowCount() == 1)
                {
                	// if($row = $stmt->fetch())
                	// {
                		// $id = $row["id"];
                		
                        // echo $name;exit;
                        // print_r($name);exit;
                		// $hashed_password = $row["password"];
                		// if(password_verify($password, $hashed_password))
                		// {
                			//password is correct, so start a new session
                			session_start();
                            session_destroy();
                			//store data in session variables
                			// $_SESSION["loggedin"] =true;
                			// $_SESSION["id"] = $id;
                            unset($_SESSION['id']);
                			// $_SESSION["email"] = $email;
                            // echo $_SESSION["email"];exit;
                            // $_SESSION["name"] = $name;
                            // echo $_SESSION["name"];exit;
                			// echo "Deleted data successfully";

                			//redirect user to welcome page
                			header("location: login.php");
                            // exit;
                		// }
                		// else
                		// {
                		// 	//display an error message if password is not valid
                		// 	$password_err="The password you entered was not correct";
                		// }
                	// }
                }
                else
                {
                	//display an error message if id doesn't exit
                	$id_err="No account found with that id.";
                } 
            }
            else
            {
            	echo "Opps! something went wrong. Please try again later.";
            }
        }
        //close statement
        unset($stmt);
    // }
    unset($pdo);
    
}
} catch (Exception $e) {
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

?>