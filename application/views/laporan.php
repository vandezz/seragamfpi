<?php
$belum      = $total_k - $sudah;
$pct_sudah  = ($total_k > 0) ? round(($sudah  / $total_k) * 100, 1) : 0;
$pct_belum  = ($total_k > 0) ? round(($belum  / $total_k) * 100, 1) : 0;

// Build arrays for charts
$baju_labels = $baju_data = $celana_labels = $celana_data = [];
foreach($rekap_baju->result()   as $r){ $baju_labels[]   = $r->ukuran; $baju_data[]   = (int)$r->jumlah; }
foreach($rekap_celana->result() as $r){ $celana_labels[] = $r->ukuran; $celana_data[] = (int)$r->jumlah; }

$belum_rows = $belum_list->result();
?>

<!-- Period Filter -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card card-outline card-primary mb-0">
      <div class="card-body py-2">
        <form method="get" action="<?= base_url('index.php/page/laporan') ?>" class="form-inline">
          <label class="mr-2 font-weight-bold">Periode:</label>
          <select name="periode" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
            <?php foreach($periode_list->result() as $p): ?>
            <option value="<?= $p->periode ?>" <?= ($p->periode == $thn) ? 'selected' : '' ?>><?= $p->periode ?></option>
            <?php endforeach; ?>
          </select>
          <span class="text-muted ml-2" style="font-size:13px">Menampilkan data tahun <strong><?= $thn ?></strong></span>
        </form>
        <a href="<?= base_url('index.php/page/exportExcel?periode=' . $thn) ?>" class="btn btn-success btn-sm mt-2 mt-md-0 float-md-right">
          <i class="fas fa-file-excel mr-1"></i>Export Excel
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Stat Boxes -->
<div class="row">
  <div class="col-6 col-lg-3">
    <div class="small-box bg-primary">
      <div class="inner"><h3><?= $total_k ?></h3><p>Total Karyawan Aktif</p></div>
      <div class="icon"><i class="fas fa-users"></i></div>
      <span class="small-box-footer">&nbsp;</span>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box bg-success">
      <div class="inner"><h3><?= $sudah ?></h3><p>Sudah Mengisi</p></div>
      <div class="icon"><i class="fas fa-check-circle"></i></div>
      <span class="small-box-footer">&nbsp;</span>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box bg-warning">
      <div class="inner"><h3><?= $belum ?></h3><p>Belum Mengisi</p></div>
      <div class="icon"><i class="fas fa-clock"></i></div>
      <span class="small-box-footer">&nbsp;</span>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="small-box bg-info">
      <div class="inner"><h3><?= $pct_sudah ?><sup style="font-size:15px">%</sup></h3><p>Progres Pengisian</p></div>
      <div class="icon"><i class="fas fa-chart-pie"></i></div>
      <span class="small-box-footer">&nbsp;</span>
    </div>
  </div>
</div>

<!-- Charts Row -->
<div class="row">
  <!-- Donut: sudah vs belum -->
  <div class="col-12 col-md-4">
    <div class="card card-outline card-success">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Progres Pengisian <?= $thn ?></h3>
      </div>
      <div class="card-body text-center">
        <canvas id="chartDonut" style="max-height:220px"></canvas>
        <div class="mt-2">
          <span class="badge badge-success px-2 py-1 mr-1">Sudah: <?= $sudah ?> (<?= $pct_sudah ?>%)</span>
          <span class="badge badge-warning px-2 py-1">Belum: <?= $belum ?> (<?= $pct_belum ?>%)</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Bar: Ukuran Baju -->
  <div class="col-12 col-md-4">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tshirt mr-1"></i>Rekap Ukuran Baju</h3>
      </div>
      <div class="card-body">
        <?php if(empty($baju_data)): ?>
        <p class="text-center text-muted">Belum ada data</p>
        <?php else: ?>
        <canvas id="chartBaju" style="max-height:220px"></canvas>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Bar: Ukuran Celana -->
  <div class="col-12 col-md-4">
    <div class="card card-outline card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-ruler-combined mr-1"></i>Rekap Ukuran Celana</h3>
      </div>
      <div class="card-body">
        <?php if(empty($celana_data)): ?>
        <p class="text-center text-muted">Belum ada data</p>
        <?php else: ?>
        <canvas id="chartCelana" style="max-height:220px"></canvas>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Detail Tables Row -->
<div class="row">
  <!-- Tabel Rekap Ukuran Baju -->
  <div class="col-12 col-md-6">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-table mr-1"></i>Detail Rekap Ukuran Baju</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-sm table-bordered table-striped mb-0">
          <thead class="thead-light">
            <tr><th>Ukuran</th><th>Jumlah</th><th>Persentase</th></tr>
          </thead>
          <tbody>
            <?php foreach($baju_labels as $i => $uk): ?>
            <tr>
              <td><strong><?= $uk ?></strong></td>
              <td><?= $baju_data[$i] ?></td>
              <td>
                <?php $pct_uk = ($sudah > 0) ? round($baju_data[$i]/$sudah*100,1) : 0; ?>
                <div class="progress progress-xs mt-1">
                  <div class="progress-bar bg-primary" style="width:<?= $pct_uk ?>%"></div>
                </div>
                <small><?= $pct_uk ?>%</small>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($baju_labels)): ?>
            <tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>
            <?php endif; ?>
          </tbody>
          <?php if(!empty($baju_labels)): ?>
          <tfoot><tr><th>Total</th><th><?= $sudah ?></th><th>100%</th></tr></tfoot>
          <?php endif; ?>
        </table>
      </div>
    </div>
  </div>

  <!-- Tabel Rekap Ukuran Celana -->
  <div class="col-12 col-md-6">
    <div class="card card-outline card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-table mr-1"></i>Detail Rekap Ukuran Celana</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-sm table-bordered table-striped mb-0">
          <thead class="thead-light">
            <tr><th>Ukuran</th><th>Jumlah</th><th>Persentase</th></tr>
          </thead>
          <tbody>
            <?php foreach($celana_labels as $i => $uk): ?>
            <tr>
              <td><strong><?= $uk ?></strong></td>
              <td><?= $celana_data[$i] ?></td>
              <td>
                <?php $pct_uk = ($sudah > 0) ? round($celana_data[$i]/$sudah*100,1) : 0; ?>
                <div class="progress progress-xs mt-1">
                  <div class="progress-bar bg-info" style="width:<?= $pct_uk ?>%"></div>
                </div>
                <small><?= $pct_uk ?>%</small>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($celana_labels)): ?>
            <tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>
            <?php endif; ?>
          </tbody>
          <?php if(!empty($celana_labels)): ?>
          <tfoot><tr><th>Total</th><th><?= $sudah ?></th><th>100%</th></tr></tfoot>
          <?php endif; ?>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Belum Mengisi -->
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-warning">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-user-times mr-1"></i>Karyawan Belum Mengisi (<?= $thn ?>) — <?= count($belum_rows) ?> orang</h3>
        <button class="btn btn-sm btn-warning" onclick="window.print()">
          <i class="fas fa-print mr-1"></i>Print
        </button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
              <tr><th>No</th><th>Nama Karyawan</th><th>Bagian</th></tr>
            </thead>
            <tbody>
              <?php if(empty($belum_rows)): ?>
              <tr><td colspan="3" class="text-center text-success"><i class="fas fa-check-circle mr-1"></i>Semua karyawan sudah mengisi!</td></tr>
              <?php else: $no=1; foreach($belum_rows as $b): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($b->nama_karyawan) ?></td>
                <td><?= $b->kd_bagian ?></td>
              </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  // Donut Chart
  new Chart(document.getElementById('chartDonut').getContext('2d'), {
    type: 'doughnut',
    data: {
      labels: ['Sudah Mengisi','Belum Mengisi'],
      datasets: [{ data: [<?= $sudah ?>, <?= $belum ?>], backgroundColor: ['#28a745','#ffc107'], borderWidth: 2 }]
    },
    options: { responsive: true, maintainAspectRatio: true, legend: { position: 'bottom' }, cutoutPercentage: 55 }
  });

  <?php if(!empty($baju_data)): ?>
  // Bar Chart: Ukuran Baju
  new Chart(document.getElementById('chartBaju').getContext('2d'), {
    type: 'bar',
    data: {
      labels: <?= json_encode($baju_labels) ?>,
      datasets: [{ label: 'Jumlah', data: <?= json_encode($baju_data) ?>,
        backgroundColor: 'rgba(0,123,255,0.7)', borderColor: '#007bff', borderWidth: 1 }]
    },
    options: { responsive: true, legend: { display: false },
      scales: { yAxes: [{ ticks: { beginAtZero: true, stepSize: 1 } }] } }
  });
  <?php endif; ?>

  <?php if(!empty($celana_data)): ?>
  // Bar Chart: Ukuran Celana
  new Chart(document.getElementById('chartCelana').getContext('2d'), {
    type: 'bar',
    data: {
      labels: <?= json_encode($celana_labels) ?>,
      datasets: [{ label: 'Jumlah', data: <?= json_encode($celana_data) ?>,
        backgroundColor: 'rgba(23,162,184,0.7)', borderColor: '#17a2b8', borderWidth: 1 }]
    },
    options: { responsive: true, legend: { display: false },
      scales: { yAxes: [{ ticks: { beginAtZero: true, stepSize: 1 } }] } }
  });
  <?php endif; ?>
});
</script>
