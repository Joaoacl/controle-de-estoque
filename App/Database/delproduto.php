<?php
require_once '../auth.php';
require_once '../Models/produto.class.php';
require_once '../Models/log.class.php';

$produtos = new Produtos();
$log = new Log();

if (isset($_POST['idproduto'])) {
    $idproduto = $_POST['idproduto'];
    $nomeProduto = $produtos->getNomeProduto($idproduto);

    
    $produtos->deleteProduto($idproduto);

    
    $log->registrar(
        'produto',
        $username,
        'exclusão',
        "Produto ID: $idproduto excluído - Nome: $nomeProduto"
    );

    header('Location: ../../views/produto/index.php?alert=delete_sucesso');
} else {
    header('Location: ../../views/produto/index.php?alert=erro_exclusao');
}
?>
