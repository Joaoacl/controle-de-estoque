<?php
require_once '../auth.php';
require_once '../Models/produto.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $nomeProduto = $_POST['nomeproduto'];
    $descricao = $_POST['descricaoproduto'];
    $valor = $_POST['valorproduto'];
    $quantidade = $_POST['quantidadeproduto'];
    
    if ($nomeProduto != NULL) {
        
        if (isset($_POST['idproduto']) && !empty($_POST['idproduto'])) {
            
            $idproduto = $_POST['idproduto'];
            $produtos->updateProduto($idproduto, $nomeProduto, $valor, $quantidade, $descricao);
        
        } else {
            $produtos->InsertProdutos($nomeProduto, $descricao, $valor, $quantidade);
        }
    
    } else {
        header('Location: ../../views/produto/index.php?alert=3'); 
    }

} else {
    header('Location: ../../views/produto/index.php'); // 
}