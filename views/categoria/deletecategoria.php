<?php
require_once '../../App/auth.php';
require_once '../../App/Models/categoria.class.php';

if (isset($_GET['id'])) {
    $idcategoriaCesta = $_GET['id'];

    if ($idcategoriaCesta != NULL) {
        $categorias->deleteCategoria($idcategoriaCesta);

        header('Location: ../../views/categoria/index.php?alert=1');
    } else {
        header('Location: ../../views/categoria/index.php?alert=2');
    }
} else {
    header('Location: ../../views/categoria/index.php?alert=2');
}
?>
