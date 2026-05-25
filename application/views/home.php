<h3 style="margin-top: 0;">
    <small>Selamat datang</small>
    <br />
    <?php echo $this->session->userdata('nama') ?>
	
</h3>
<hr />


<div>
Segera ganti Password Anda jika password masih standar! <a href="<?php echo base_url();?>index.php/page/gantipassword"><input type="button" class="btn btn-warning" value="Ganti Password"></a>


	<a href="#statistik"><button class="btn btn-info" value="Data Ukuran">Data Ukuran</a>
</div>

<?php if(!empty($dt))
{
?>
<div class="table-responsive">
<table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th colspan='5'>Seragam Yang sudah dipilih</th>
                
            </tr>
        </thead>
        <tbody>
		<tr>
			<td>Ukuran Baju</td>
			<td>
			<?php
				foreach($dt as $j)
					{
						echo $j->size_baju;
					}
				?>
			</td>
			
		</tr>
		<tr>
			<td>Lengan</td>
			<td>
				<?php
				foreach($dt as $j)
					{
						echo $j->lengan;
					}
				?>
			</td>
		</tr>
		<tr>
			<td>Ukuran Celana</td>
			<td>
			<?php
				foreach($dt as $j)
					{
						echo $j->size_celana;
					}
				?>
			</td>
			
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>
			<?php
				foreach($dt as $j)
					{
						echo $j->keterangan;
					}
				?>
			</td>
			
		</tr>
		
		<tr><td>Last Change</td><td><?php echo $j->waktu;?></td></tr>
		<tr><td><a href="<?php echo base_url();?>index.php/page/berita/"><input type="button" value="Edit"></td></tr></a>
		</tbody>
</table>
</div>
<?php 
}
else
{
	?>
	<div class="table-responsive">
	<table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th style="text-color:red;" colspan='5'><h1 style="color:Tomato;">Anda belum mengisi Ukuran Seragam</h1></th>
                
            </tr>
			
        </thead>
		</table>
	</div>
	
	<div class="pull-center">
    <a href="<?php echo base_url('index.php/page/berita'); ?>" class="btn btn-success">Isi Form Seragam</a>
</div>
<?php	
}
?>
<p>
<!-- Data Tahun Lalu -->
<div class="table-responsive">
<table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th colspan='5'><h2 style="color:#8E44AD" id="tahunlalu">Seragam Tahun Lalu [Tahun <?php echo date('Y')-1;?>]</h2></th>
                
            </tr>
        </thead>
        <tbody>
		<tr>
			<td>Ukuran Baju</td>
			<td>
			<?php
				foreach($dtk as $jk)
					{
						echo $jk->size_baju;
					}
				?>
			</td>
			
		</tr>
		<tr>
			<td>Lengan</td>
			<td>
				<?php
				foreach($dtk as $jk)
					{
						echo $jk->lengan;
					}
				?>
			</td>
		</tr>
		<tr>
			<td>Ukuran Celana</td>
			<td>
			<?php
				foreach($dtk as $jk)
					{
						echo $jk->size_celana;
					}
				?>
			</td>
			
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>
			<?php
				foreach($dtk as $jk)
					{
						echo $jk->keterangan;
					}
				?>
			</td>
			
		</tr>
		
		<tr><td>Last Change</td><td><?php //echo $jk->waktu;?></td></tr>
		<!-- <tr><td><a href="<?php echo base_url();?>index.php/page/berita/"><input type="button" value="Edit"></td></tr></a> -->
		</tbody>
</table>
</div>
</p>
<div><h3>HISTORY UKURAN SERAGAM</h3></div>
<p id="statistik">
	<div>
		<table class="table table-bordered table-hover">
			<tr><td>NO</td><td>PERIODE</td><td>UKURAN BAJU</td><td>LENGAN</td><td>UKURAN CELANA</td></tr>
			
			<?php 
			$nom=1;
			foreach($sejarah->result() as $h)
			{
				echo "<tr><td>".$nom."</td><td>".$h->periode."</td><td>".$h->size_baju."</td><td>".$h->lengan."</td><td>".$h->size_celana."</td></tr>";
				
				$nom++;
			}
			?>
		</table>
	</div>
</p>