<?php
require_once '../auth.php';
require_once '../Models/cliente.class.php';
require_once '../Models/enderecos.class.php';

$enderecos = new Enderecos();

if(isset($_POST['upload']) == 'Cadastrar'){

$nome = trim($_POST['nomecliente']);
$cpf = $_POST['cpf'];
$desconto = isset($_POST['desconto']) && !empty($_POST['desconto']) ? $_POST['desconto'] : 0;
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$ativo = $_POST['ativo'];

$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];

//$iduser = $_POST['iduser'];

if ($nome != NULL) {

    if (isset($_POST['idcliente']) && !empty($_POST['idcliente'])) {
       
        $idcliente = $_POST['idcliente'];


        $queryEndereco = "SELECT endereco_idendereco FROM cliente WHERE idcliente = ?";
                    $stmtEndereco = $connect->SQL->prepare($queryEndereco);
                    $stmtEndereco->bind_param("i", $idcliente);
                    $stmtEndereco->execute();
                    $result = $stmtEndereco->get_result();
                    $row = $result->fetch_assoc();
                    $idendereco = $row['endereco_idendereco'];

                    // Atualizar endereço
                    $enderecos->updateEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $idendereco);

                    // Atualizar usuário
                    $clientes->UpdateCliente($idcliente, $nome, $cpf, $desconto, $email, $telefone, $ativo);

                    header('Location: ../../views/clientes/index.php?alert=update_sucesso'); // Sucesso no update
    } else {
        $enderecoId = $enderecos->InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep);
        if ($enderecoId) {
            $clientes->InsertCliente($nome, $cpf, $desconto, $email, $telefone, $enderecoId);
        } else {
            header('Location: ../../views/clientes/index.php?alert=erro_endereco'); // Erro ao inserir endereço
        }
    }
} else {
    header('Location: ../../views/clientes/index.php?alert=nome_nulo'); // Nome não pode ser nulo
}
} else {
header('Location: ../../views/clientes/index.php');
}