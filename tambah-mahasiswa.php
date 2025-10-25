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

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header text-center">
    <div class="container-fluid">
      <h1 class="m-0 mb-3">Tambah Mahasiswa</h1>
      <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Tambah Mahasiswa</li>
      </ol>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 85vh;">
      <div class="col-lg-10 col-xl-9">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
            <h3 class="card-title mb-0">
              <i class="fas fa-user-plus"></i> Form Tambah Mahasiswa
            </h3>
          </div>

          <div class="card-body p-4">
            <form action="" method="post" enctype="multipart/form-data">

              <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Mahasiswa</label>
                <input 
                  type="text" 
                  class="form-control form-control-lg" 
                  id="nama" 
                  name="nama" 
                  placeholder="Nama Mahasiswa..." 
                  required
                >
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="prodi" class="form-label fw-semibold">Program Studi</label>
                  <select name="prodi" id="prodi" class="form-control form-control-lg" required>
                    <option value="">-- Pilih Prodi --</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Teknik Mesin">Teknik Mesin</option>
                    <option value="Teknik Listrik">Teknik Listrik</option>
                  </select>
                </div>

                <div class="mb-3 col-md-6">
                  <label for="jk" class="form-label fw-semibold">Jenis Kelamin</label>
                  <select name="jk" id="jk" class="form-control form-control-lg" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
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
                  >
                </div>
              </div>

              <div class="mb-3">
                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                <textarea name="alamat" id="alamat" rows="5" class="form-control"></textarea>
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
                  <img 
                    src="assets/img/default.png" 
                    alt="Foto Mahasiswa" 
                    class="img-thumbnail img-preview rounded-circle shadow-sm" 
                    width="130px"
                  >
                </div>
              </div>

              <div class="text-center">
                <button 
                  type="submit" 
                  name="tambah" 
                  value="Simpan" 
                  class="btn btn-primary btn-lg px-5"
                >
                  <i class="fas fa-plus"></i> Tambah Mahasiswa
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- /.content-wrapper -->

<!-- Preview Image Script -->
<script>
  function previewImg() {
    const foto = document.querySelector('#foto');
    const imgPreview = document.querySelector('.img-preview');
    
    if (foto.files && foto.files[0]) {
      const fileFoto = new FileReader();
      
      fileFoto.onload = function(e) {
        imgPreview.src = e.target.result;
      }
      
      fileFoto.readAsDataURL(foto.files[0]);
    }
  }
</script>

<!-- CKEditor Script - HARUS LOAD SETELAH TEXTAREA ADA -->
<script src="assets/ckfinder/ckfinder.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
  // Tunggu sampai DOM ready
  document.addEventListener('DOMContentLoaded', function() {
    CKEDITOR.replace('alamat', {
      height: 300,
      // Path untuk CKFinder - SESUAIKAN dengan baseUrl di config.php
      filebrowserBrowseUrl: 'assets/ckfinder/ckfinder.html',
      filebrowserImageBrowseUrl: 'assets/ckfinder/ckfinder.html?type=Images',
      filebrowserUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
      
      // Toolbar sederhana
      toolbar: [
        { name: 'clipboard', items: ['Undo', 'Redo'] },
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
        { name: 'insert', items: ['Image', 'Table'] },
        { name: 'styles', items: ['Format'] },
        { name: 'colors', items: ['TextColor', 'BGColor'] }
      ]
    });
  });
</script>

<?php include 'layout/footer.php'; ?>