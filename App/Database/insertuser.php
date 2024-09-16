<?php
require_once '../auth.php';
require_once '../Models/usuario.class.php';
require_once '../Models/enderecos.class.php';

$enderecos = new Enderecos();

if(isset($_POST['upload']) && $_POST['upload'] === 'Cadastrar'){

    // Dados do usuário
    $username = $_POST['username'];
    $cpf = $_POST['cpf'];
    $salario = $_POST['salario'];
    $cargo = $_POST['cargo'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Senha criptografada
    $telefone = $_POST['telefone'];
    $permissao = $_POST['permissao'];
    
    // Endereço
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    
    // Verificação de campos obrigatórios
    if ($username != NULL && $senha != NULL && $email != NULL) {
        // Inserir endereço primeiro
        $enderecoId = $enderecos->InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep);
        if ($enderecoId) {
            // Inserir usuário com o ID do endereço
            $usuario->InsertUsuario($username, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $enderecoId);
            header('Location: ../../views/usuarios/index.php?alert=1'); // Sucesso
        } else {
            header('Location: ../../views/usuarios/index.php?alert=0'); // Erro ao inserir endereço
        }
    } else {
        header('Location: ../../views/usuarios/index.php?alert=0'); // Campos obrigatórios faltando
    }
} else {
    header('Location: ../../views/usuarios/index.php');
}
