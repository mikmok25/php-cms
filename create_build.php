<?php
include 'db.php';
include 'inc/session.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$name = $_POST['name'];
$description = $_POST['description'];
$cpu_id = $_POST['cpu_id'];
$gpu_id = $_POST['gpu_id'];
$ram_id = $_POST['ram_id'];
$storage_id = $_POST['storage_id'];
$motherboard_id = $_POST['motherboard_id'];

$sql = "INSERT INTO builds (name, description, cpu_id, gpu_id, ram_id, storage_id, motherboard_id, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiiiiii", $name, $description, $cpu_id, $gpu_id, $ram_id, $storage_id, $motherboard_id, $user_id);

if ($stmt->execute()) {
    header("Location: builds.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
