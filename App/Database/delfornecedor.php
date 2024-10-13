<?php
require_once '../auth.php';
require_once '../Models/fornecedor.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idfornecedor = $_POST['idfornecedor'];

    $fornecedor->deleteFornecedor($idfornecedor);



} else {
    header('Location: ../../views/fornecedor/index.php'); // 
}


?>