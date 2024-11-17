<?php
require_once '../auth.php';
require_once '../Models/compra.class.php';
require_once '../Models/produto.class.php';
require_once '../Models/log.class.php';

$log = new Log();

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

        $log->registrar(
            'compra',
            $username,
            'criação',
            "Compra ID: $idCompra criada com o fornecedor ID: $fornecedor"
        );

        header('Location: ../../views/compras/index.php?alert=compra_realizada');
    } else {
        header('Location: ../../views/compras/index.php?alert=erro');
    }
}
?>
