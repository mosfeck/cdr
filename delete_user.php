<?php
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

        //prepare a select statement
        $sql = "DELETE from user_manage WHERE id=:id";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);

            // Set parameters
            $param_id = trim($_GET["id"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    
                    //redirect user to user page
                    header("location: user.php");
                } else {
                    //display an error message if id doesn't exit
                    echo "No account found with that id.";
                }
            } else {
                echo "Opps! something went wrong. Please try again later.";
            }
        }
        //close statement
        unset($stmt);
    }
    //close connection
    unset($pdo);
} catch (Exception $e) {
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
