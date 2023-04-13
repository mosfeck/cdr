<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Record Form</title>
</head>
<body>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <p>
        <label for="firstName">First Name:</label>
        <input type="text" name="firstname" id="firstName">
    </p>
    <p>
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastname" id="lastName">
    </p>
    <p>
        <label for="emailAddress">Email Address:</label>
        <input type="text" name="email" id="emailAddress">
    </p>
    <input type="submit" value="Submit">
</form>


<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
try{
    $pdo = new PDO("mysql:host=localhost;dbname=mydb", "bappy", "bappy123");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
 
// Attempt insert query execution
try{
    // Prepare an insert statement
    $sql = "INSERT INTO myguests (firstname, lastname, email) VALUES (:first_name, :last_name, :email)";
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters to statement
    $stmt->bindParam(':first_name', $_REQUEST['firstname'], PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $_REQUEST['lastname'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $_REQUEST['email'], PDO::PARAM_STR);
    
    // Execute the prepared statement
    $stmt->execute();
    echo "Records inserted successfully.";
} catch(PDOException $e){
    die("ERROR: Could not prepare/execute query: $sql. " . $e->getMessage());
}
 
// Close statement
unset($stmt);
 
// Close connection
unset($pdo);
?>

</body>
</html>