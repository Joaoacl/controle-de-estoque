<?php
require_once '../auth.php';
require_once '../Models/compra.class.php';
require_once '../Models/log.class.php';

$log = new Log();

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idcompra = $_POST['idcompra'];

    $compras->deleteCompra($idcompra);

    $log->registrar(
        'compra',
        $username,
        'exclusão',
        "Compra ID: $idcompra foi cancelada"
    );

} else {
    header('Location: ../../views/compras/index.php'); // 
}


?>