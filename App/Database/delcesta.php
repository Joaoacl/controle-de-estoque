<?php
require_once '../auth.php';
require_once '../Models/cestas.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idcestaBasica = $_POST['idcestaBasica'];

    $cestas->deleteCestas($idcestaBasica);

} else {
    header('Location: ../../views/cestabasica/index.php'); // 
}


?>