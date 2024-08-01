<?php
include 'db.php';

$buildName = $_POST['buildName'];
$cpu = $_POST['cpu'];
$gpu = $_POST['gpu'];
$ram = $_POST['ram'];
$storage = $_POST['storage'];

$sql = "INSERT INTO builds (name, cpu_id, gpu_id, ram_id, storage_id) VALUES ('$buildName', '$cpu', '$gpu', '$ram', '$storage')";
if ($conn->query($sql) === TRUE) {
    echo "New build created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header('Location: list_builds.php');
?>
