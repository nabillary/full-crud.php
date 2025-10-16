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

// Membatasi hak akses
if ($_SESSION["level"] != 1 and $_SESSION["level"] != 3) {
    echo "<script>
        alert('Anda tidak punya hak akses');
        document.location.href = 'crud-modal.php';
    </script>";
    exit;
}
$title= 'Datfar Mahasiswa';
include 'layout/header.php';


//menampilkan data mahasiswa
$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC")
?>

<div class="contaier mt-5">
    <h1>Data Mahasiswa</h1>
    <a href="tambah-mahasiswa.php" class="btn btn-primary mb-1">Tambah</a>
    <a href="download-excel-mahasiswa.php" class="btn btn-success mb-1"><i class="fas fa-file-excel"></i>Download Excel</a>
    <a href="download-pdf-mahasiswa.php" class="btn btn-danger mb-1"><i class="fas fa-file-pdf"></i>Download PDF</a>
      <table  class="table table-bordered table-striped" id="example">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Prodi</th>
          <th>Jenis Kelamin</th>
          <th>No.Telp</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php foreach ($data_mahasiswa as $mahasiswa) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $mahasiswa['nama']; ?></td>
                <td><?= $mahasiswa['prodi']; ?></td>
                <td><?= $mahasiswa['jk']; ?></td>
                <td><?= $mahasiswa['telepon']; ?></td>
                <td class="text-center" width="15%">
                    <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-secondary btn-sm">Detail</a>
                    <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa ['id_mahasiswa']; ?>" class="btn btn-success btn-sm">Ubah</a>
                    <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa ['id_mahasiswa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Data Mahasiswa Akan Dihapus.');">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>

      </tbody>
      </table>
    </div>

<?php include 'layout/footer.php'; ?>