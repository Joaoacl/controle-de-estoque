<?php
require_once '../auth.php';
require_once '../Models/venda.class.php';
require_once '../Models/cestas.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    $idCesta = $_POST['codCesta'];
    $cliente = $_POST['codCli'];
    $valor_total = $_POST['valorTotal'];
    $data_venda = $_POST['dataVenda'];
    
    
    if ($cliente != NULL) {
        if (isset($_POST['idvenda'])) {
            $idvenda = $_POST['idvenda'];
            $vendas->updateVenda($idvenda, $idCesta, $cliente, $valor_total, $data);
        } else {
            $idvenda = $vendas->InsertVenda($cliente, $valor_total, $data_venda, $idCesta);
            if ($idvenda) {

                $cestas->InsertCestaVendida($idCesta, $idvenda, $data_venda);            

                header('Location: ../../views/vendas/index.php?alert=venda_realizada');
            } else {
                header('Location: ../../views/vendas/index.php?alert=estoque_insuficiente');
            }
        }
    } else {
        header('Location: ../../views/vendas/index.php?alert=3');
    }
} else {
    header('Location: ../../views/vendas/index.php');
}
?>
