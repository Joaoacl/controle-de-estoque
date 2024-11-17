<?php
require_once '../auth.php';
require_once '../Models/produto.class.php';
require_once '../Models/log.class.php'; 

$produtos = new Produtos();
$log = new Log();

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $nomeProduto = trim($_POST['nomeproduto']);
    $descricao = trim($_POST['descricaoproduto']);
    $valor = $_POST['valorproduto'];
    $quantidade = $_POST['quantidadeproduto'];
    $quantidade_minima = $_POST['quantidademinima'];
    $ativo = isset($_POST['ativo']) ? $_POST['ativo'] : 1;
    $idUsuario = $_POST['iduser'];
    
    if ($nomeProduto != NULL) {
        
        if (isset($_POST['idproduto']) && !empty($_POST['idproduto'])) {
        
            $idproduto = $_POST['idproduto'];
            $produtos->updateProduto($idproduto, $nomeProduto, $valor, $quantidade, $quantidade_minima, $descricao, $ativo);
            
            
            $log->registrar(
                'produto',
                $username,
                'atualização',
                "Produto ID: $idproduto atualizado - Nome: $nomeProduto"
            );

            header('Location: ../../views/produto/index.php?alert=update_sucesso');
        } else {
          
            $produtos->InsertProdutos($nomeProduto, $descricao, $valor, $quantidade, $quantidade_minima, $ativo);
            
           
                $log->registrar(
                    'produto',
                    $username,
                    'criação',
                    "Novo produto criado - Nome: $nomeProduto"
                );
                header('Location: ../../views/produto/index.php?alert=insert_sucesso');
            
        }
    } else {
        header('Location: ../../views/produto/index.php?alert=nome_nulo');
    }
} else {
    header('Location: ../../views/produto/index.php');
}
?>
