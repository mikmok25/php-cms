<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builds</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'partials/nav.php' ?>
    <h1>Welcome to PC Builder Web App!</h1>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
        <a href="build_form.php">Create New Build</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <br />
        <span>Don't have an account yet? <a href="registration.php">Register</a></span>
    <?php endif; ?>

</body>
</html>
