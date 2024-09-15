<?php
require_once '../auth.php';
require_once '../Models/produto.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idProduto = $_POST['idproduto'];

    $produtos->deleteProduto($idProduto);



} else {
    header('Location: ../../views/produto/index.php'); // 
}


?>