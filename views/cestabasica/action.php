<?php
require_once '../../App/auth.php';
require_once '../../App/Models/cestas.class.php';

	if( isset( $_POST['status'])){

		$id = $_POST['id'];
		$value = $_POST['status'];
		$cestas->cestasAtivo($value, $id);

	}
	