<h3>My Profile</h3>
<br>


<h2 style="margin-top: 0;margin-bottom: 0;"><?php echo $k->nama_karyawan;?></h2>
<div class="clearfix"></div>
<hr />

<div class="table-responsive">
    <table class="table table-bordered table-hover">
       
        <tbody>
            <tr>
                <td>Your Name</td>
                <td><?=$k->nama_karyawan;?></td>
                <td>x</td>
                <td>x</td>
               
            </tr>
            <tr>
                <td>Alamat</td>
                 <td><?=$k->alamat,", ".$k->kota;?></td>
                <td>x</td>
                <td>x</td>
                
            </tr>
			<tr>
                <td>Tempat, tanggal lahir</td>
                 <td><?=$k->tmp_lahir.", ".$k->tgl_lahir;?></td>
                <td>x</td>
                <td>x</td>
                
            </tr>
        </tbody>
    </table>
</div>