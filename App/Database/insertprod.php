<?php
require_once '../auth.php';
require_once '../Models/produto.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $nomeProduto = trim($_POST['nomeproduto']);
    $descricao = trim($_POST['descricaoproduto']);
    $valor = $_POST['valorproduto'];
    $quantidade = $_POST['quantidadeproduto'];
    $ativo = isset($_POST['ativo']) ? $_POST['ativo'] : 1;
    
    if ($nomeProduto != NULL) {
        
        if (isset($_POST['idproduto']) && !empty($_POST['idproduto'])) {
            
            $idproduto = $_POST['idproduto'];
            $produtos->updateProduto($idproduto, $nomeProduto, $valor, $quantidade, $descricao, $ativo);

        
        } else {
            $produtos->InsertProdutos($nomeProduto, $descricao, $valor, $quantidade, $ativo);
        }
    
    } else {
        header('Location: ../../views/produto/index.php?alert=3'); 
    }

} else {
    header('Location: ../../views/produto/index.php'); // 
}
