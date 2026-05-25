<div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">PT. Fuji Presisi-Tool Indonesia</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url('index.php/page/home'); ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/page/berita'); ?>">Isi Form</a></li>

            <?php
            // Cek role user
            if($this->session->userdata('role') == '1'){ // Jika role-nya admin
                ?>
                <li><a href="<?php echo base_url('index.php/page/pengguna'); ?>">Admin</a></li>
				<li><a href="<?php echo base_url('index.php/page/ckar'); ?>">Cari Karyawan</a></li>
				<li><a href="<?php // echo base_url('index.php/page/pengguna'); ?>"><!-- Users--></a></li>
                <?php
            }
            ?>

            <li><a href="<?php // echo base_url('index.php/page/kontak'); ?>"><!-- Profile --></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo base_url('index.php/auth/logout'); ?>">Logout</a></li>
        </ul>
    </div><!--/.nav-collapse -->
</div>