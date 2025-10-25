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

require 'config/app.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Bersihkan output buffer untuk memastikan tidak ada output sebelumnya
ob_clean();

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

// Set judul kolom
$activeWorksheet->setCellValue('A2', 'No');
$activeWorksheet->setCellValue('B2', 'Nama');
$activeWorksheet->setCellValue('C2', 'Program Studi');
$activeWorksheet->setCellValue('D2', 'Jenis Kelamin');
$activeWorksheet->setCellValue('E2', 'Telepon');
$activeWorksheet->setCellValue('F2', 'Email');
$activeWorksheet->setCellValue('G2', 'Foto');

$data_mahasiswa = select("SELECT * FROM mahasiswa");

$sno = 1;
$start = 3;

foreach ($data_mahasiswa as $mahasiswa) {
    $activeWorksheet->setCellValue('A' . $start, $sno++);
    $activeWorksheet->setCellValue('B' . $start, $mahasiswa['nama']);
    $activeWorksheet->setCellValue('C' . $start, $mahasiswa['prodi']);
    $activeWorksheet->setCellValue('D' . $start, $mahasiswa['jk']);
    $activeWorksheet->setCellValue('E' . $start, $mahasiswa['telepon']);
    $activeWorksheet->setCellValue('F' . $start, $mahasiswa['email']);
    $activeWorksheet->setCellValue('G' . $start, 'http://localhost/crud_php/assets/img/' . $mahasiswa['foto']);
    
    $start++;
}

// Set auto size untuk semua kolom
foreach(range('A','G') as $col) {
    $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
}

// Border excel
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$border = $start - 1;
$activeWorksheet->getStyle('A2:G' . $border)->applyFromArray($styleArray);

// PENTING: Set header SEBELUM menulis file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan Data Mahasiswa.xlsx"');
header('Cache-Control: max-age=0');

// Tulis langsung ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;