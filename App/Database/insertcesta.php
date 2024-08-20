<?php
require_once '../auth.php';
require_once '../Models/cestas.class.php';

if(isset($_POST['upload']) == 'Cadastrar'){

    
$nomeCesta = $_POST['nomecesta'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$categoriaCesta_idcategoriaCesta = $_POST['codCesta'];

//$iduser = $_POST['iduser'];

if($nomeCesta != NULL){

if(isset($_POST['idcestaBasica'])){

	$idcestaBasica = $_POST['idcestaBasica'];
	$cestas->updateCestas($idcestaBasica, $nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta);
}else{
$cestas->InsertCestas($nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta);
}



}else{
	header('Location: ../../views/cestabasica/index.php?alert=3');
 }
}else{
	header('Location: ../../views/cestabasica/index.php');
}