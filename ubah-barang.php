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

$title = 'Ubah Barang';
include 'layout/header.php'; 

// Mengambil id_barang dari url
$id_barang = (int)$_GET['id_barang'];
$barang = select("SELECT * FROM barang WHERE id_barang = $id_barang")[0];

// Proses ubah barang
if (isset($_POST['ubah'])) {
    if (update_barang($_POST) > 0) {
        echo "<script>
            alert('Data Barang Berhasil Diubah');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Barang Gagal Diubah');
            document.location.href = 'index.php';
        </script>";
    }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ubah Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Ubah Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Ubah Barang</h3>
                </div>
                
                <form action="" method="post">
                    <div class="card-body">
                        <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
                        
                        <div class="form-group">
                            <label for="nama">Nama Barang</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="nama" 
                                name="nama" 
                                value="<?= $barang['nama']; ?>"
                                placeholder="Nama Barang..." 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="jumlah" 
                                name="jumlah" 
                                value="<?= $barang['jumlah']; ?>"
                                placeholder="Jumlah..." 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="harga" 
                                name="harga" 
                                value="<?= $barang['harga']; ?>"
                                placeholder="Harga..." 
                                required
                            >
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="index.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" name="ubah" class="btn btn-primary float-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include 'layout/footer.php'; ?>