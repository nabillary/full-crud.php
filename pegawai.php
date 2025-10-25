<?php 
session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Login dulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

if ($_SESSION["level"] != 1) {
    echo "<script>
        alert('Perhatikan anda tidak punya hak akses');
        document.location.href = 'crud-modal.php';
    </script>";
    exit;
}

$title = 'Daftar Pegawai';
include 'layout/header.php';

// ===================== DATA STATISTIK PEGAWAI =====================
$data_pegawai = select("SELECT * FROM pegawai ORDER BY id_pegawai DESC");
$total_pegawai = count($data_pegawai);

// Hitung jumlah pegawai per jabatan
$jabatan_count = [];
foreach ($data_pegawai as $pegawai) {
    $jabatan = $pegawai['jabatan'];
    if (isset($jabatan_count[$jabatan])) {
        $jabatan_count[$jabatan]++;
    } else {
        $jabatan_count[$jabatan] = 1;
    }
}

// Konversi untuk grafik
$data_grafik_jabatan = [];
foreach ($jabatan_count as $jabatan => $jumlah) {
    $data_grafik_jabatan[] = [
        'jabatan' => $jabatan,
        'jumlah' => $jumlah
    ];
}

// Ambil 5 jabatan terbanyak
usort($data_grafik_jabatan, function($a, $b) {
    return $b['jumlah'] - $a['jumlah'];
});
$top_jabatan = array_slice($data_grafik_jabatan, 0, 5);
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users"></i> Data Pegawai</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Data Pegawai</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $total_pegawai; ?></h3>
                            <p>Total Pegawai</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= count($jabatan_count); ?></h3>
                            <p>Jumlah Jabatan</p>
                        </div>
                        <div class="icon"><i class="fas fa-briefcase"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><i class="fas fa-sync"></i></h3>
                            <p>Data Realtime</p>
                        </div>
                        <div class="icon"><i class="fas fa-clock"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><i class="fas fa-database"></i></h3>
                            <p>Live Update</p>
                        </div>
                        <div class="icon"><i class="fas fa-server"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Grafik Section -->
            <div class="row">
                <!-- Grafik Bar - Top 5 Jabatan -->
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Top 5 Jabatan Terbanyak</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartJabatan" style="height:250px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik Pie - Distribusi Jabatan -->
                <div class="col-lg-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie"></i> Distribusi Jabatan</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPie" style="height:250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data Pegawai -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title"><i class="fas fa-list"></i> Tabel Data Pegawai (Realtime)</h3>
                            <div class="card-tools">
                                <span class="badge badge-light">
                                    <i class="fas fa-circle text-success" id="status-icon"></i> 
                                    Live Update
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody id="live_data">
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <i class="fas fa-spinner fa-spin"></i> Memuat data...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Data diperbarui secara otomatis setiap 200ms
                            </small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Data dari PHP ke JavaScript
const dataJabatan = <?= json_encode($top_jabatan); ?>;

// Grafik Bar - Top 5 Jabatan
const ctxBar = document.getElementById('chartJabatan').getContext('2d');
const chartBar = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: dataJabatan.map(item => item.jabatan),
        datasets: [{
            label: 'Jumlah Pegawai',
            data: dataJabatan.map(item => item.jumlah),
            backgroundColor: [
                'rgba(54, 162, 235, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Grafik Pie - Distribusi Jabatan
const ctxPie = document.getElementById('chartPie').getContext('2d');
const chartPie = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: dataJabatan.map(item => item.jabatan),
        datasets: [{
            data: dataJabatan.map(item => item.jumlah),
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<!-- Realtime Update Script -->
<script>
let updateCount = 0;

$('document').ready(function() {
    // Load data pertama kali
    getPegawai();
    
    // Update setiap 200ms
    setInterval(function() {
        getPegawai();
        animateStatusIcon();
    }, 200);
});

function getPegawai() {
    $.ajax({
        url: "realtime-pegawai.php",
        type: "GET",
        success: function(response) {
            $("#live_data").html(response);
            updateCount++;
        },
        error: function() {
            $("#live_data").html('<tr><td colspan="6" class="text-center text-danger"><i class="fas fa-exclamation-triangle"></i> Gagal memuat data</td></tr>');
        }
    });
}

function animateStatusIcon() {
    const icon = document.getElementById('status-icon');
    icon.style.opacity = '0.3';
    setTimeout(() => {
        icon.style.opacity = '1';
    }, 100);
}
</script>

<?php include 'layout/footer.php'; ?>