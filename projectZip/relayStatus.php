<?php
$servername ="sql.freedb.tech";
$username = "freedb_neeraj";
$password = "uNx3qPqs7#Ezy3!";
$dbname = "freedb_MyWebsite";

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
