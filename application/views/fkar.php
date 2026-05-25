<?php 
if($tag==1){
	?>
<form name="fk" id="fk" method="post" action="ckarx">
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th colspan='3' align='center'>Cari Karyawan</th>
            </tr>
			<tr><td>Nama Karyawan</td><td><input type='text' name='tkar' autofocus></td><td><input type='submit' value='Cari'></td></tr>
        </thead>
	</table>
</div>
</form>
<?php }
if($tag==2){
	$no=1;
	?>
	<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th colspan='2'>Pilih Karyawan</th>
            </tr>
			<tr>
                <th>NO</th><th>Nama Karyawan</th>
            </tr>
		</thead>
		<?php
		foreach($dkr->result() as $k){
			
				?>	
				<tr><td><?php echo $no++;?></td><td><?php echo anchor(base_url()."index.php/page/ckary/".$k->id_karyawan,$k->nama_karyawan);?></td></tr>
				<?php
				
			} ?>
		
        
	</table>
	</div>
	
	
<?php } ?>