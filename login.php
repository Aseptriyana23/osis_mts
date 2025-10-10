<?php
session_start();
include('includes/config.php'); // Menghubungkan ke database

// Cek apakah form login disubmit
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek login Admin
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);
    
    // Jika Admin
    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin/dashboard.php");
        exit();
    } else {
        // Cek login Siswa
        $query = "SELECT * FROM siswa WHERE nis = '$username' AND password = '$password'";
        $result = $conn->query($query);

        // Jika Siswa
        if ($result->num_rows == 1) {
            $_SESSION['siswa'] = $username;
            header("Location: siswa/index.php");
            exit();
        } else {
            $error = "❌ Username atau Password salah!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Voting OSIS</title>
    <link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <img src="/assets/images/mts.png" alt="Login Image">
        </div>
        <div class="login-card">
            <h2 class="text-center">Pilketos 2025-2026</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username / NIS</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="login">Login</button>
                <?php if (isset($error)) { echo "<div class='error-message'>$error</div>"; } ?>
            </form>
        </div>
    </div>
</body>
</html>


