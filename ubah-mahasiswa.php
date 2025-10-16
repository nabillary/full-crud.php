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
$title = 'Ubah Mahasiswa';
include 'layout/header.php'; 


if (isset($_POST['ubah'])) {
    if (update_mahasiswa($_POST) > 0) {
        echo "<script>
            alert('Data Mahasiswa Berhasil Diubah');
            document.location.href = 'mahasiswa.php';
            </script>";
    } else {
        echo "<script>
            alert('Data Mahasiswa Gagal Diubah');
            document.location.href = 'mahasiswa.php';
        </script>";
    }
}

//AMBIL ID MAHASISWA
$id_mahasiswa = (int)$_GET['id_mahasiswa'];
$mahasiswa= select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
$jk = $mahasiswa['jk']; //TAMBAHAN
?>

<div class="container mt-5">
  <h1>Ubah Mahasiswa</h1>
  
 <form action="" method="post" enctype="multipart/form-data">
     <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa']; ?>">
    <input type="hidden" name="fotoLama" value="<?= $mahasiswa['foto']; ?>">

    <div class="mb-3">
        <label for="nama" class="form-label">Nama Mahasiswa</label>
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama mahasiswa..." required value="<?= $mahasiswa['nama']; ?>">
    </div>

    <div class="row">
        <div class="mb-3 col-6">
            <label for="prodi" class="form-label">Program Studi</label>
            <select name="prodi" id="prodi" class="form-control" required>
                <?php $prodi = $mahasiswa['prodi']?>
                <option value="">-- pilih prodi --</option>
                <option value="Teknik Informatika"<?= $prodi == 'Teknik Informatika' ? 'selected' : null?>>Teknik Informatika</option>
                <option value="Teknik Mesin" <?= $prodi == 'Teknik Mesin' ? 'selected' : null?>>Teknik Mesin</option>
                <option value="Teknik Listrik" <?= $prodi == 'Teknik Listrik' ? 'selected' : null?>>Teknik Listrik</option>
            </select>
    </div>
    <div class="mb-3 col-6">
        <label for="jk" class="form-label">Jenis Kelamin</label>
        <select name="jk" id="jk" class="form-control" required>
            <option value="">-- pilih jenis kelamin --</option>
            <option value="Laki-Laki" <?= $jk == 'Laki-Laki' ? 'selected' : null?>>Laki-Laki</option>
            <option value="Perempuan" <?= $jk == 'Perempuan' ? 'selected' : null?>>Perempuan</option>
        </select>
    </div>
</div>
    <div class="mb-3">
     <label for="telepon" class="form-label">Telepon</label>
     <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Telepon....." required value="<?= $mahasiswa['telepon']; ?>">
    </div>
    <div class="mb-3">
     <label for="alamat" class="form-label">Alamat</label>
     <textarea name="alamat" id="alamat"><?= $mahasiswa['alamat']; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email....." required value="<?= $mahasiswa['email'];?>">
    </div>

    <div class="mb-3">
    <label for="foto" class="form-label">Foto</label>
    <input 
        type="file" 
        class="form-control" 
        id="foto" 
        name="foto" 
        placeholder="Foto...">
        <p>
            <small>Gambar Sebelumnya</small>
        </p>
        <img src="assets/img/<?= $mahasiswa['foto']; ?>" alt="foto" width="100px">
    </div>




    <button
      type="submit" 
      name="ubah" 
      value="Simpan" 
      class="btn btn-primary" 
      style="float: right;"
    ><i class="fas fa-plus"></i>
    Ubah</button>
  </form>
</div>

<?php include 'layout/footer.php'; ?>
