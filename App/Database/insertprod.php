<?php
require_once '../auth.php';
require_once '../Models/produto.class.php';

if(isset($_POST['upload']) == 'Cadastrar'){

    
$nomeProduto = $_POST['nomeproduto'];
$descricao = $_POST['descricaoproduto'];
$valor = $_POST['valorproduto'];
$quantidade = $_POST['quantidadeproduto'];

//$iduser = $_POST['iduser'];

if($nomeProduto != NULL){

if(isset($_POST['idproduto'])){

	$idproduto = $_POST['idproduto'];
	$produtos->updateProdutos($idproduto, $nomeProduto, $descricao, $valor, $quantidade);

}else{

	$produtos->InsertProdutos($nomeProduto, $descricao, $valor, $quantidade);
}



}else{
	header('Location: ../../views/produto/index.php?alert=3');
 }
}else{
	header('Location: ../../views/produto/index.php');
}