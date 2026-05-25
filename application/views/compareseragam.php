<table>
<?php 
foreach($dt->result() as $k)
{
	
	echo "<tr><td>".$k->Nama."</td><td>".$k->periode."</td><td>".$k->Sizebaju."</td></tr>";
	
	
}

?>
</table>