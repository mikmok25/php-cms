<?php 
include_once 'inc/session.php'; 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<header>
    <nav>
        <h2>PC BUILDER</h2>
        <ul>
            <li><a href="cpu.php">CPUs</a></li>
            <li><a href="gpu.php">GPUs</a></li>
            <li><a href="ram.php">RAMs</a></li>
            <li><a href="storage.php">Storage</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="build_form.php">Create Build</a></li>
                <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="registration.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
