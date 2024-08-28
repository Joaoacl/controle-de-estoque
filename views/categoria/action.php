<?php
require_once '../../App/auth.php';
require_once '../../App/Models/categoria.class.php';

	if( isset( $_POST['status'])){

		$id = $_POST['id'];
		$value = $_POST['status'];
		$categorias->categoriaAtivo($value, $id);

	}
	