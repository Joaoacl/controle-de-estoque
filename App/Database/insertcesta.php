<?php
require_once '../auth.php';
require_once '../Models/cestas.class.php';
require_once '../Models/produto.class.php';

if(isset($_POST['upload']) == 'Cadastrar'){

    
$nomeCesta = $_POST['nomecesta'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$categoriaCesta_idcategoriaCesta = $_POST['codCesta'];
$produtos = $_POST['produtos'] ?? [];

//$iduser = $_POST['iduser'];

if($nomeCesta != NULL){

if(isset($_POST['idcestaBasica'])){

	$idcestaBasica = $_POST['idcestaBasica'];
	$cestas->updateCestas($idcestaBasica, $nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta);

}else{

	$idcestaBasica = $cestas->InsertCestas($nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta);
	if ($idcestaBasica) {
		// Inserir produtos na cesta
		foreach ($produtos as $idProduto) {
			$cestas->insertProdutoNaCesta($idcestaBasica, $idProduto);
		}
		header('Location: ../../views/cestabasica/index.php?alert=1');
	} else {
		header('Location: ../../views/cestabasica/index.php?alert=0');
	}
}
} else {
header('Location: ../../views/cestabasica/index.php?alert=3');
}
} else {
header('Location: ../../views/cestabasica/index.php');
}