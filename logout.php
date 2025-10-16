<?php 

session_start();

// Membatasi hak akses: kalau belum login, arahkan ke login.php
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Login dulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

//kosongkan $SESSION user login
$_SESSION = [];

session_unset();
session_destroy();
header("Location: login.php");