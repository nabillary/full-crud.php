<?php
session_start();

// Cek login
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Login dulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

// Batasi hak akses (hanya level 1 & 3)
if ($_SESSION["level"] != 1 && $_SESSION["level"] != 3) {
    echo "<script>
        alert('Anda tidak punya hak akses');
        document.location.href = 'crud-modal.php';
    </script>";
    exit;
}

$title = 'Data Mahasiswa';
include 'layout/header.php';

// ===================== DATA STATISTIK =====================
$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");
$total_mahasiswa = count($data_mahasiswa);

// Hitung jumlah mahasiswa per prodi
$prodi_count = [];
foreach ($data_mahasiswa as $mhs) {
    $prodi = $mhs['prodi'];
    if (isset($prodi_count[$prodi])) {
        $prodi_count[$prodi]++;
    } else {
        $prodi_count[$prodi] = 1;
    }
}

// Hitung jumlah mahasiswa per jenis kelamin
$jk_count = ['laki-laki' => 0, 'perempuan' => 0];
foreach ($data_mahasiswa as $mhs) {
    $jk = strtolower($mhs['jk']);
    if (isset($jk_count[$jk])) {
        $jk_count[$jk]++;
    }
}

// Konversi untuk grafik prodi
$data_grafik_prodi = [];
foreach ($prodi_count as $prodi => $jumlah) {
    $data_grafik_prodi[] = [
        'prodi' => $prodi,
        'jumlah' => $jumlah
    ];
}

// Data untuk grafik jenis kelamin
$data_grafik_jk = [
    ['jk' => 'Laki-laki', 'jumlah' => $jk_count['laki-laki']],
    ['jk' => 'Perempuan', 'jumlah' => $jk_count['perempuan']]
];
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-user-graduate"></i> Data Mahasiswa</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Data Mahasiswa</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $total_mahasiswa; ?></h3>
              <p>Total Mahasiswa</p>
            </div>
            <div class="icon"><i class="fas fa-user-graduate"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3><?= $jk_count['laki-laki']; ?></h3>
              <p>Mahasiswa Laki-laki</p>
            </div>
            <div class="icon"><i class="fas fa-mars"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $jk_count['perempuan']; ?></h3>
              <p>Mahasiswa Perempuan</p>
            </div>
            <div class="icon"><i class="fas fa-venus"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= count($prodi_count); ?></h3>
              <p>Jumlah Program Studi</p>
            </div>
            <div class="icon"><i class="fas fa-graduation-cap"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Grafik Section -->
      <div class="row">
        <!-- Grafik Bar - Mahasiswa per Prodi -->
        <div class="col-lg-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-chart-bar"></i> Mahasiswa per Program Studi</h3>
            </div>
            <div class="card-body">
              <canvas id="chartProdi" style="height:250px;"></canvas>
            </div>
          </div>
        </div>

        <!-- Grafik Pie - Jenis Kelamin -->
        <div class="col-lg-6">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-chart-pie"></i> Distribusi Jenis Kelamin</h3>
            </div>
            <div class="card-body">
              <canvas id="chartJK" style="height:250px;"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel Data Mahasiswa -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-list"></i> Daftar Mahasiswa</h3>
            </div>

            <div class="card-body">
              <a href="tambah-mahasiswa.php" class="btn btn-primary btn-sm mb-2">
                <i class="fas fa-plus"></i> Tambah
              </a>
              <a href="download-excel-mahasiswa.php" class="btn btn-success btn-sm mb-2">
                <i class="fas fa-file-excel"></i> Excel
              </a>
              <a href="download-pdf-mahasiswa.php" class="btn btn-danger btn-sm mb-2">
                <i class="fas fa-file-pdf"></i> PDF
              </a>

              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                  <thead class="bg-primary">
                    <tr>
                      <th width="5%">No</th>
                      <th>Nama</th>
                      <th>Prodi</th>
                      <th>Jenis Kelamin</th>
                      <th>No. Telp</th>
                      <th width="20%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($data_mahasiswa)): ?>
                      <tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                      </tr>
                    <?php else: ?>
                      <?php $no = 1; ?>
                      <?php foreach ($data_mahasiswa as $mhs) : ?>
                      <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($mhs['nama']); ?></td>
                        <td><?= htmlspecialchars($mhs['prodi']); ?></td>
                        <td class="text-center">
                          <?php 
                            if (strtolower($mhs['jk']) == 'laki-laki') {
                              echo '<span class="badge badge-primary">Laki-laki</span>';
                            } else {
                              echo '<span class="badge badge-danger">Perempuan</span>';
                            }
                          ?>
                        </td>
                        <td><?= htmlspecialchars($mhs['telepon']); ?></td>
                        <td class="text-center">
                          <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mhs['id_mahasiswa']; ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mhs['id_mahasiswa']; ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mhs['id_mahasiswa']; ?>" 
                             class="btn btn-danger btn-sm"
                             onclick="return confirm('Yakin data mahasiswa akan dihapus?');">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
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
const dataProdi = <?= json_encode($data_grafik_prodi); ?>;
const dataJK = <?= json_encode($data_grafik_jk); ?>;

// Grafik Bar - Mahasiswa per Prodi
const ctxProdi = document.getElementById('chartProdi').getContext('2d');
const chartProdi = new Chart(ctxProdi, {
    type: 'bar',
    data: {
        labels: dataProdi.map(item => item.prodi),
        datasets: [{
            label: 'Jumlah Mahasiswa',
            data: dataProdi.map(item => item.jumlah),
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

// Grafik Pie - Jenis Kelamin
const ctxJK = document.getElementById('chartJK').getContext('2d');
const chartJK = new Chart(ctxJK, {
    type: 'pie',
    data: {
        labels: dataJK.map(item => item.jk),
        datasets: [{
            data: dataJK.map(item => item.jumlah),
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',  // Biru untuk Laki-laki
                'rgba(220, 53, 69, 0.8)'    // Merah untuk Perempuan
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(220, 53, 69, 1)'
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

<?php include 'layout/footer.php'; ?>