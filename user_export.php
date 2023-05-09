
<?php
// Initialize the session
session_start();
//include config file
require_once "config.php";

$sql = $_SESSION['user'];
$stmt = $pdo->prepare($sql);
// print_r($stmt);exit;
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($stmt);exit;

// print_r($results);exit;
// create the CSV file and write the data to it
$filename =  "User-manage_" . date('Ymd_His') . ".csv";
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");


// echo $sql;
// open the output stream
$output = fopen('php://output', 'w');

// write the column headers to the CSV file
fputcsv($output, array("Sl","Name", "Phone", "Email", "Designation", "Department","Status"));
// print_r($output);exit;

$sl = 1;
foreach ($results as $row) {
    $lineData =  array(
            $sl,
            $row['name'], 
            $row['phone'], 
            $row['email'], 
            $row['designation'], 
            $row['department'], 
            $row['status'], 
        ); 
        $sl++;
        fputcsv($output, $lineData);
}
// print_r($output);exit;

  // close the output stream and exit
fclose($output);
exit();
// close connection
unset($pdo);
?>

