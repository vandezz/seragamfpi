<li class="nav-item">
  <a href="<?php echo base_url('page/home'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'home') ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-home"></i>
    <p>Home</p>
  </a>
</li>
<li class="nav-item">
  <a href="<?php echo base_url('page/berita'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'berita') ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-tshirt"></i>
    <p>Isi Form Seragam</p>
  </a>
</li>
<li class="nav-item">
  <a href="<?php echo base_url('page/gantipassword'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'gantipassword') ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-key"></i>
    <p>Ganti Password</p>
  </a>
</li>
<?php if($this->session->userdata('role') == '1'): ?>
<li class="nav-header">ADMIN</li>
<li class="nav-item">
  <a href="<?php echo base_url('page/pengguna'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'pengguna') ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-users-cog"></i>
    <p>Manajemen Seragam</p>
  </a>
</li>
<li class="nav-item">
  <a href="<?php echo base_url('page/ckar'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'ckar') ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-search"></i>
    <p>Cari Karyawan</p>
  </a>
</li>
<li class="nav-item">
  <a href="<?php echo base_url('page/laporan'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'laporan') ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-chart-bar"></i>
    <p>Laporan</p>
  </a>
</li>
<li class="nav-item">
  <a href="<?php echo base_url('page/chatAdmin'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'chatAdmin') ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-comments"></i>
    <p>Chat Karyawan</p>
  </a>
</li>
<li class="nav-item">
  <a href="<?php echo base_url('page/mKaryawan'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'mKaryawan') ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-user-cog"></i>
    <p>Manajemen Karyawan</p>
  </a>
</li>
<?php endif; ?>
<li class="nav-item mt-2">
  <a href="<?php echo base_url('auth/logout'); ?>" class="nav-link">
    <i class="nav-icon fas fa-sign-out-alt"></i>
    <p>Logout</p>
  </a>
</li>