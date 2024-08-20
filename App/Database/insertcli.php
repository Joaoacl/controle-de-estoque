<?php
require_once '../auth.php';
require_once '../Models/cliente.class.php';
require_once '../Models/enderecos.class.php';

$enderecos = new Enderecos();

if(isset($_POST['upload']) == 'Cadastrar'){

$nome = $_POST['nomecliente'];
$cpf = $_POST['cpf'];
$desconto = $_POST['desconto'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];

//$iduser = $_POST['iduser'];

if ($nome != NULL) {
    $enderecoId = $enderecos->InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep);
    if ($enderecoId) {
        $clientes->InsertCliente($nome, $cpf, $desconto, $email, $telefone, $enderecoId);
    } else {
        header('Location: ../../views/clientes/index.php?alert=0'); // Erro ao inserir endereço
    }
} else {
    header('Location: ../../views/clientes/index.php?alert=0'); // Nome não pode ser nulo
}
} else {
header('Location: ../../views/clientes/index.php');
}