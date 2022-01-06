<?php
	require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');

	$conexion=mysqli_connect("localhost","root","","prueba_tecnica_dev");
	mysqli_set_charset($conexion,'utf8');
?>