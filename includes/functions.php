<?php
// Cek jika Admin atau Siswa sudah login
function check_login_admin() {
    if (!isset($_SESSION['admin'])) {
        header('Location: login.php');
        exit();
    }
}

function check_login_siswa() {
    if (!isset($_SESSION['siswa'])) {
        header('Location: login.php');
        exit();
    }
}
?>
