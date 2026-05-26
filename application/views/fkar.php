<?php
// Build JSON list of employees for autocomplete
$karyawan_list = [];
foreach($dk->result() as $kw){
    $karyawan_list[] = ['id' => $kw->id_karyawan, 'label' => $kw->nama_karyawan];
}
$dk->free_result();
?>

<style>
.ui-autocomplete {
    max-height: 250px;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 9999 !important;
    border: 1px solid #ced4da;
    border-radius: 0 0 .25rem .25rem;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    padding: 4px 0;
}
.ui-menu-item-wrapper {
    padding: 8px 14px;
    font-size: 14px;
    cursor: pointer;
}
.ui-state-active, .ui-widget-content .ui-state-active {
    background: #007bff !important;
    color: #fff !important;
    border: none !important;
    border-radius: 0;
}
</style>

<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-search mr-2"></i>Cari Karyawan</h3>
  </div>
  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <label class="mb-1">Nama Karyawan</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>
          <input type="text" id="tkar" name="tkar" class="form-control"
                 placeholder="Ketik nama karyawan..." autofocus autocomplete="off">
          <div class="input-group-append">
            <button class="btn btn-primary" id="btnCari" type="button">
              <i class="fas fa-search mr-1"></i>Cari
            </button>
          </div>
        </div>
        <small class="text-muted">Mulai ketik untuk melihat saran nama karyawan.</small>
      </div>
    </div>
  </div>
</div>

<?php if($tag==2): $no=1; ?>
<div class="card card-outline card-secondary">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-list mr-2"></i>Hasil Pencarian</h3>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0">
        <thead class="thead-light">
          <tr><th>No</th><th>Nama Karyawan</th></tr>
        </thead>
        <tbody>
          <?php foreach($dkr->result() as $k): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><a href="<?= base_url('page/ckary/'.$k->id_karyawan) ?>"><?= $k->nama_karyawan ?></a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
/* Employee data for autocomplete - no jQuery needed */
window._employees = <?= json_encode($karyawan_list) ?>;
window._ckarBase  = '<?= base_url('page/ckary/') ?>';
window._ckarxUrl  = '<?= base_url('page/ckarx') ?>';
</script>