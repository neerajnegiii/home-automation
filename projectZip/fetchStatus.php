<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp_relay_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT device_name, status, updated_at FROM device_record ORDER BY updated_at DESC LIMIT 5";
$result = $conn->query($sql);

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}
echo json_encode($records);
$conn->close();
?>
