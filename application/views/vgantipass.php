<?php 
$data = $this->session->userdata(); ?>

      
        <br><br>
            <h1 style="color: #3399ff;">Hai <?= $data['nama']; ?></h1>
        <br>
		Ganti Password Anda sekarang:
		</br>
        <form action="<?= base_url('index.php/page/gantipasswordx'); ?>" method="POST">
            <hr>

            <br><br>

           <!-- <input type="password" name="pw_lama" class="inputan" placeholder="password lama" autofocus> <br><br> -->
			 <?php // form_error('pw_lama'); ?>
            <input type="password" name="pw_baru"  class="inputan" placeholder="password baru" autofocus>    <br>
            <?= form_error('pw_baru'); ?>

            <br>

            <input type="password" name="cpw_baru"  class="inputan" placeholder="ulangi password baru">  <br>
            <?= form_error('cpw_baru'); ?>

            <br>

            <input type="submit" name="submit" value="Ganti Password">
        </form>