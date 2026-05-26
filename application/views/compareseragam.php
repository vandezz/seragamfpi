<?php
// ── Build pivot data ─────────────────────────────────────────────
$periods = [];
foreach($periode->result() as $p) $periods[] = $p->periode;
sort($periods);

$rows = [];
foreach($dt->result() as $r) {
    $idk = $r->idk;
    if (!isset($rows[$idk])) {
        $rows[$idk] = ['nama' => $r->Nama, 'bagian' => $r->Bagian];
    }
    $rows[$idk][$r->periode] = [
        'baju'   => $r->Sizebaju,
        'lengan' => $r->Lengan,
        'celana' => $r->SizeCelana,
    ];
}
uasort($rows, function($a, $b){ return strcmp($a['nama'], $b['nama']); });

$total_k = count($rows);
$total_p = count($periods);
?>

<!-- Summary Bar -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card card-outline card-info mb-0">
      <div class="card-body py-2">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <div>
            <span class="badge badge-info px-3 py-2 mr-2">
              <i class="fas fa-users mr-1"></i><?= $total_k ?> Karyawan Aktif
            </span>
            <span class="badge badge-secondary px-3 py-2">
              <i class="fas fa-calendar-alt mr-1"></i><?= $total_p ?> Periode: <?= implode(', ', $periods) ?>
            </span>
          </div>
          <div class="form-inline mt-2 mt-md-0">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
              </div>
              <input type="text" id="srch-nama" class="form-control" placeholder="Cari nama karyawan..." style="width:210px">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btn-clear-srch" title="Bersihkan">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Legend -->
<div class="row mb-2">
  <div class="col-12">
    <small class="text-muted">
      <span class="badge badge-warning px-2 py-1 mr-2">
        <i class="fas fa-exchange-alt mr-1"></i>Ukuran berubah dari periode sebelumnya
      </span>
      <span class="badge badge-light border px-2 py-1 mr-2 text-muted">&#8212; Belum mengisi</span>
      <span>Strikethrough = ukuran periode sebelumnya</span>
    </small>
  </div>
</div>

<!-- Pivot Table -->
<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">
          <i class="fas fa-exchange-alt mr-2"></i>Perbandingan Ukuran Seragam Antar Periode
        </h3>
        <a href="<?= base_url('page/pengguna') ?>" class="btn btn-sm btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table id="tbl-compare" class="table table-sm table-bordered table-hover mb-0">
            <thead>
              <tr class="thead-dark">
                <th rowspan="2" class="align-middle text-center" style="min-width:36px">No</th>
                <th rowspan="2" class="align-middle" style="min-width:170px">Nama Karyawan</th>
                <th rowspan="2" class="align-middle text-center">Bagian</th>
                <?php foreach($periods as $yr): ?>
                <th colspan="2" class="text-center bg-primary text-white border-left"><?= $yr ?></th>
                <?php endforeach; ?>
              </tr>
              <tr class="thead-light">
                <?php foreach($periods as $yr): ?>
                <th class="text-center border-left" style="min-width:70px">Baju</th>
                <th class="text-center" style="min-width:60px">Celana</th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php if(empty($rows)): ?>
              <tr>
                <td colspan="<?= 3 + $total_p * 2 ?>" class="text-center text-muted py-4">
                  <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Belum ada data seragam
                </td>
              </tr>
              <?php else: ?>
              <?php $no = 1; foreach($rows as $idk => $row): ?>
              <tr class="karyawan-row">
                <td class="text-center text-muted small"><?= $no++ ?></td>
                <td class="font-weight-bold karyawan-nama"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="text-center">
                  <span class="badge badge-secondary"><?= htmlspecialchars($row['bagian']) ?></span>
                </td>
                <?php
                  $prev = null;
                  foreach($periods as $yr):
                    $d          = isset($row[$yr]) ? $row[$yr] : null;
                    $baju_chg   = ($d && $prev && $d['baju']   !== $prev['baju']);
                    $celana_chg = ($d && $prev && $d['celana'] !== $prev['celana']);
                ?>
                <td class="text-center border-left <?= $baju_chg ? 'table-warning' : '' ?>">
                  <?php if($d): ?>
                    <strong><?= htmlspecialchars($d['baju']) ?></strong>
                    <?php if($d['lengan']): ?>
                      <br><small class="text-muted" style="font-size:10px">
                        <?= ($d['lengan'] === 'Lengan Pendek') ? 'Pendek' : 'Panjang' ?>
                      </small>
                    <?php endif; ?>
                    <?php if($baju_chg): ?>
                      <br><small class="text-danger" style="text-decoration:line-through;font-size:10px">
                        <?= htmlspecialchars($prev['baju']) ?>
                      </small>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-muted">&#8212;</span>
                  <?php endif; ?>
                </td>
                <td class="text-center <?= $celana_chg ? 'table-warning' : '' ?>">
                  <?php if($d): ?>
                    <strong><?= htmlspecialchars($d['celana']) ?></strong>
                    <?php if($celana_chg): ?>
                      <br><small class="text-danger" style="text-decoration:line-through;font-size:10px">
                        <?= htmlspecialchars($prev['celana']) ?>
                      </small>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-muted">&#8212;</span>
                  <?php endif; ?>
                </td>
                <?php
                    $prev = $d;
                  endforeach;
                ?>
              </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-between align-items-center py-2">
        <small class="text-muted">
          Menampilkan <strong id="visible-count"><?= $total_k ?></strong>
          dari <?= $total_k ?> karyawan
        </small>
        <?php
          $changed_baju = $changed_celana = 0;
          foreach($rows as $row) {
              $prev = null;
              foreach($periods as $yr) {
                  $d = isset($row[$yr]) ? $row[$yr] : null;
                  if($d && $prev) {
                      if($d['baju']   !== $prev['baju'])   $changed_baju++;
                      if($d['celana'] !== $prev['celana']) $changed_celana++;
                  }
                  $prev = $d;
              }
          }
        ?>
        <small class="text-muted">
          <i class="fas fa-exchange-alt text-warning mr-1"></i>
          <?= $changed_baju ?> perubahan baju &nbsp;|&nbsp;
          <?= $changed_celana ?> perubahan celana
        </small>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  var input   = document.getElementById('srch-nama');
  var btnClr  = document.getElementById('btn-clear-srch');
  var counter = document.getElementById('visible-count');

  function filter(){
    var q    = input.value.toLowerCase().trim();
    var rows = document.querySelectorAll('#tbl-compare tbody tr.karyawan-row');
    var vis  = 0;
    rows.forEach(function(tr){
      var nama = tr.querySelector('.karyawan-nama').textContent.toLowerCase();
      var show = (q === '') || (nama.indexOf(q) !== -1);
      tr.style.display = show ? '' : 'none';
      if(show) vis++;
    });
    counter.textContent = vis;
    btnClr.style.display = (q !== '') ? '' : 'none';
  }

  input.addEventListener('keyup', filter);
  btnClr.addEventListener('click', function(){
    input.value = '';
    filter();
    input.focus();
  });
  btnClr.style.display = 'none';
})();
</script>
