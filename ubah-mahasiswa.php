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

// AMBIL DATA MAHASISWA
$id_mahasiswa = (int)$_GET['id_mahasiswa'];
$mahasiswa = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
$jk = $mahasiswa['jk'];
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header text-center">
    <div class="container-fluid">
      <h1 class="m-0 mb-3">Ubah Data Mahasiswa</h1>
      <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Ubah Mahasiswa</li>
      </ol>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 85vh;">
      <div class="col-lg-10 col-xl-9">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-header bg-info text-white text-center rounded-top-4 py-3">
            <h3 class="card-title mb-0">
              <i class="fas fa-edit"></i> Form Ubah Mahasiswa
            </h3>
          </div>

          <div class="card-body p-4">
            <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa']; ?>">
              <input type="hidden" name="fotoLama" value="<?= $mahasiswa['foto']; ?>">

              <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Mahasiswa</label>
                <input 
                  type="text" 
                  class="form-control form-control-lg" 
                  id="nama" 
                  name="nama" 
                  placeholder="Nama mahasiswa..." 
                  required 
                  value="<?= $mahasiswa['nama']; ?>"
                >
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="prodi" class="form-label fw-semibold">Program Studi</label>
                  <select name="prodi" id="prodi" class="form-control form-control-lg" required>
                    <?php $prodi = $mahasiswa['prodi']; ?>
                    <option value="">-- Pilih Prodi --</option>
                    <option value="Teknik Informatika" <?= $prodi == 'Teknik Informatika' ? 'selected' : null ?>>Teknik Informatika</option>
                    <option value="Teknik Mesin" <?= $prodi == 'Teknik Mesin' ? 'selected' : null ?>>Teknik Mesin</option>
                    <option value="Teknik Listrik" <?= $prodi == 'Teknik Listrik' ? 'selected' : null ?>>Teknik Listrik</option>
                  </select>
                </div>

                <div class="mb-3 col-md-6">
                  <label for="jk" class="form-label fw-semibold">Jenis Kelamin</label>
                  <select name="jk" id="jk" class="form-control form-control-lg" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-Laki" <?= $jk == 'Laki-Laki' ? 'selected' : null ?>>Laki-Laki</option>
                    <option value="Perempuan" <?= $jk == 'Perempuan' ? 'selected' : null ?>>Perempuan</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="telepon" class="form-label fw-semibold">Telepon</label>
                  <input 
                    type="number" 
                    class="form-control form-control-lg" 
                    id="telepon" 
                    name="telepon" 
                    placeholder="Nomor Telepon..." 
                    required 
                    value="<?= $mahasiswa['telepon']; ?>"
                  >
                </div>

                <div class="mb-3 col-md-6">
                  <label for="email" class="form-label fw-semibold">Email</label>
                  <input 
                    type="email" 
                    class="form-control form-control-lg" 
                    id="email" 
                    name="email" 
                    placeholder="Alamat Email..." 
                    required 
                    value="<?= $mahasiswa['email']; ?>"
                  >
                </div>
              </div>

              <div class="mb-3">
                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                <textarea name="alamat" id="alamat"><?= $mahasiswa['alamat']; ?></textarea>
              </div>

              <div class="mb-4">
                <label for="foto" class="form-label fw-semibold">Foto</label>
                <input 
                  type="file" 
                  class="form-control form-control-lg" 
                  id="foto" 
                  name="foto" 
                  onchange="previewImg()"
                >
                <div class="mt-3 text-center">
                  <small class="d-block mb-2 text-muted">Foto Sebelumnya:</small>
                  <img 
                    src="assets/img/<?= $mahasiswa['foto']; ?>" 
                    alt="Foto Mahasiswa" 
                    class="img-thumbnail img-preview rounded-circle shadow-sm" 
                    width="130px"
                  >
                </div>
              </div>

              <div class="text-center">
                <button 
                  type="submit" 
                  name="ubah" 
                  value="Simpan" 
                  class="btn btn-info btn-lg px-5"
                >
                  <i class="fas fa-save"></i> Simpan Perubahan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Preview Gambar Script -->
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
