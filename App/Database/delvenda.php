<?php
require_once '../auth.php';
require_once '../Models/venda.class.php';

$vendas = new Vendas;

if (isset($_POST['idvenda'])) {
    $idvenda = $_POST['idvenda'];
    $vendas->cancelarVenda($idvenda);
}
?>
