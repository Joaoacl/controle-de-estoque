<?php
require_once '../../App/Models/compra.class.php';
require_once '../../App/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idcompra'])) {
    $idCompra = $_POST['idcompra'];
    
    $compras = new Compras();
    if ($compras->concluirCompra($idCompra)) {
        header('Location: ../../views/compras/index.php?alert=concluido');
    } else {
        header('Location: ../../views/compras/index.php?alert=erro');
    }
}
?>
