<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userid = $_SESSION['user_id'];
$table_name = "inventry{$userid}.sales";

$interval = $_GET['interval'] ?? '1 DAY';

$query = "SELECT sale_date, SUM(quantity) AS total_sales, SUM(total_profit) AS total_profit 
          FROM $table_name 
          WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL $interval) 
          GROUP BY sale_date 
          ORDER BY sale_date ASC";

$result = $conn->query($query);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
