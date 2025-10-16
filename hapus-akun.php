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
include 'config/app.php';
//menerina id barang yang dipilih penggguna
$id_akun = (int)$_GET['id_akun'];

if (delete_akun($id_akun) > 0) {
    echo "<script>
            alert('Data Akun Berhasil Dihapus');
            document.location.href = 'crud-modal.php ';
          </script>";
} else {
    echo "<script>
            alert('Data Barang Akun Dihapus');
            document.location.href = 'crud-modal.php ';
          </script>";
}


?>