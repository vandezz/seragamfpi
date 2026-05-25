<?php
	$idkary = $kary->nama_karyawan;
?>
<div>Nama Karyawan :<h3><?php echo $idkary?></h3></div>
<div>
	<form action="<?=base_url();?>index.php/page/editseragamx" method="post">
		<table class="table">
			<input type="hidden" name="idseragam" value="<?=$dser->idseragam?>">
			<tr><td>Ukuran Baju</td><td><input type="text" name="sbaju" value="<?php echo $dser->size_baju;?>"></td></tr>
			<tr><td>Lengan</td><td><input type="text" name="lengan" value="<?php echo $dser->lengan;?>"></td></tr>
			<tr><td>Ukuran Celana</td><td><input type="text" name="scelana" value="<?php echo $dser->size_celana;?>"></td></tr>
			<tr><td>Keterangan</td><td><textarea name="tket"><?php echo $dser->keterangan;?></textarea></td></tr>
			<tr><td></td><td><input type="submit" value="Edit" class="btn btn-warning"></td></tr>
		</table>
	</form>
</div>