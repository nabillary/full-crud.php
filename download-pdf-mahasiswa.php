<?php

session_start();

// membatasi halaman login
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Harus login terlebih dahulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

// membatasi halaman sesuai user login
if ($_SESSION['level'] != 1 and $_SESSION['level'] != 3) {
    echo "<script>
        alert('Anda tidak punya hak akses');
        document.location.href = 'crud-modal.php';
    </script>";
    exit;
}

require __DIR__ . '/vendor/autoload.php';
require 'config/app.php';

use Spipu\Html2Pdf\Html2Pdf;

$data_mahasiswa = select("SELECT * FROM mahasiswa");

$content = '
<style type="text/css">
    .gambar {
        width: 50px;
    }
</style>

<page>
    <table border="1" align="center" cellspacing="0" cellpadding="5">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Jenis Kelamin</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Foto</th>
        </tr>';

$no = 1;
foreach ($data_mahasiswa as $mahasiswa) {
    $content .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $mahasiswa['nama'] . '</td>
            <td>' . $mahasiswa['prodi'] . '</td>
            <td>' . $mahasiswa['jk'] . '</td>
            <td>' . $mahasiswa['telepon'] . '</td>
            <td>' . $mahasiswa['email'] . '</td>
            <td><img src="assets/img/' . $mahasiswa['foto'] . '" class="gambar" /></td>
        </tr>';
}

$content .= '
    </table>
</page>';

ob_start();
$html2pdf = new Html2Pdf('P', 'A4', 'en');
$html2pdf->writeHTML($content);
$html2pdf->output('Laporan Data Mahasiswa.pdf');
exit;
