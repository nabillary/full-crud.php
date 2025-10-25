<?php
session_start();

// Cek login
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Login dulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$title = 'Detail Mahasiswa';
include 'layout/header.php';

// Mengambil id mahasiswa
$id_mahasiswa = (int)$_GET['id_mahasiswa'];

// Menampilkan data mahasiswa
$mahasiswa = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Mahasiswa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="mahasiswa.php">Data Mahasiswa</a></li>
                        <li class="breadcrumb-item active">Detail</li>
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
                    <h3 class="card-title">Data <?= htmlspecialchars($mahasiswa['nama']); ?></h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td width="30%">Nama</td>
                            <td><?= htmlspecialchars($mahasiswa['nama']); ?></td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td><?= htmlspecialchars($mahasiswa['prodi']); ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td><?= htmlspecialchars($mahasiswa['jk']); ?></td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td><?= htmlspecialchars($mahasiswa['telepon']); ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?= htmlspecialchars($mahasiswa['email']); ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><?= $mahasiswa['alamat']; ?></td>
                        </tr>
                        <tr>
                            <td>Foto</td>
                            <td>
                                <a href="assets/img/<?= $mahasiswa['foto']; ?>" target="_blank">
                                    <img src="assets/img/<?= $mahasiswa['foto']; ?>" alt="Foto" width="200">
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="mahasiswa.php" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>