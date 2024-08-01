<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $cpu_id = $_POST['cpu_id'];
    $gpu_id = $_POST['gpu_id'];
    $ram_id = $_POST['ram_id'];
    $storage_id = $_POST['storage_id'];
    $motherboard_id = $_POST['motherboard_id'];

    $sql = "UPDATE builds 
            SET name = ?, description = ?, cpu_id = ?, gpu_id = ?, ram_id = ?, storage_id = ?, motherboard_id = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssiiiiii", $name, $description, $cpu_id, $gpu_id, $ram_id, $storage_id, $motherboard_id, $id);

    if ($stmt->execute()) {
        header("Location: builds.php");
        exit;
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
