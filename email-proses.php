<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['kirim'])) {
    $email_penerima = filter_var($_POST['email_penerima'], FILTER_VALIDATE_EMAIL);
    $subject = trim($_POST['subject']);
    $pesan = trim($_POST['pesan']);

    if (!$email_penerima || empty($subject) || empty($pesan)) {
        echo "<script>
            alert('Semua field wajib diisi dengan benar!');
            document.location.href = 'email.php';
        </script>";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Setting server Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nabillaryti@gmail.com'; // Ganti dengan email Gmail kamu
        $mail->Password   = 'fzbsvdzzkrsmjodf'; // Ganti dengan App Password (bukan password login)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Opsional (menghindari error SSL di localhost)
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Pengirim dan penerima
        $mail->setFrom('nabillaryti@gmail.com', 'Nabilla Dewi Ariati');
        $mail->addAddress($email_penerima);
        $mail->addReplyTo('nabillaryti@gmail.com', 'Nabilla Dewi Ariati');

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br(htmlspecialchars($pesan));
        $mail->AltBody = strip_tags($pesan);

        // Kirim email
        if ($mail->send()) {
            echo "<script>
                alert('✅ Email berhasil dikirim ke $email_penerima');
                document.location.href = 'email.php';
            </script>";
        } else {
            echo "<script>
                alert('❌ Email gagal dikirim.');
                document.location.href = 'email.php';
            </script>";
        }

    } catch (Exception $e) {
        echo "<script>
            alert('Terjadi kesalahan: " . addslashes($mail->ErrorInfo) . "');
            document.location.href = 'email.php';
        </script>";
    }

} else {
    echo "<script>
        alert('Akses tidak valid!');
        document.location.href = 'email.php';
    </script>";
}
?>