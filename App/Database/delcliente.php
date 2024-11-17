<?php
require_once '../auth.php';
require_once '../Models/cliente.class.php';
require_once '../Models/log.class.php';

$clientes = new Clientes();
$log = new Log();

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idcliente = $_POST['idcliente'];

    $clientes->deleteCliente($idcliente);

    $log->registrar(
        'clientes',
        $username,
        'exclusão',
        "Cliente ID: $idcliente foi excluído"
    );

} else {
    header('Location: ../../views/usuarios/index.php'); // 
}


?>