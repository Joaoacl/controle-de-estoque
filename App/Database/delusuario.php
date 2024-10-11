<?php
require_once '../auth.php';
require_once '../Models/usuario.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idusuario = $_POST['idusuario'];

    $usuario->deleteUsuario($idusuario);



} else {
    header('Location: ../../views/usuarios/index.php'); // 
}


?>