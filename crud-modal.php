<?php
session_start();

// ===================== CEK LOGIN =====================
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Login dulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$title = 'Daftar Akun';
include 'layout/header.php';

// ===================== AMBIL DATA =====================
$data_akun = select("SELECT * FROM akun");

// Tampilkan hanya akun sesuai user login
$id_akun = $_SESSION['id_akun'];
$data_bylogin = select("SELECT * FROM akun WHERE id_akun = $id_akun");

// ===================== STATISTIK AKUN =====================
$total_akun = count($data_akun);
$total_admin = count(select("SELECT * FROM akun WHERE level = 1"));
$total_operator_barang = count(select("SELECT * FROM akun WHERE level = 2"));
$total_operator_mahasiswa = count(select("SELECT * FROM akun WHERE level = 3"));

// Data untuk grafik
$data_grafik_level = [
    ['level' => 'Admin', 'jumlah' => $total_admin],
    ['level' => 'Operator Barang', 'jumlah' => $total_operator_barang],
    ['level' => 'Operator Mahasiswa', 'jumlah' => $total_operator_mahasiswa]
];

// ===================== TAMBAH AKUN =====================
if (isset($_POST['tambah'])) {
    if (create_akun($_POST) > 0) {
        echo "<script>
            alert('Data Akun Berhasil Ditambahkan');
            document.location.href = 'crud-modal.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Akun Gagal Ditambahkan');
            document.location.href = 'crud-modal.php';
        </script>";
    }
}

// ===================== UBAH AKUN =====================
if (isset($_POST['ubah'])) {
    if (update_akun($_POST) > 0) {
        echo "<script>
            alert('Data Akun Berhasil Diubah');
            document.location.href = 'crud-modal.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Akun Gagal Diubah');
            document.location.href = 'crud-modal.php';
        </script>";
    }
}
?>

<!-- ===================== CONTENT ===================== -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users"></i> Data Akun</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Data Akun</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $total_akun; ?></h3>
                            <p>Total Akun</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $total_admin; ?></h3>
                            <p>Admin</p>
                        </div>
                        <div class="icon"><i class="fas fa-user-shield"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $total_operator_barang; ?></h3>
                            <p>Operator Barang</p>
                        </div>
                        <div class="icon"><i class="fas fa-box"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $total_operator_mahasiswa; ?></h3>
                            <p>Operator Mahasiswa</p>
                        </div>
                        <div class="icon"><i class="fas fa-user-graduate"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Grafik Section -->
            <?php if ($_SESSION['level'] == 1): ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie"></i> Distribusi Level Akun</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartLevel" style="height:250px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Jumlah Akun per Level</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartBar" style="height:250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Table Data Akun -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-list"></i> Daftar Akun</h3>
                            <?php if ($_SESSION['level'] == 1): ?>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                    <i class="fas fa-plus"></i> Tambah Akun
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover table-striped">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Level</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php if ($_SESSION['level'] == 1): ?>
                                            <?php foreach ($data_akun as $akun): ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++; ?></td>
                                                    <td><?= htmlspecialchars($akun['nama']); ?></td>
                                                    <td><?= htmlspecialchars($akun['username']); ?></td>
                                                    <td><?= htmlspecialchars($akun['email']); ?></td>
                                                    <td>
                                                        <?php 
                                                            if ($akun['level'] == 1) {
                                                                echo '<span class="badge badge-danger">Admin</span>';
                                                            } elseif ($akun['level'] == 2) {
                                                                echo '<span class="badge badge-success">Operator Barang</span>';
                                                            } else {
                                                                echo '<span class="badge badge-warning">Operator Mahasiswa</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-success btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalUbah<?= $akun['id_akun']; ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalHapus<?= $akun['id_akun']; ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <?php foreach ($data_bylogin as $akun): ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++; ?></td>
                                                    <td><?= htmlspecialchars($akun['nama']); ?></td>
                                                    <td><?= htmlspecialchars($akun['username']); ?></td>
                                                    <td><?= htmlspecialchars($akun['email']); ?></td>
                                                    <td>
                                                        <?php 
                                                            if ($akun['level'] == 1) {
                                                                echo '<span class="badge badge-danger">Admin</span>';
                                                            } elseif ($akun['level'] == 2) {
                                                                echo '<span class="badge badge-success">Operator Barang</span>';
                                                            } else {
                                                                echo '<span class="badge badge-warning">Operator Mahasiswa</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-success btn-sm" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalUbah<?= $akun['id_akun']; ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
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
    </div>
</div>

<!-- ===================== MODAL TAMBAH ===================== -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahLabel"><i class="fas fa-user-plus"></i> Tambah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter..." required minlength="6">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-control" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="1">Admin</option>
                            <option value="2">Operator Barang</option>
                            <option value="3">Operator Mahasiswa</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" name="tambah" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===================== MODAL UBAH ===================== -->
<?php foreach ($data_akun as $akun): ?>
<div class="modal fade" id="modalUbah<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="modalUbahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalUbahLabel"><i class="fas fa-edit"></i> Ubah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_akun" value="<?= $akun['id_akun']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($akun['nama']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($akun['username']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($akun['email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <small class="text-muted">(Isi jika ingin mengubah)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah" minlength="6">
                    </div>

                    <?php if ($_SESSION['level'] == 1): ?>
                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            <select name="level" class="form-control" required>
                                <option value="1" <?= $akun['level'] == '1' ? 'selected' : ''; ?>>Admin</option>
                                <option value="2" <?= $akun['level'] == '2' ? 'selected' : ''; ?>>Operator Barang</option>
                                <option value="3" <?= $akun['level'] == '3' ? 'selected' : ''; ?>>Operator Mahasiswa</option>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="level" value="<?= $akun['level']; ?>">
                    <?php endif; ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" name="ubah" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- ===================== MODAL HAPUS ===================== -->
<?php foreach ($data_akun as $akun): ?>
<div class="modal fade" id="modalHapus<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalHapusLabel"><i class="fas fa-trash"></i> Hapus Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>Perhatian!</strong> Data yang dihapus tidak dapat dikembalikan.
                </div>
                <p>Yakin ingin menghapus akun <strong><?= htmlspecialchars($akun['nama']); ?></strong>?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="hapus-akun.php?id_akun=<?= $akun['id_akun']; ?>" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Chart.js Script -->
<?php if ($_SESSION['level'] == 1): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Data dari PHP ke JavaScript
const dataLevel = <?= json_encode($data_grafik_level); ?>;

// Grafik Pie - Distribusi Level
const ctxPie = document.getElementById('chartLevel').getContext('2d');
const chartPie = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: dataLevel.map(item => item.level),
        datasets: [{
            data: dataLevel.map(item => item.jumlah),
            backgroundColor: [
                'rgba(220, 53, 69, 0.8)',   // Merah untuk Admin
                'rgba(40, 167, 69, 0.8)',   // Hijau untuk Operator Barang
                'rgba(255, 193, 7, 0.8)'    // Kuning untuk Operator Mahasiswa
            ],
            borderColor: [
                'rgba(220, 53, 69, 1)',
                'rgba(40, 167, 69, 1)',
                'rgba(255, 193, 7, 1)'
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

// Grafik Bar - Jumlah per Level
const ctxBar = document.getElementById('chartBar').getContext('2d');
const chartBar = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: dataLevel.map(item => item.level),
        datasets: [{
            label: 'Jumlah Akun',
            data: dataLevel.map(item => item.jumlah),
            backgroundColor: [
                'rgba(220, 53, 69, 0.7)',
                'rgba(40, 167, 69, 0.7)',
                'rgba(255, 193, 7, 0.7)'
            ],
            borderColor: [
                'rgba(220, 53, 69, 1)',
                'rgba(40, 167, 69, 1)',
                'rgba(255, 193, 7, 1)'
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
</script>
<?php endif; ?>

<?php include 'layout/footer.php'; ?>