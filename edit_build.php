<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if (!isset($_GET['id'])) {
    die("No build ID specified.");
}

$build_id = $_GET['id'];

$build = $conn->query("SELECT * FROM builds WHERE id = $build_id")->fetch_assoc();

if (!$build) {
    die("Build not found.");
}

// Fetch parts
$cpus = $conn->query("SELECT id, name FROM cpu");
$gpus = $conn->query("SELECT id, name FROM gpu");
$rams = $conn->query("SELECT id, name FROM memory");
$storages = $conn->query("SELECT id, name FROM storage");
$motherboards = $conn->query("SELECT id, name FROM motherboard");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit PC Build</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Edit PC Build</h1>
    <form action="update_build.php" method="POST">
        <input type="hidden" name="id" value="<?= $build['id'] ?>">
        
        <label for="name">Build Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($build['name']) ?>" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"><?= htmlspecialchars($build['description']) ?></textarea><br>

        <label for="cpu">CPU:</label>
        <select id="cpu" name="cpu_id" required>
            <?php while ($cpu = $cpus->fetch_assoc()): ?>
                <option value="<?= $cpu['id'] ?>" <?= $cpu['id'] == $build['cpu_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cpu['name']) ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="gpu">GPU:</label>
        <select id="gpu" name="gpu_id" required>
            <?php while ($gpu = $gpus->fetch_assoc()): ?>
                <option value="<?= $gpu['id'] ?>" <?= $gpu['id'] == $build['gpu_id'] ? 'selected' : '' ?>><?= htmlspecialchars($gpu['name']) ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="ram">RAM:</label>
        <select id="ram" name="ram_id" required>
            <?php while ($ram = $rams->fetch_assoc()): ?>
                <option value="<?= $ram['id'] ?>" <?= $ram['id'] == $build['ram_id'] ? 'selected' : '' ?>><?= htmlspecialchars($ram['name']) ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="storage">Storage:</label>
        <select id="storage" name="storage_id" required>
            <?php while ($storage = $storages->fetch_assoc()): ?>
                <option value="<?= $storage['id'] ?>" <?= $storage['id'] == $build['storage_id'] ? 'selected' : '' ?>><?= htmlspecialchars($storage['name']) ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="motherboard">Motherboard:</label>
        <select id="motherboard" name="motherboard_id" required>
            <?php while ($motherboard = $motherboards->fetch_assoc()): ?>
                <option value="<?= $motherboard['id'] ?>" <?= $motherboard['id'] == $build['motherboard_id'] ? 'selected' : '' ?>><?= htmlspecialchars($motherboard['name']) ?></option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit">Update Build</button>
    </form>
</body>
</html>
