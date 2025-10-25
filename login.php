<?php
session_start();
include 'config/app.php';

// Inisialisasi error
$error = false;
$errorRecaptcha = false;

// Check apakah tombol login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Secret key reCAPTCHA (ganti dengan punyamu sendiri)
    $secret_key = '6LdJbfErAAAAALhATPoWmeaoConlugjyFXb8djIS';

    // Verifikasi reCAPTCHA
    $verifikasi = file_get_contents(
        'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']
    );
    $response = json_decode($verifikasi);

    // Jika reCAPTCHA valid
    if ($response->success) {

        // Cek username
        $result = mysqli_query($db, "SELECT * FROM akun WHERE username = '$username'");

        // Jika user ditemukan
        if (mysqli_num_rows($result) == 1) {
            $hasil = mysqli_fetch_assoc($result);

            // Verifikasi password
            if (password_verify($password, $hasil['password'])) {
                // Set session
                $_SESSION['login'] = true;
                $_SESSION['id_akun'] = $hasil['id_akun'];
                $_SESSION['nama'] = $hasil['nama'];
                $_SESSION['username'] = $hasil['username'];
                $_SESSION['email'] = $hasil['email'];
                $_SESSION['level'] = $hasil['level'];

                // Arahkan ke halaman index
                header("Location: index.php");
                exit;
            } else {
                // Username/password salah
                $error = true;
            }
        } else {
            // Username tidak ditemukan
            $error = true;
        }
    } else {
        // Jika reCAPTCHA tidak valid
        $errorRecaptcha = true;
    }
}
?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Halaman Login Admin">
    <meta name="author" content="Muba Teknologi">
    <title>Login Admin · Muba Teknologi</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom styles -->
    <link href="assets/img/css/signin.css" rel="stylesheet">

    <style>
      body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #f5f5f5;
      }
      .form-signin {
        width: 100%;
        max-width: 380px;
        padding: 15px;
      }
    </style>
  </head>

  <body class="text-center">

    <main class="form-signin">
      <form action="" method="POST">
        <img class="mb-4" src="assets/img/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Admin Login</h1>

        <!-- Alert Username / Password salah -->
        <?php if ($error): ?>
          <div class="alert alert-danger text-center">
            <b>Username / Password SALAH</b>
          </div>
        <?php endif; ?>

        <!-- Alert Recaptcha Tidak Valid -->
        <?php if ($errorRecaptcha): ?>
          <div class="alert alert-danger text-center">
            <b>reCAPTCHA Tidak Valid</b>
          </div>
        <?php endif; ?>

        <div class="form-floating mb-3">
          <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username..." required>
          <label for="floatingInput">Username</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password..." required>
          <label for="floatingPassword">Password</label>
        </div>

        <!-- reCAPTCHA -->
        <div class="form-group mb-3 text-center">
          <div class="g-recaptcha" data-sitekey="6LdJbfErAAAAALBMgixYpS6ShPcJW4fKYjv7UrIG"></div>
        </div>

        <button type="submit" name="login" class="w-100 btn btn-lg btn-primary">Masuk</button>

        <hr class="my-4">

        <div class="text-center mt-3">
          <span class="text-muted">
            Developer &copy; <a href="https://mubatekno.com" class="text-decoration-none">Muba Teknologi</a> <?= date('Y') ?>
          </span>
        </div>
      </form>
    </main>

    <!-- Script -->
    <script src="assets-template/plugins/jquery/jquery.min.js"></script>
    <script src="assets-template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets-template/dist/js/adminlte.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </body>
</html>
