<?php
require_once '../auth.php';
require_once '../Models/venda.class.php';
require_once '../Models/log.class.php';

$vendas = new Vendas();
$log = new Log();

if (isset($_POST['idvenda'])) {
    $idvenda = $_POST['idvenda'];
    
    $vendas->cancelarVenda($idvenda);
    
    $log->registrar(
        'vendas',
        $username,
        'exclusão',
        'Venda ID: ' . $idvenda . ' foi cancelada.'
    );

    header('Location: ../../views/vendas/index.php?alert=venda_cancelada');
} else {
    header('Location: ../../views/vendas/index.php?alert=erro_cancelamento');
}
?>
