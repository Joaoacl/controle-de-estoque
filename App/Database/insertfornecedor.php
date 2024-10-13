<?php
require_once '../auth.php';
require_once '../Models/fornecedor.class.php';
require_once '../Models/enderecos.class.php';

$enderecos = new Enderecos();

if(isset($_POST['upload']) == 'Cadastrar'){

$nomeFornecedor = trim($_POST['nomefornecedor']);
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$numConta = $_POST['numConta'];
$agencia = $_POST['agencia'];
$banco = $_POST['banco'];
$ativo = isset($_POST['ativo']) ? $_POST['ativo'] : 1;

$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];

//$iduser = $_POST['iduser'];

if ($nomeFornecedor != NULL) {

    if (isset($_POST['idfornecedor']) && !empty($_POST['idfornecedor'])) {
       
        $idfornecedor = $_POST['idfornecedor'];


        $queryEndereco = "SELECT endereco_idendereco FROM fornecedor WHERE idfornecedor = ?";
                    $stmtEndereco = $connect->SQL->prepare($queryEndereco);
                    $stmtEndereco->bind_param("i", $idfornecedor);
                    $stmtEndereco->execute();
                    $result = $stmtEndereco->get_result();
                    $row = $result->fetch_assoc();
                    $idendereco = $row['endereco_idendereco'];

                    // Atualizar endereço
                    $enderecos->updateEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $idendereco);

                    // Atualizar usuário
                    $fornecedor->UpdateFornecedor($idfornecedor, $nomeFornecedor, $telefone, $email, $numConta, $agencia, $banco, $ativo);

                    header('Location: ../../views/fornecedor/index.php?alert=update_sucesso'); // Sucesso no update
    } else {
        $enderecoId = $enderecos->InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep);
        if ($enderecoId) {
            $fornecedor->InsertFornecedor($nomeFornecedor, $telefone, $email, $numConta, $agencia, $banco, $enderecoId);
        } else {
            header('Location: ../../views/fornecedor/index.php?alert=erro_endereco'); // Erro ao inserir endereço
        }
    }
} else {
    header('Location: ../../views/fornecedor/index.php?alert=nome_nulo'); // Nome não pode ser nulo
}
} else {
header('Location: ../../views/fornecedor/index.php');
}