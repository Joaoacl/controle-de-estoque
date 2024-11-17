<?php
session_start();
require_once '../auth.php';
require_once '../Models/usuario.class.php';
require_once '../Models/enderecos.class.php';
require_once '../Models/connect.php';
require_once '../Models/log.class.php';

$enderecos = new Enderecos();
$connect = new Connect();
$log = new Log();

$idusuario = $_POST['idusuario'] ?? null;
$isEditing = !empty($idusuario);


$_SESSION['erros'] = [];
$_SESSION['form_data'] = $_POST; 

$usuarioLogado = $_SESSION['username'] ?? null;

function emailJaExiste($email, $conexao, $idusuario = null) {
   
    $queryVerificaEmail = "SELECT * FROM usuario WHERE email = ?";
    if ($idusuario) {
        $queryVerificaEmail .= " AND idusuario != ?";
    }

    $stmt = $conexao->SQL->prepare($queryVerificaEmail);
    $idusuario ? $stmt->bind_param("si", $email, $idusuario) : $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function cpfJaExiste($cpf, $conexao, $idusuario = null) {

    $queryVerificaCPF = "SELECT * FROM usuario WHERE cpf = ?";
    if ($idusuario) {
        $queryVerificaCPF .= " AND idusuario != ?";
    }

    $stmt = $conexao->SQL->prepare($queryVerificaCPF);
    $idusuario ? $stmt->bind_param("si", $cpf, $idusuario) : $stmt->bind_param("s", $cpf);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

if (isset($_POST['upload']) && $_POST['upload'] === 'Cadastrar') {
    $nomeusuario = $_POST['nomeusuario'];
    $cpf = $_POST['cpf'];
    $salario = $_POST['salario'];
    $cargo = $_POST['cargo'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $telefone = $_POST['telefone'];
    $permissao = $_POST['permissao'];
    $ativo = $_POST['ativo'];
    $arquivo = $_FILES['arquivo'] ?? null;

    
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];


    if (emailJaExiste($email, $connect, $idusuario)) {
        $_SESSION['erros']['email'] = "O email já existe no sistema.";
    }

    if (cpfJaExiste($cpf, $connect, $idusuario)) {
        $_SESSION['erros']['cpf'] = "O CPF já existe no sistema.";
    }

    if (!empty($_SESSION['erros'])) {
        $redirectURL = $isEditing ? "../../views/usuarios/editusuario.php?id=$idusuario" : "../../views/usuarios/addusuarios.php";
        header("Location: $redirectURL");
        exit();
    }

    // Tratar o upload da imagem
    $nomeimagem = 'dist/img/avatar.png'; // Imagem padrão
    if ($arquivo && $arquivo['tmp_name']) {
        $diretorio = '../../views/dist/img/';
        $nomeArquivo = basename($arquivo['name']);
        $caminhoCompleto = $diretorio . $nomeArquivo;

        if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
            $nomeimagem = 'dist/img/' . $nomeArquivo;
        }
    } elseif (isset($_POST['valor'])) {
        $nomeimagem = $_POST['valor'];
    }

   
    if ($isEditing) {
        // Atualizar endereço
        $queryEndereco = "SELECT endereco_idendereco FROM usuario WHERE idusuario = ?";
        $stmtEndereco = $connect->SQL->prepare($queryEndereco);
        $stmtEndereco->bind_param("i", $idusuario);
        $stmtEndereco->execute();
        $result = $stmtEndereco->get_result();
        $row = $result->fetch_assoc();
        $idendereco = $row['endereco_idendereco'];

        $enderecos->updateEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $idendereco);

        // Atualizar usuário
        $usuario->UpdateUsuario($idusuario, $nomeusuario, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $nomeimagem, $ativo);

        $log->registrar(
            'usuario',
            $username,
            'atualização',
            'Usuário ID: ' . $idusuario . ' (' . $nomeusuario . ') atualizado com sucesso.'
        );

        $_SESSION['sucesso'] = "Usuário atualizado com sucesso!";
    } else {
        // Inserir novo endereço
        $enderecoId = $enderecos->InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep);
        if ($enderecoId) {
            // Inserir novo usuário com o ID do endereço
            $usuario->InsertUsuario($nomeusuario, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $enderecoId, $nomeimagem);

            $log->registrar(
                'usuario',
                $username,
                'criação',
                'Usuário ' . $nomeusuario . ' criado com sucesso.'
            );
            
            $_SESSION['sucesso'] = "Usuário cadastrado com sucesso!";
        } else {
            $_SESSION['erros']['endereco'] = "Erro ao inserir endereço.";
            header("Location: ../../views/usuarios/createusuario.php");
            exit();
        }
    }

    unset($_SESSION['erros']);
    unset($_SESSION['form_data']);
    header("Location: ../../views/usuarios/index.php?alert=sucesso");
    exit();
} else {
    header('Location: ../../views/usuarios/index.php');
    exit();
}
?>
