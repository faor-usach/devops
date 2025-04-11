<?php
	include_once("../inc/funciones.php");
?>	
<div class="row">
	<div class="col-6">
		<?php mCAMs(); ?>
	</div>
	<div class="col-1">
	</div>	
	<div class="col-5">
		<?php 
			//mRAMs($usrFiltro, $filtroCli);
		?>
	</div>		
</div>
<?php
function mCAMs(){?>
	<div class="row">
		<div class="col-2">
			CAM
		</div>
		<div class="col-2">
			Fecha
		</div>
		<div class="col-2">
			Clientes
		</div>
		<div class="col-2">
			Total
		</div>
		<div class="col-2">
			Validez
		</div>
	</div>
<?
}
?>
