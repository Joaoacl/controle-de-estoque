<?php
require_once '../auth.php';
require_once '../Models/categoria.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idcategoriaCesta = $_POST['idcategoriaCesta'];

    $categorias->deleteCategoria($idcategoriaCesta);



} else {
    header('Location: ../../views/categoria/index.php'); // 
}


?>