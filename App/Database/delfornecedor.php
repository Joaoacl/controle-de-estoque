<?php
require_once '../auth.php';
require_once '../Models/fornecedor.class.php';
require_once '../Models/log.class.php';

$log = new Log();

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idfornecedor = $_POST['idfornecedor'];

    $fornecedor->deleteFornecedor($idfornecedor);

    $log->registrar(
        'fornecedor',
        $username,
        'exclusão',
        "Fornecedor ID: $idfornecedor excluído - Nome: $nomeFornecedor"
    );


} else {
    header('Location: ../../views/fornecedor/index.php'); // 
}


?>