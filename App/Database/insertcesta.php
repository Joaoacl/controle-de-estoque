<?php
require_once '../auth.php';
require_once '../Models/cestas.class.php';
require_once '../Models/produto.class.php';
require_once '../Models/log.class.php';

$log = new Log();

if(isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {

    $nomeCesta = trim($_POST['nomecesta']);
    $descricao = trim($_POST['descricao']);
    $valor = $_POST['valor'];
    $categoriaCesta_idcategoriaCesta = $_POST['codCesta'];
    $produtos = $_POST['produtos'] ?? []; 
    $quantidades = $_POST['quantidade'] ?? []; 
    $ativo = isset($_POST['ativo']) ? $_POST['ativo'] : 1;

    if ($nomeCesta != NULL) {

        if (isset($_POST['idcestaBasica'])) {
            $idcestaBasica = $_POST['idcestaBasica'];
            $cestas->updateCestas($idcestaBasica, $nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta, $produtos, $quantidades, $ativo);

            $log->registrar(
                'cestas',
                $username,
                'atualização',
                "Cesta ID: $idcestaBasica atualizada - Nome: $nomeCesta"
            );
        } else {
            // Inserir a cesta
            $idcestaBasica = $cestas->InsertCestas($nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta, $ativo);
            
            if ($idcestaBasica) {
                // Inserir produtos na cesta com a quantidade
                foreach ($produtos as $idProduto) {
                    $quantidade = isset($quantidades[$idProduto]) ? $quantidades[$idProduto] : 1; // Pega a quantidade do produto ou define 1 por padrão
                    $cestas->insertProdutoNaCesta($idcestaBasica, $idProduto, $quantidade);
                }

                $log->registrar(
                    'cestas',
                    $username,
                    'criação',
                    "Cesta ID: $idcestaBasica criada - Nome: $nomeCesta"
                );
                header('Location: ../../views/cestabasica/index.php?alert=1');
            } else {
                header('Location: ../../views/cestabasica/index.php?alert=0');
            }
        }
    } else {
        header('Location: ../../views/cestabasica/index.php?alert=3');
    }
} else {
    header('Location: ../../views/cestabasica/index.php');
}
