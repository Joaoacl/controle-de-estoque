<?php
require_once '../auth.php';
require_once '../Models/cliente.class.php';

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idcliente = $_POST['idcliente'];

    $clientes->deleteCliente($idcliente);



} else {
    header('Location: ../../views/usuarios/index.php'); // 
}


?>