<?php
require_once '../../App/auth.php';
require_once '../../App/Models/produto.class.php';

	if( isset( $_POST['status'])){

		$id = $_POST['id'];
		$value = $_POST['status'];
		$produtos->produtosAtivo($value, $id);

	}
	