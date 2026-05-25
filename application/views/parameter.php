<form action="<?php echo base_url();?>index.php/page/xtanggalmax" method="post">
	<label>Tanggal Max</label>
	<?php $tgl = $tglm->row(); ?>
	<input type="text" value="<?php echo $tgl->tanggalmax;?>" name="tglmax">
	<input type="submit" value="Ganti">
</form>