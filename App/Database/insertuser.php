<?php
require_once '../auth.php';
require_once '../Models/usuario.class.php';
require_once '../Models/enderecos.class.php';
require_once '../Models/connect.php';

$enderecos = new Enderecos();
$connect = new Connect(); // Instancia a conexão

// Função para tratar o upload de imagem
function salvarImagem($imagem) {
    $diretorio = '../../views/dist/img/'; // Diretório para salvar a imagem
    $nomeArquivo = basename($imagem['name']); // Nome do arquivo
    $caminhoCompleto = $diretorio . $nomeArquivo; // Caminho completo para salvar

    // Verifica se o arquivo é realmente uma imagem
    $checarImagem = getimagesize($imagem['tmp_name']);
    if ($checarImagem !== false) {
        // Verifica se o arquivo foi movido corretamente
        if (move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {
            return $nomeArquivo; // Retorna o nome do arquivo se o upload for bem-sucedido
        } else {
            echo "Erro ao mover o arquivo: " . $imagem['tmp_name'] . " para " . $caminhoCompleto;
            return false; // Retorna false se houver erro ao mover o arquivo
        }
    } else {
        echo "O arquivo não é uma imagem válida.";
        return false; // Retorna false se o arquivo não for uma imagem válida
    }
};

function emailJaExiste($email, $conexao, $idusuario = null) {
    // Ajusta a consulta para excluir o email do próprio usuário que está sendo atualizado
    $queryVerificaEmail = "SELECT * FROM usuario WHERE email = ?";
    if ($idusuario) {
        $queryVerificaEmail .= " AND idusuario != ?";
    }

    $stmt = $conexao->SQL->prepare($queryVerificaEmail);
    if ($idusuario) {
        $stmt->bind_param("si", $email, $idusuario); // "s" para string (email) e "i" para inteiro (idusuario)
    } else {
        $stmt->bind_param("s", $email);
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->num_rows > 0;
};


if (isset($_POST['upload']) && $_POST['upload'] === 'Cadastrar') {
    // Dados do usuário
    $idusuario = isset($_POST['idusuario']) ? $_POST['idusuario'] : null;
    $username = $_POST['username'];
    $cpf = $_POST['cpf'];
    $salario = $_POST['salario'];
    $cargo = $_POST['cargo'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Senha criptografada
    $telefone = $_POST['telefone'];
    $permissao = $_POST['permissao'];
    $ativo = $_POST['ativo'];
    $arquivo = $_FILES['arquivo'];
    //$imagem = $_POST['arquivo'];

    // Endereço
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    // Verificação de campos obrigatórios
    if ($username != NULL && $senha != NULL && $email != NULL && $perm == 1) {

        // Verifica se o email já existe no banco de dados
        if (emailJaExiste($email, $connect, $idusuario)) {
            // Email já existe, redireciona com uma mensagem de erro
            header('Location: ../../views/usuarios/index.php?alert=email_ja_existe');
        } else {
            // Verificar se o CPF já existe no banco de dados
            $queryVerificaCPF = "SELECT * FROM usuario WHERE cpf = '$cpf'";
            if ($idusuario) {
                $queryVerificaCPF .= " AND idusuario != '$idusuario'";
            }

            $resultVerificaCPF = mysqli_query($connect->SQL, $queryVerificaCPF);

            if (mysqli_num_rows($resultVerificaCPF) > 0) {
                // CPF já existe, redirecionar com uma mensagem de erro
                header('Location: ../../views/usuarios/index.php?alert=cpf_ja_existe');
            } else {
                // Tratar o upload da imagem
                if (isset($arquivo) && !file_exists('../../views/dist/img/' . $arquivo['name'])) {       
        $destino = '../../views/dist/img/' . $arquivo['name']; // Caminho completo para salvar a imagem
        $arquivo_tmp = $arquivo['tmp_name']; // Caminho temporário do arquivo

        // Verifica se há um arquivo válido e se ele é uma imagem
        if (!empty($arquivo_tmp)) {
            // Mover o arquivo para o destino
            if (move_uploaded_file($arquivo_tmp, $destino)) {
                chmod($destino, 0644); // Definir permissões
                $nomeimagem = 'dist/img/' . $arquivo['name']; // Caminho da imagem para salvar no banco
            } else {
                // Caso ocorra um erro ao mover o arquivo
                echo "Erro ao mover o arquivo: " . $arquivo_tmp . " para " . $destino;
                $nomeimagem = 'dist/img/avatar.png'; // Caminho padrão se o upload falhar
            }
        } else {
            // Caso não haja imagem enviada
            $nomeimagem = 'dist/img/avatar.png';
        }

    } elseif ($_POST['valor'] != NULL) {
        // Caso uma imagem já exista ou o valor da imagem seja passado via POST
        $nomeimagem = $_POST['valor'];
    } else {
        // Se nenhuma imagem for enviada, define um avatar padrão
        $nomeimagem = 'dist/img/avatar.png';
    }
                // Se existir idusuario, realiza o update
                if ($idusuario) {
                    
                    $queryEndereco = "SELECT endereco_idendereco FROM usuario WHERE idusuario = ?";
                    $stmtEndereco = $connect->SQL->prepare($queryEndereco);
                    $stmtEndereco->bind_param("i", $idusuario);
                    $stmtEndereco->execute();
                    $result = $stmtEndereco->get_result();
                    $row = $result->fetch_assoc();
                    $idendereco = $row['endereco_idendereco'];

                    // Atualizar endereço
                    $enderecos->updateEndereco($rua, $numero, $bairro, $cidade, $estado, $cep, $idendereco);

                    // Atualizar usuário
                    $usuario->UpdateUsuario($idusuario, $username, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $nomeimagem, $ativo);

                    header('Location: ../../views/usuarios/index.php?alert=update_sucesso'); // Sucesso no update
                } else {
                    // Inserir endereço primeiro
                    $enderecoId = $enderecos->InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep);
                    if ($enderecoId) {
                        // Inserir usuário com o ID do endereço
                        $usuario->InsertUsuario($username, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $enderecoId, $nomeimagem);
                        header('Location: ../../views/usuarios/index.php?alert=sucesso'); // Sucesso no insert
                    } else {
                        header('Location: ../../views/usuarios/index.php?alert=erro_endereco'); // Erro ao inserir endereço
                    }
                }
            }
        }
    } else {
        header('Location: ../../views/usuarios/index.php?alert=campos_obrigatorios'); // Campos obrigatórios faltando
    }
} else {
    header('Location: ../../views/usuarios/index.php');
}
