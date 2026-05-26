<?php
$aktif_count    = $aktif;
$nonaktif_count = $nonaktif;
$total_count    = $aktif_count + $nonaktif_count;

// Flash messages
$msg_ok  = $this->session->flashdata('msg_success');
$msg_err = $this->session->flashdata('msg_error');
?>

<?php if($msg_ok): ?>
<div class="alert alert-success alert-dismissible mb-3">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <i class="fas fa-check-circle mr-2"></i><?= htmlspecialchars($msg_ok) ?>
</div>
<?php endif; ?>
<?php if($msg_err): ?>
<div class="alert alert-danger alert-dismissible mb-3">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <i class="fas fa-exclamation-circle mr-2"></i><?= htmlspecialchars($msg_err) ?>
</div>
<?php endif; ?>

<!-- Stat Boxes -->
<div class="row">
  <div class="col-6 col-lg-4">
    <div class="small-box bg-primary">
      <div class="inner"><h3><?= $total_count ?></h3><p>Total Karyawan</p></div>
      <div class="icon"><i class="fas fa-users"></i></div>
      <span class="small-box-footer">&nbsp;</span>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="small-box bg-success">
      <div class="inner"><h3><?= $aktif_count ?></h3><p>Aktif</p></div>
      <div class="icon"><i class="fas fa-user-check"></i></div>
      <a href="<?= base_url('index.php/page/mKaryawan?kondisi=AKTIF') ?>" class="small-box-footer">
        Filter Aktif <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="small-box bg-secondary">
      <div class="inner"><h3><?= $nonaktif_count ?></h3><p>Nonaktif</p></div>
      <div class="icon"><i class="fas fa-user-times"></i></div>
      <a href="<?= base_url('index.php/page/mKaryawan?kondisi=NONAKTIF') ?>" class="small-box-footer">
        Filter Nonaktif <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>

<!-- Filter + Tambah -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card card-outline card-primary mb-0">
      <div class="card-body py-2">
        <form method="get" action="<?= base_url('index.php/page/mKaryawan') ?>" class="form-inline flex-wrap">
          <div class="input-group input-group-sm mr-2 mb-1">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" name="search" class="form-control" style="width:200px"
                   placeholder="Cari nama karyawan..." value="<?= htmlspecialchars($keyword) ?>">
          </div>
          <select name="kondisi" class="form-control form-control-sm mr-2 mb-1">
            <option value="semua"   <?= ($kondisi=='semua')   ? 'selected' : '' ?>>Semua Status</option>
            <option value="AKTIF"   <?= ($kondisi=='AKTIF')   ? 'selected' : '' ?>>Aktif</option>
            <option value="NONAKTIF" <?= ($kondisi=='NONAKTIF') ? 'selected' : '' ?>>Nonaktif</option>
          </select>
          <button type="submit" class="btn btn-primary btn-sm mr-2 mb-1">
            <i class="fas fa-filter mr-1"></i>Filter
          </button>
          <a href="<?= base_url('index.php/page/mKaryawan') ?>" class="btn btn-secondary btn-sm mr-2 mb-1">
            <i class="fas fa-times mr-1"></i>Reset
          </a>
          <a href="<?= base_url('index.php/page/mkTambah') ?>" class="btn btn-success btn-sm mb-1 ml-auto">
            <i class="fas fa-user-plus mr-1"></i>Tambah Karyawan
          </a>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Table -->
<div class="row">
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-id-card mr-2"></i>Daftar Karyawan
          <?php if($keyword || $kondisi !== 'semua'): ?>
          <small class="text-muted ml-2">
            (<?= $total ?> hasil
            <?= $keyword ? 'pencarian "'.htmlspecialchars($keyword).'"' : '' ?>
            <?= ($kondisi !== 'semua') ? '— '.htmlspecialchars($kondisi) : '' ?>)
          </small>
          <?php endif; ?>
        </h3>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th class="text-center" style="width:40px">No</th>
                <th style="min-width:160px">Nama Karyawan</th>
                <th>NIK</th>
                <th>Bagian</th>
                <th class="text-center">JK</th>
                <th class="text-center">Tipe Seragam</th>
                <th class="text-center">Level</th>
                <th class="text-center">Status</th>
                <th class="text-center" style="width:100px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $office_label = ['F' => 'Factory', 'O' => 'Office', 'W' => 'Wearpak'];
                $office_color = ['F' => 'primary', 'O' => 'info',    'W' => 'warning'];
                $no = $offset + 1;
                $rows = $list->result();
              ?>
              <?php if(empty($rows)): ?>
              <tr>
                <td colspan="9" class="text-center text-muted py-4">
                  <i class="fas fa-search fa-2x mb-2 d-block"></i>
                  Tidak ada data karyawan<?= $keyword ? ' yang cocok dengan "'.htmlspecialchars($keyword).'"' : '' ?>
                </td>
              </tr>
              <?php else: ?>
              <?php foreach($rows as $k): ?>
              <tr>
                <td class="text-center text-muted small"><?= $no++ ?></td>
                <td class="font-weight-bold"><?= htmlspecialchars($k->nama_karyawan) ?></td>
                <td><code><?= htmlspecialchars($k->nik) ?></code></td>
                <td><?= htmlspecialchars($k->kd_bagian ?? '') ?></td>
                <td class="text-center">
                  <?php if($k->jns_kelamin === 'Laki-laki'): ?>
                    <i class="fas fa-mars text-primary" title="Laki-laki"></i>
                  <?php else: ?>
                    <i class="fas fa-venus text-danger" title="Perempuan"></i>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <?php $oc = $k->seragam_office ?? ''; ?>
                  <span class="badge badge-<?= $office_color[$oc] ?? 'secondary' ?>">
                    <?= $office_label[$oc] ?? $oc ?>
                  </span>
                </td>
                <td class="text-center">
                  <?php if($k->id_levell == '1'): ?>
                  <span class="badge badge-danger">Admin</span>
                  <?php else: ?>
                  <span class="badge badge-secondary">User</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <?php if(strtoupper($k->kondisi) === 'AKTIF'): ?>
                  <span class="badge badge-success px-2 py-1">Aktif</span>
                  <?php else: ?>
                  <span class="badge badge-secondary px-2 py-1">Nonaktif</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <a href="<?= base_url('index.php/page/mkEdit/'.$k->id_karyawan) ?>"
                     class="btn btn-xs btn-info" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <?php if(strtoupper($k->kondisi) === 'AKTIF'): ?>
                  <a href="<?= base_url('index.php/page/mkToggle/'.$k->id_karyawan) ?>"
                     class="btn btn-xs btn-warning" title="Nonaktifkan"
                     onclick="return confirm('Nonaktifkan karyawan <?= addslashes(htmlspecialchars($k->nama_karyawan)) ?>?')">
                    <i class="fas fa-user-slash"></i>
                  </a>
                  <?php else: ?>
                  <a href="<?= base_url('index.php/page/mkToggle/'.$k->id_karyawan) ?>"
                     class="btn btn-xs btn-success" title="Aktifkan"
                     onclick="return confirm('Aktifkan kembali karyawan <?= addslashes(htmlspecialchars($k->nama_karyawan)) ?>?')">
                    <i class="fas fa-user-check"></i>
                  </a>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php if($total > $per_page): ?>
      <div class="card-footer d-flex justify-content-between align-items-center py-2">
        <small class="text-muted">
          Menampilkan <?= $offset + 1 ?>&#8211;<?= min($offset + $per_page, $total) ?>
          dari <strong><?= $total ?></strong> karyawan
        </small>
        <nav><?= $paginasi ?></nav>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
