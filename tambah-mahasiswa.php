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
$title = 'Tambah Mahasiswa';
include 'layout/header.php'; 


if (isset($_POST['tambah'])) {
    if (create_mahasiswa($_POST) > 0) {
        echo "<script>
            alert('Data Mahasiswa Berhasil Ditambahkan');
            document.location.href = 'mahasiswa.php';
            </script>";
    } else {
        echo "<script>
            alert('Data Mahasiswa Gagal Ditambahkan');
            document.location.href = 'mahasiswa.php';
        </script>";
    }
}
?>

<div class="container mt-5">
  <h1>Tambah Mahasiswa</h1>
  
  <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Mahasiswa</label>
      <input 
        type="text" 
        class="form-control" 
        id="nama" 
        name="nama" 
        placeholder="Nama Mahasiswa..." 
        required
      >
    </div>

    <div class="row">
        <div class="mb-3 col-6">
            <label for="prodi" class="form-label">Program Studi</label>
            <select name="prodi" id="prodi" class="form-control" required>
                <option value="">-- pilih prodi --</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Teknik Mesin">Teknik Mesin</option>
                <option value="Teknik Listrik">Teknik Listrik</option>
            </select>
    </div>
    <div class="mb-3 col-6">
        <label for="jk" class="form-label">Jenis Kelamin</label>
        <select name="jk" id="jk" class="form-control" required>
            <option value="">-- pilih jenis kelamin --</option>
            <option value="laki-laki">laki-laki</option>
            <option value="perempuan">perempuan</option>
        </select>
    </div>
</div>
    <div class="mb-3">
     <label for="telepon" class="form-label">Telepon</label>
     <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Telepon....." required>
    </div>

    <div class="mb-3">
  <label for="alamat" class="form-label">Alamat</label>
  <textarea name="alamat" id="alamat"></textarea>
</div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email....." required>
    </div>

    <div class="mb-3">
    <label for="foto" class="form-label">Foto</label>
    <input 
        type="file" 
        class="form-control" 
        id="foto" 
        name="foto"
        placeholder="Foto....." onchange="previewImg()">
      <img 
        src="assets/img/<?= $mahasiswa['foto']; ?>" 
        alt="Foto Mahasiswa" 
        class="img-thumbnail img-preview" 
        width="100px">

    </div>

    <button
      type="submit" 
      name="tambah" 
      value="Simpan" 
      class="btn btn-primary" 
      style="float: right;"
    ><i class="fas fa-plus"></i>
    Tambah</button>
  </form>
</div>

<!-- preview image -->
<script>
  function previewImg() {
    const foto = document.querySelector('#foto');
    const imgPreview = document.querySelector('.img-preview');

    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(foto.files[0]);

    fileFoto.onload = function(e) {
      imgPreview.src = e.target.result;
    }
  }
</script>

<!-- CKEditor + CKFinder -->
<script src="assets/ckfinder/ckfinder.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
  CKEDITOR.replace('alamat', {
    filebrowserBrowseUrl: 'assets/ckfinder/ckfinder.html',
    filebrowserUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageBrowseUrl: 'assets/ckfinder/ckfinder.html?type=Images',
    filebrowserImageUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
  });
</script>

<?php include 'layout/footer.php'; ?>



<?php include 'layout/footer.php'; ?>
