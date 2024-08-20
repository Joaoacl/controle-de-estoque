<?php
require_once '../auth.php';
require_once '../Models/categoria.class.php';

if (isset($_POST['upload'])) {
    $nomeCategoria = $_POST['nomecategoria'];
    $idcategoriaCesta = isset($_POST['idcategoriaCesta']) ? $_POST['idcategoriaCesta'] : null;
    $iduser = $_POST['iduser'];

    if ($nomeCategoria != NULL) {
        if ($idcategoriaCesta) {
            // Atualiza a categoria existente
            $categorias->updateCategoria($idcategoriaCesta, $nomeCategoria);
        } else {
            // adiciona nova categoria
            $categorias->InsertCategoria($nomeCategoria);
        }
    } else {
        header('Location: ../../views/categoria/index.php?alert=0');
    }
} else {
    header('Location: ../../views/categoria/index.php');
}
?>
