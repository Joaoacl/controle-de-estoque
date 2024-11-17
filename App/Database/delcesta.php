<?php
require_once '../auth.php';
require_once '../Models/cestas.class.php';
require_once '../Models/log.class.php';

$log = new Log();

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idcestaBasica = $_POST['idcestaBasica'];

    $cestas->deleteCestas($idcestaBasica);

    $log->registrar(
        'cestas',
        $username,
        'exclusão',
        "Cesta ID: $idcestaBasica foi excluída"
    );

} else {
    header('Location: ../../views/cestabasica/index.php'); // 
}


?>