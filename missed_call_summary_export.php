
<?php
// Initialize the session
session_start();
//include config file
require_once "config.php";

$sql = $_SESSION['summary_cdr'];
$report_type = $_SESSION['report_type'];
$stmt = $pdo->prepare($sql);
// print_r($stmt);exit;
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($stmt);exit;

// print_r($results);exit;
// create the CSV file and write the data to it
$filename =  "Missed-call-summary_" . date('Ymd_His') . ".csv";
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");


// echo $sql;
// open the output stream
$output = fopen('php://output', 'w');

// write the column headers to the CSV file
fputcsv($output, array($report_type,  "Total Missed Call", "Total API Called"));
// print_r($output);exit;

foreach ($results as $row) {
  if ($report_type == "Daily") {
    $rType = $row['Daily'];
} elseif ($report_type == "Monthly") {
    $rType = $row['Monthly'];
} elseif ($report_type == "Yearly") {
    $rType = $row['Yearly'];
} 
    $lineData =  array(
        $rType,
        $row['missedCall'], 
        $row['apiCall'], 
        ); 
        fputcsv($output, $lineData);
}
// print_r($output);exit;

  // close the output stream and exit
fclose($output);
exit();
// close connection
unset($pdo);
?>

