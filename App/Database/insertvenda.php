<?php
require_once '../auth.php';
require_once '../Models/venda.class.php';
require_once '../Models/cestas.class.php';
require_once '../Models/usuario.class.php';

$vendas = new Vendas();
$cestas = new Cestas();

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    $idUsuario = $_POST['iduser'];
    $cliente = $_POST['codCli'];
    $valor_total = $_POST['valorTotal'];
    $data_venda = $_POST['dataVenda'];
    
    $cestasSelecionadas = json_decode($_POST['cestasSelecionadas'], true); // Decodifica o JSON com as cestas e quantidades

    if ($cliente != NULL) {
        if (isset($_POST['idvenda'])) {
            $idvenda = $_POST['idvenda'];
            $vendas->updateVenda($idvenda, $cliente, $data_venda, $valor_total, 1);
        } else {
            // Chamada para InsertVenda com a instância de $cestas
            $idvenda = $vendas->InsertVenda($cliente, $valor_total, $data_venda, $cestasSelecionadas, $cestas);

            if ($idvenda) {
                $usuario = new Usuario();
                $usuario->InsertUsuarioVendedor($idUsuario, $idvenda);

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
