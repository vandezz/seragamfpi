<?php
$total   = $total_k;
$sudah   = $c;
$belum   = $total - $sudah;
$pct     = ($total > 0) ? round(($sudah / $total) * 100, 1) : 0;
$pct_blm = ($total > 0) ? round(($belum / $total) * 100, 1) : 0;
?>

<!-- Stat Boxes -->
<div class="row">
  <div class="col-6 col-lg-3">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $sudah ?></h3>
        <p>Sudah Mengisi</p>
      </div>
      <div class="icon"><i class="fas fa-check-circle"></i></div>
      <a href="#tabel-seragam" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?= $belum ?></h3>
        <p>Belum Mengisi</p>
      </div>
      <div class="icon"><i class="fas fa-clock"></i></div>
      <a href="<?= base_url('index.php/page/yangbelum') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $pct ?><sup style="font-size:16px">%</sup></h3>
        <p>Progres Pengisian</p>
      </div>
      <div class="icon"><i class="fas fa-chart-pie"></i></div>
      <span class="small-box-footer">&nbsp;</span>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3><?= $total ?></h3>
        <p>Total Karyawan Aktif</p>
      </div>
      <div class="icon"><i class="fas fa-users"></i></div>
      <span class="small-box-footer">&nbsp;</span>
    </div>
  </div>
</div>

<!-- Progress Bar Status Pengisian -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card card-outline card-success mb-0">
      <div class="card-body py-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="font-weight-bold"><i class="fas fa-tasks mr-1"></i>Status Pengisian Seragam <?= $thn ?></span>
          <span class="font-weight-bold text-<?= $pct >= 100 ? 'success' : ($pct >= 50 ? 'primary' : 'warning') ?>">
            <?= $sudah ?> / <?= $total ?> karyawan (<?= $pct ?>%)
          </span>
        </div>
        <div class="progress" style="height:22px;">
          <div class="progress-bar progress-bar-striped bg-<?= $pct >= 100 ? 'success' : ($pct >= 50 ? 'primary' : 'warning') ?>"
               role="progressbar"
               style="width:<?= $pct ?>%"
               aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100">
            <?php if($pct > 10): ?><?= $pct ?>%<?php endif; ?>
          </div>
        </div>
        <?php if($belum > 0): ?>
        <small class="text-muted mt-1 d-block"><i class="fas fa-exclamation-circle text-warning mr-1"></i><?= $belum ?> karyawan belum mengisi</small>
        <?php else: ?>
        <small class="text-success mt-1 d-block"><i class="fas fa-check-circle mr-1"></i>Semua karyawan sudah mengisi!</small>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Chart + Tools Row -->
<div class="row">

  <!-- Donut Chart -->
  <div class="col-12 col-md-5">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Statistik Pengisian <?= $thn ?></h3>
      </div>
      <div class="card-body text-center">
        <canvas id="donutChart" style="max-height:280px;"></canvas>
        <div class="mt-3">
          <span class="badge badge-info px-3 py-2 mr-2">Sudah: <?= $sudah ?> (<?= $pct ?>%)</span>
          <span class="badge badge-warning px-3 py-2">Belum: <?= $belum ?> (<?= $pct_blm ?>%)</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Tools Panel -->
  <div class="col-12 col-md-7">
    <div class="row">

      <!-- Reset Password -->
      <div class="col-12">
        <div class="card card-warning card-outline">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-key mr-2"></i>Reset Password Karyawan</h3>
          </div>
          <div class="card-body">
            <form action="<?= base_url('index.php/page/resetpassword') ?>" method="post">
              <div class="form-row align-items-end">
                <div class="col-12 col-sm-6 mb-2">
                  <label class="mb-1">Pilih Karyawan</label>
                  <select name="skr" id="skr" class="form-control form-control-sm">
                    <?php foreach($k->result() as $kw): ?>
                    <option value="<?= $kw->id_karyawan ?>"><?= $kw->nama_karyawan ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-12 col-sm-4 mb-2">
                  <label class="mb-1">Password Baru</label>
                  <input type="password" name="npass" class="form-control form-control-sm" value="12345" placeholder="Password baru">
                </div>
                <div class="col-12 col-sm-2 mb-2">
                  <button type="submit" class="btn btn-warning btn-sm btn-block">
                    <i class="fas fa-redo mr-1"></i>Reset
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Parameter Tanggal Maksimal -->
      <div class="col-12">
        <div class="card card-danger card-outline">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar-check mr-2"></i>Parameter Tanggal</h3>
          </div>
          <div class="card-body py-2">
            <p class="mb-2 text-muted" style="font-size:13px">Atur batas tanggal maksimal pengisian form seragam.</p>
            <a href="<?= base_url('index.php/page/rubahtanggalmax') ?>" class="btn btn-danger btn-sm">
              <i class="fas fa-edit mr-1"></i>Ubah Tanggal Maksimal
            </a>
          </div>
        </div>
      </div>

      <!-- Lihat Data Periode Lain -->
      <div class="col-12">
        <div class="card card-secondary card-outline">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Lihat Data Periode Lain</h3>
          </div>
          <div class="card-body">
            <form action="<?= base_url('index.php/page/showseragamperiode') ?>" method="post">
              <div class="form-row align-items-end">
                <div class="col-8 col-sm-6 mb-2">
                  <label class="mb-1">Pilih Periode</label>
                  <select name="periode" class="form-control form-control-sm">
                    <?php foreach($p->result() as $pr): ?>
                    <option value="<?= $pr->periode ?>"><?= $pr->periode ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-4 col-sm-3 mb-2">
                  <button type="submit" class="btn btn-secondary btn-sm btn-block">
                    <i class="fas fa-eye mr-1"></i>Lihat
                  </button>
                </div>
                <div class="col-12 col-sm-3 mb-2">
                  <a href="<?= base_url('index.php/page/compareseragam') ?>" class="btn btn-info btn-sm btn-block">
                    <i class="fas fa-exchange-alt mr-1"></i>Compare
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Tabel Data Seragam -->
<div class="row" id="tabel-seragam">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-table mr-2"></i>Data Seragam <?= $thn ?></h3>
        <a href="<?= base_url('index.php/page/unduh') ?>" class="btn btn-success btn-sm">
          <i class="fas fa-download mr-1"></i>Unduh
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table id="tbl-seragam" class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Ukuran Baju</th>
                <th>Lengan</th>
                <th>Ukuran Celana</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = $offset + 1; foreach($g->result() as $sl): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($sl->Nama) ?></td>
                <td><?= $sl->Sizebaju ?></td>
                <td><?= $sl->Lengan ?></td>
                <td><?= $sl->SizeCelana ?></td>
                <td><?= $sl->Ket ?></td>
                <td>
                  <a href="<?= base_url('index.php/page/editukuran/'.$sl->idseragam.'/'.$sl->Nama) ?>" class="btn btn-info btn-xs">
                    <i class="fas fa-edit"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php if($total_seragam > $per_page): ?>
      <div class="card-footer d-flex justify-content-between align-items-center py-2">
        <small class="text-muted">
          Menampilkan <?= $offset + 1 ?>–<?= min($offset + $per_page, $total_seragam) ?>
          dari <strong><?= $total_seragam ?></strong> data
        </small>
        <nav><?= $paginasi ?></nav>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script src="<?= base_url('js/Chart.min.js') ?>"></script>
<script>
(function() {
  var ctx = document.getElementById('donutChart').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Sudah Mengisi', 'Belum Mengisi'],
      datasets: [{
        data: [<?= $sudah ?>, <?= $belum ?>],
        backgroundColor: ['#17a2b8', '#ffc107'],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      legend: { position: 'bottom' },
      cutoutPercentage: 60
    }
  });
})();
</script>
