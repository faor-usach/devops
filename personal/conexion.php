<?php 
	function Conectarse() 
		{
			if(!($link=mysql_connect("localhost","root","alf.artigas"))){
			//if(!($link=mysql_connect("localhost","simet_artigas","86382165.10074437"))){
				echo "Error cenexion.";
				exit();
			}
			if(!mysql_select_db("simet_laboratorio",$link)){
			//if(!mysql_select_db("simet_laboratorio",$link)){
				echo "Error seleccionando la Base de Datos.";
				exit();
			}
			return $link;
		}
		// $link = new mysqli('localhost', 'root', 'alf.artigas', 'simet_laboratorio');
		// 			$link->query("SET NAMES 'utf8'"); 
		// 			return $link;
?>

