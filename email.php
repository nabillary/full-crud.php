<?php 
session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Login dulu!');
            document.location.href = 'login.php';
          </script>";
    exit;
}

$title = 'Kirim Email';
include 'layout/header.php';
?>

<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Kirim Email</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            

            <!-- Form Kirim Email -->
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fas fa-paper-plane"></i> Form Kirim Email</h3>
                        </div>
                        
                        <form action="email-proses.php" method="post">
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="email_penerima">
                                        <i class="fas fa-user"></i> Email Penerima
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email_penerima" 
                                        name="email_penerima" 
                                        placeholder="contoh@email.com" 
                                        required
                                    >
                                    <small class="form-text text-muted">
                                        Masukkan alamat email penerima dengan benar
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="subject">
                                        <i class="fas fa-heading"></i> Subject
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="subject" 
                                        name="subject" 
                                        placeholder="Masukkan subject email..." 
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="pesan">
                                        <i class="fas fa-comment-alt"></i> Pesan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea 
                                        name="pesan" 
                                        class="form-control" 
                                        id="pesan" 
                                        rows="10" 
                                        placeholder="Tulis pesan email di sini..." 
                                        required
                                    ></textarea>
                                </div>

                            

                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="index.php" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="reset" class="btn btn-warning">
                                            <i class="fas fa-undo"></i> Reset
                                        </button>
                                        <button type="submit" name="kirim" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> Kirim Email
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>