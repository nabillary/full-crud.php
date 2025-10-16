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
$title = 'Tambah Barang';
include 'layout/header.php'; 


if (isset($_POST['tambah'])) {
    if (create_barang($_POST) > 0) {
        echo "<script>
            alert('Data Barang Berhasil Ditambahkan');
            document.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
            alert('Data Barang Gagal Ditambahkan');
            document.location.href = 'index.php';
        </script>";
    }
}
?>

<div class="container mt-5">
  <h1>Tambah Data Barang</h1>
  
  <form action="" method="post">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Barang</label>
      <input 
        type="text" 
        class="form-control" 
        id="nama" 
        name="nama" 
        placeholder="Nama Barang..." 
        required
      >
    </div>

    <div class="mb-3">
      <label for="jumlah" class="form-label">Jumlah Barang</label>
      <input 
        type="number" 
        class="form-control" 
        id="jumlah" 
        name="jumlah" 
        placeholder="Jumlah Barang..." 
        required
      >
    </div>

    <div class="mb-3">
      <label for="harga" class="form-label">Harga Barang</label>
      <input 
        type="number" 
        class="form-control" 
        id="harga" 
        name="harga" 
        placeholder="Harga Barang..." 
        required
      >
    </div>

    <input 
      type="submit" 
      name="tambah" 
      value="Simpan" 
      class="btn btn-primary" 
      style="float: right;"
    >
  </form>
</div>

<?php include 'layout/footer.php'; ?>
