<div class="row">

  <!-- Welcome Card -->
  <div class="col-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-user-circle mr-2"></i>
          Selamat datang, <strong><?php echo $this->session->userdata('nama'); ?></strong>
        </h3>
      </div>
      <div class="card-body">
        <a href="<?php echo base_url();?>index.php/page/gantipassword" class="btn btn-warning btn-sm mr-2 mb-2">
          <i class="fas fa-key mr-1"></i> Ganti Password
        </a>
        <a href="#statistik" class="btn btn-info btn-sm mb-2">
          <i class="fas fa-history mr-1"></i> History Ukuran
        </a>
      </div>
    </div>
  </div>

  <!-- Seragam Tahun Ini -->
  <div class="col-12">
    <div class="card card-success card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-tshirt mr-2"></i>Seragam Tahun Ini (<?php echo date('Y'); ?>)
        </h3>
      </div>
      <?php if(!empty($dt)): ?>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0">
            <tbody>
              <tr>
                <td width="40%"><strong>Ukuran Baju</strong></td>
                <td><?php foreach($dt as $j){ echo $j->size_baju; } ?></td>
              </tr>
              <tr>
                <td><strong>Lengan</strong></td>
                <td><?php foreach($dt as $j){ echo $j->lengan; } ?></td>
              </tr>
              <tr>
                <td><strong>Ukuran Celana</strong></td>
                <td><?php foreach($dt as $j){ echo $j->size_celana; } ?></td>
              </tr>
              <tr>
                <td><strong>Keterangan</strong></td>
                <td><?php foreach($dt as $j){ echo $j->keterangan; } ?></td>
              </tr>
              <tr>
                <td><strong>Last Update</strong></td>
                <td><?php echo $j->waktu; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <a href="<?php echo base_url();?>index.php/page/berita/" class="btn btn-primary btn-sm">
          <i class="fas fa-edit mr-1"></i> Edit Ukuran
        </a>
      </div>
      <?php else: ?>
      <div class="card-body text-center py-4">
        <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
        <h5 class="text-danger">Anda belum mengisi Ukuran Seragam</h5>
        <a href="<?php echo base_url('index.php/page/berita'); ?>" class="btn btn-success mt-2">
          <i class="fas fa-plus-circle mr-1"></i> Isi Form Seragam
        </a>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Seragam Tahun Lalu -->
  <div class="col-12">
    <div class="card card-secondary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-archive mr-2"></i>Seragam Tahun Lalu (<?php echo date('Y')-1; ?>)
        </h3>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0">
            <tbody>
              <tr>
                <td width="40%"><strong>Ukuran Baju</strong></td>
                <td><?php foreach($dtk as $jk){ echo $jk->size_baju; } ?></td>
              </tr>
              <tr>
                <td><strong>Lengan</strong></td>
                <td><?php foreach($dtk as $jk){ echo $jk->lengan; } ?></td>
              </tr>
              <tr>
                <td><strong>Ukuran Celana</strong></td>
                <td><?php foreach($dtk as $jk){ echo $jk->size_celana; } ?></td>
              </tr>
              <tr>
                <td><strong>Keterangan</strong></td>
                <td><?php foreach($dtk as $jk){ echo $jk->keterangan; } ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- History Ukuran -->
  <div class="col-12" id="statistik">
    <div class="card card-info card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history mr-2"></i>History Ukuran Seragam</h3>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Periode</th>
                <th>Ukuran Baju</th>
                <th>Lengan</th>
                <th>Ukuran Celana</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $nom = 1;
              foreach($sejarah->result() as $h) {
                echo "<tr><td>{$nom}</td><td>{$h->periode}</td><td>{$h->size_baju}</td><td>{$h->lengan}</td><td>{$h->size_celana}</td></tr>";
                $nom++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
