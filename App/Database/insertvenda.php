<?php
require_once '../auth.php';
require_once '../Models/venda.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    $cliente = trim($_POST['cliente']);
    $data = $_POST['data'];
    $valor_total = $_POST['valor_total'];
    $ativo = isset($_POST['ativo']) ? $_POST['ativo'] : 1;

    if ($cliente != NULL) {
        if (isset($_POST['idvenda'])) {
            $idvenda = $_POST['idvenda'];
            $vendas->updateVenda($idvenda, $cliente, $data, $valor_total, $ativo);
        } else {
            $idvenda = $vendas->InsertVenda($cliente, $data, $valor_total, $ativo);
            if ($idvenda) {
                header('Location: ../../views/vendas/index.php?alert=1');
            } else {
                header('Location: ../../views/vendas/index.php?alert=0');
            }
        }
    } else {
        header('Location: ../../views/vendas/index.php?alert=3');
    }
} else {
    header('Location: ../../views/vendas/index.php');
}
?>
