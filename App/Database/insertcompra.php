<?php
require_once '../auth.php';
require_once '../Models/compra.class.php';
require_once '../Models/produto.class.php';

if (isset($_POST['submit'])) {
    $fornecedor = $_POST['codFornecedor'];
    $produtosSelecionados = json_decode($_POST['produtosSelecionados'], true);

    if ($fornecedor != NULL && !empty($produtosSelecionados)) {
        $idCompra = $compras->insertCompra($fornecedor);

        foreach ($produtosSelecionados as $produto) {
            $idProduto = $produto['id'];
            $quantidade = $produto['quantidade'];
            $compras->insertProdutoCompra($idCompra, $idProduto, $quantidade);
        }

        header('Location: ../../views/compras/index.php?alert=compra_realizada');
    } else {
        header('Location: ../../views/compras/index.php?alert=erro');
    }
}
?>
