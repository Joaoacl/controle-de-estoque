<?php
require_once '../auth.php';
require_once '../Models/categoria.class.php';
require_once '../Models/log.class.php';

$log = new Log();

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idcategoriaCesta = $_POST['idcategoriaCesta'];

    $categorias->deleteCategoria($idcategoriaCesta);

    $log->registrar(
        'categoria',
        $username,
        'exclusão',
        "Categoria ID: $idcategoriaCesta foi excluída"
    );

} else {
    header('Location: ../../views/categoria/index.php'); // 
}


?>