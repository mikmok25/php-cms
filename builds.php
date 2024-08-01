<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';
include 'inc/session.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Corrected SQL query with a missing comma added after `storage.name AS storage_name`
$builds_query = "SELECT builds.*, 
                        cpu.name AS cpu_name,
                        cpu.url AS cpu_url, 
                        gpu.url AS gpu_url, 
                        memory.url AS memory_url, 
                        storage.url AS storage_url, 
                        motherboard.url AS motherboard_url, 
                        gpu.name AS gpu_name, 
                        memory.name AS ram_name, 
                        storage.name AS storage_name, 
                        motherboard.name AS motherboard_name
                 FROM builds 
                 LEFT JOIN cpu ON builds.cpu_id = cpu.id 
                 LEFT JOIN gpu ON builds.gpu_id = gpu.id 
                 LEFT JOIN memory ON builds.ram_id = memory.id 
                 LEFT JOIN storage ON builds.storage_id = storage.id 
                 LEFT JOIN motherboard ON builds.motherboard_id = motherboard.id
                 WHERE builds.user_id = $user_id";

$builds = $conn->query($builds_query);

if (!$builds) {
    die("Error fetching builds: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builds</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function confirmDelete(buildName, buildId) {
            if (confirm(`Are you sure you want to delete "${buildName}"?`)) {
                window.location.href = `delete_build.php?id=${buildId}`;
            }
        }
    </script>
</head>

<body>
    <?php include 'partials/nav.php'?>
    <h1>PC Builds</h1>
    <a href="build_form.php">Create New Build</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>CPU</th>
            <th>GPU</th>
            <th>RAM</th>
            <th>Storage</th>
            <th>Motherboard</th>
            <th>Actions</th>
        </tr>
        <?php while ($build = $builds->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($build['name']) ?></td>
                <td><?= htmlspecialchars($build['description']) ?></td>
                <td><a href="<?= htmlspecialchars($build['cpu_url']) ?>"><?= htmlspecialchars($build['cpu_name']) ?> </a></td>
                <td><a href="<?= htmlspecialchars($build['gpu_url']) ?>"><?= htmlspecialchars($build['gpu_name']) ?> </a></td>
                <td><a href="<?= htmlspecialchars($build['memory_url']) ?>"><?= htmlspecialchars($build['ram_name']) ?></a></td>
                <td><a href="<?= htmlspecialchars($build['storage_url']) ?>"><?= htmlspecialchars($build['storage_name']) ?></a></td>
                <td><a href="<?= htmlspecialchars($build['motherboard_url']) ?>"><?= htmlspecialchars($build['motherboard_name']) ?></a></td>
                <td>
                    <button class="edit-btn"><a href="edit_build.php?id=<?= htmlspecialchars($build['id']) ?>" >Edit</a></button>
                    <button class="delete-btn">
                        <a href="javascript:void(0);"
                            onclick="confirmDelete('<?= htmlspecialchars($build['name']) ?>', <?= $build['id'] ?>)" >Delete</a>
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>