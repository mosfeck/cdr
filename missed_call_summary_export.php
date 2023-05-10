
<?php
// Initialize the session
session_start();
//include config file
require_once "config.php";

$sql = $_SESSION['summary_cdr'];
$report_type = $_SESSION['report_type'];
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// create the CSV file and write the data to it
$filename =  "Missed-call-summary_" . date('Ymd_His') . ".csv";
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");
// open the output stream
$output = fopen('php://output', 'w');

// write the column headers to the CSV file
fputcsv($output, array($report_type,  "Total Missed Call", "Total API Called"));

$TotalMissedCall = $TotalApiCall = 0;
foreach ($results as $row) {
  if ($report_type == "Daily") {
    $rType = $row['Daily'];
  } elseif ($report_type == "Monthly") {
    $rType = $row['Monthly'];
  } elseif ($report_type == "Yearly") {
    $rType = $row['Yearly'];
  }
  $TotalMissedCall += (int)$row['missedCall'];
  $TotalApiCall += (int)$row['apiCall'];
  $lineData =  array(
    $rType,
    $row['missedCall'],
    $row['apiCall'],
  );
  fputcsv($output, $lineData);
}
$total = array('Total', $TotalMissedCall, $TotalApiCall);
fputcsv($output, $total);
// close the output stream and exit
fclose($output);
exit();
// close connection
unset($pdo);
?>

