<?php 
	function ConectarseCert()
		{
			$linkc = new mysqli('localhost', 'root', 'alf.artigas', 'certificados');
			$linkc->query("SET NAMES 'utf8'");
			return $linkc;
		}
?>