<?php
require_once '../../App/Models/compra.class.php';
require_once '../../App/auth.php';
require_once '../Models/log.class.php';

$log = new Log();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idcompra'])) {
    $idCompra = $_POST['idcompra'];
    
    $compras = new Compras();
    if ($compras->concluirCompra($idCompra)) {
        $log->registrar(
            'compra',
            $username,
            'conclusão',
            'Compra ID: ' . $idCompra . ' concluída com sucesso.'
        );
        header('Location: ../../views/compras/index.php?alert=concluido');
    } else {
        $log->registrar(
            'compra',
            $username,
            'erro',
            'Erro ao concluir a compra ID: ' . $idCompra
        );
        header('Location: ../../views/compras/index.php?alert=erro');
    }
}
?>
