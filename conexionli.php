<?php 
	function Conectarse()
		{
			$link = new mysqli('localhost', 'root', 'alf.artigas', 'simet_laboratorio');
			$link->query("SET NAMES 'utf8'"); 
			return $link;
		}
?>