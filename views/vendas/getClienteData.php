<?php
require_once '../../App/Models/connect.php';
require_once '../../App/Models/cliente.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCliente'])) {
    $idcliente = $_POST['idCliente'];
    $clientes = new Clientes();
    $clienteData = $clientes->editCliente($idcliente);
    
    if ($clienteData) {
        echo json_encode([
            'desconto' => $clienteData['Cliente']['desconto']
        ]);
    } else {
        echo json_encode([
            'desconto' => 0
        ]);
    }
}
?>
