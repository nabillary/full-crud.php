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

// Membatasi hak akses level
if ($_SESSION["level"] != 1 && $_SESSION["level"] != 2) {
    echo "<script>
        alert('Anda tidak punya hak akses');
        document.location.href = 'crud-modal.php';
    </script>";
    exit;
}

$title = 'Dashboard';
include 'layout/header.php'; 

// ===================== DATA STATISTIK =====================
$total_barang = count(select("SELECT * FROM barang"));
$total_akun = count(select("SELECT * FROM akun"));
$total_mahasiswa = count(select("SELECT * FROM mahasiswa"));

// Total nilai barang (harga x jumlah)
$data_nilai = select("SELECT SUM(harga * jumlah) as total FROM barang")[0];
$total_nilai = $data_nilai['total'] ?? 0;

// Barang terbaru hari ini
$today = date('Y-m-d');
$barang_baru = count(select("SELECT * FROM barang WHERE DATE(tanggal) = '$today'"));

// ===================== DATA GRAFIK =====================
// Data untuk grafik barang (5 barang terbanyak)
$data_grafik_barang = select("SELECT nama, jumlah FROM barang ORDER BY jumlah DESC LIMIT 5");

// Data untuk grafik transaksi per bulan (6 bulan terakhir)
$data_grafik_bulanan = [];
for ($i = 5; $i >= 0; $i--) {
    $bulan = date('Y-m', strtotime("-$i month"));
    $count = count(select("SELECT * FROM barang WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan'"));
    $data_grafik_bulanan[] = [
        'bulan' => date('M Y', strtotime("-$i month")),
        'jumlah' => $count
    ];
}

// Filter data
if (isset($_POST['filter'])) {
    $tgl_awal  = strip_tags($_POST['tgl_awal']) . " 00:00:00";
    $tgl_akhir = strip_tags($_POST['tgl_akhir']) . " 23:59:59";
    $data_barang = select("SELECT * FROM barang WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id_barang DESC");
    $jumlahHalaman = 0; // Reset pagination saat filter
} else {
    // Pagination - UBAH JADI 2 DATA PER HALAMAN
    $jumlahDataPerHalaman = 2;
    $jumlahData = count(select("SELECT * FROM barang"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $data_barang = select("SELECT * FROM barang ORDER BY id_barang DESC LIMIT $awalData, $jumlahDataPerHalaman");
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">

  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /Header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $total_barang; ?></h3>
              <p>Total Barang</p>
            </div>
            <div class="icon"><i class="ion ion-bag"></i></div>
            <a href="index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $barang_baru; ?></h3>
              <p>Barang Baru Hari Ini</p>
            </div>
            <div class="icon"><i class="ion ion-stats-bars"></i></div>
            <a href="index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $total_akun; ?></h3>
              <p>Total Akun</p>
            </div>
            <div class="icon"><i class="ion ion-person-add"></i></div>
            <a href="crud-modal.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>Rp <?= number_format($total_nilai, 0, ',', '.'); ?></h3>
              <p>Total Nilai Barang</p>
            </div>
            <div class="icon"><i class="ion ion-pie-graph"></i></div>
            <a href="index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Grafik Section -->
      <div class="row">
        <!-- Grafik Bar - Top 5 Barang -->
        <div class="col-lg-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-chart-bar"></i> Top 5 Barang Terbanyak</h3>
            </div>
            <div class="card-body">
              <canvas id="chartBarang" style="height:250px;"></canvas>
            </div>
          </div>
        </div>

        <!-- Grafik Line - Trend 6 Bulan -->
        <div class="col-lg-6">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-chart-line"></i> Trend Barang 6 Bulan Terakhir</h3>
            </div>
            <div class="card-body">
              <canvas id="chartTrend" style="height:250px;"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Data -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-list"></i> Data Barang</h3>
            </div>

            <div class="card-body">
              <a href="tambah-barang.php" class="btn btn-primary btn-sm mb-2">
                <i class="fas fa-plus"></i> Tambah
              </a>
              <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalFilter">
                <i class="fas fa-search"></i> Filter Data
              </button>
              <a href="index.php" class="btn btn-secondary btn-sm mb-2">
                <i class="fas fa-sync"></i> Reset Filter
              </a>

              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                  <thead class="bg-primary">
                    <tr>
                      <th width="5%">No</th>
                      <th>Nama</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Barcode</th>
                      <th>Tanggal</th>
                      <th width="15%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = $awalData + 1; ?>
                    <?php if (empty($data_barang)): ?>
                      <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                      </tr>
                    <?php else: ?>
                      <?php foreach ($data_barang as $barang) : ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $barang['nama']; ?></td>
                          <td><?= $barang['jumlah']; ?></td>
                          <td>Rp. <?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                          <td class="text-center">
                            <img alt="barcode" src="barcode.php?codetype=Code128&size=15&text=<?= $barang['barcode']; ?>&print=true" />
                          </td>
                          <td><?= date("d/m/Y | H:i:s", strtotime($barang['tanggal'])); ?></td>
                          <td class="text-center">
                            <a href="ubah-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-success btn-sm">
                              <i class="fas fa-edit"></i>
                            </a>
                            <a href="hapus-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Data Barang Akan Dihapus?');">
                              <i class="fas fa-trash"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              <?php if (!isset($_POST['filter'])): ?>
              <div class="mt-3 d-flex justify-content-end">
                <nav>
                  <ul class="pagination pagination-sm">
                    <?php if ($halamanAktif > 1) : ?>
                      <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>" aria-label="Previous">&laquo;</a>
                      </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                      <li class="page-item <?= $i == $halamanAktif ? 'active' : ''; ?>">
                        <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                      </li>
                    <?php endfor; ?>

                    <?php if ($halamanAktif < $jumlahHalaman) : ?>
                      <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>" aria-label="Next">&raquo;</a>
                      </li>
                    <?php endif; ?>
                  </ul>
                </nav>
              </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-search"></i> Filter Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="tgl_awal">Tanggal Awal</label>
            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="tgl_akhir">Tanggal Akhir</label>
            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success btn-sm" name="filter">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Data dari PHP ke JavaScript
const dataBarang = <?= json_encode($data_grafik_barang); ?>;
const dataBulanan = <?= json_encode($data_grafik_bulanan); ?>;

// Grafik Bar - Top 5 Barang
const ctxBarang = document.getElementById('chartBarang').getContext('2d');
const chartBarang = new Chart(ctxBarang, {
    type: 'bar',
    data: {
        labels: dataBarang.map(item => item.nama),
        datasets: [{
            label: 'Jumlah Stok',
            data: dataBarang.map(item => item.jumlah),
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
                display: true,
                position: 'top'
            },
            title: {
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

// Grafik Line - Trend 6 Bulan
const ctxTrend = document.getElementById('chartTrend').getContext('2d');
const chartTrend = new Chart(ctxTrend, {
    type: 'line',
    data: {
        labels: dataBulanan.map(item => item.bulan),
        datasets: [{
            label: 'Jumlah Barang Ditambahkan',
            data: dataBulanan.map(item => item.jumlah),
            backgroundColor: 'rgba(40, 167, 69, 0.2)',
            borderColor: 'rgba(40, 167, 69, 1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: 'rgba(40, 167, 69, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            title: {
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
</script>

<?php include 'layout/footer.php'; ?>