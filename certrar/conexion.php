<?php 
	function Conectarse()
		{
			if (!($link=mysql_connect("localhost","root",""))){
			//if (!($link=mysql_connect("localhost","root","alf.artigas"))){
				echo "Error cenexion.";
				exit();
			}
			if (!mysql_select_db("simet_laboratorio",$link)){
			//if (!mysql_select_db("simet_laboratorio",$link)){
				echo "Error seleccionando la Base de Datos.";
				exit();
			}
			return $link;
		}
?>