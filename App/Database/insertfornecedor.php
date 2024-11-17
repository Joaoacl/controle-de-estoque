<?php
require_once '../auth.php';
require_once '../Models/fornecedor.class.php';
require_once '../Models/enderecos.class.php';
require_once '../Models/log.class.php';

$enderecos = new Enderecos();
$log = new Log();

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

                    
                    $enderecos->updateEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $idendereco);

                    
                    $fornecedor->UpdateFornecedor($idfornecedor, $nomeFornecedor, $telefone, $email, $numConta, $agencia, $banco, $ativo);

                    $log->registrar(
                        'fornecedor',
                        $username,
                        'atualização',
                        "Fornecedor ID: $idfornecedor atualizado - Nome: $nomeFornecedor"
                    );

                    header('Location: ../../views/fornecedor/index.php?alert=update_sucesso'); 
    } else {
        $enderecoId = $enderecos->InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep);
        if ($enderecoId) {
            $fornecedor->InsertFornecedor($nomeFornecedor, $telefone, $email, $numConta, $agencia, $banco, $enderecoId);

            $log->registrar(
                'fornecedor',
                $username,
                'criação',
                "Novo fornecedor criado - Nome: $nomeFornecedor"
            );
            header('Location: ../../views/fornecedor/index.php?alert=insert_sucesso');

        } else {
            header('Location: ../../views/fornecedor/index.php?alert=erro_endereco'); 
        }
    }
} else {
    header('Location: ../../views/fornecedor/index.php?alert=nome_nulo'); 
}
} else {
header('Location: ../../views/fornecedor/index.php');
}