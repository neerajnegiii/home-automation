<?php
$servername = getenv("DB_HOST");
$username   = getenv("DB_USER");
$password   = getenv("DB_PASS");
$dbname     = getenv("DB_NAME");


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$sql = "SELECT device_name, status FROM device_status";
$result = $conn->query($sql);

$status = [];
while ($row = $result->fetch_assoc()) {
    $status[$row['device_name']] = $row['status'];
}
echo json_encode($status);
$conn->close();
?>
