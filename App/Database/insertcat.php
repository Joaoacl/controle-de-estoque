<?php
require_once '../auth.php';
require_once '../Models/categoria.class.php';

if (isset($_POST['upload'])) {
    $nomeCategoria = $_POST['nomecategoria'];
    $idcategoriaCesta = isset($_POST['idcategoriaCesta']) ? $_POST['idcategoriaCesta'] : null;
    $ativo = isset($_POST['ativo']) ? $_POST['ativo'] : 1;


    $iduser = $_POST['iduser'];

    if ($nomeCategoria != NULL) {
        if ($idcategoriaCesta) {
            // Atualiza a categoria existente
            $categorias->updateCategoria($idcategoriaCesta, $nomeCategoria, $ativo);
        } else {
            // adiciona nova categoria
            $categorias->InsertCategoria($nomeCategoria, $ativo);
        }
    } else {
        header('Location: ../../views/categoria/index.php?alert=0');
    }
} else {
    header('Location: ../../views/categoria/index.php');
}
?>
