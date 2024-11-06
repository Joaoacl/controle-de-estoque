<?php
require_once '../auth.php';
require_once '../Models/compra.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idcompra = $_POST['idcompra'];

    $compras->deleteCompra($idcompra);

} else {
    header('Location: ../../views/compras/index.php'); // 
}


?>