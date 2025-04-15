<?php
$servername = getenv("DB_HOST");
$username  = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (isset($_GET['relay']) && isset($_GET['state'])) {
    $relay = $_GET['relay'];
    $state = $_GET['state'];
    $device_name = "relay$relay";

    $stmt = $conn->prepare("INSERT INTO device_status (device_name, status) 
        VALUES (?, ?) 
        ON DUPLICATE KEY UPDATE status = VALUES(status), updated_at = CURRENT_TIMESTAMP");
    $stmt->bind_param("ss", $device_name, $state);
    $stmt->execute();

    $conn->query("INSERT INTO device_record (device_name, status) VALUES ('$device_name', '$state')");

    echo json_encode(["status" => "success", "relay" => $relay, "state" => $state]);
}
$conn->close();
?>
