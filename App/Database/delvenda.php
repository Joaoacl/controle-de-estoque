<?php
require_once '../auth.php';
require_once '../Models/venda.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idvenda = $_POST['idvenda'];

    $vendas->deleteVenda($idvenda);



} else {
    header('Location: ../../views/produto/index.php'); // 
}


?>