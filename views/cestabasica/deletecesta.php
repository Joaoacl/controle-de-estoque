<?php
require_once '../../App/auth.php';
require_once '../../App/Models/cestas.class.php';

if (isset($_GET['id'])) {
    $idcestaBasica = $_GET['id'];

    if ($idcestaBasica != NULL) {
        $cestas->deleteCestas($idcestaBasica);

        header('Location: ../../views/cestabasica/index.php?alert=1');
    } else {
        header('Location: ../../views/cestabasica/index.php?alert=2');
    }
} else {
    header('Location: ../../views/cestabasica/index.php?alert=2');
}
?>
