<?php
require_once '../auth.php';
require_once '../Models/usuario.class.php';
require_once '../Models/enderecos.class.php';

$enderecos = new Enderecos();

// Função para tratar o upload de imagem
function salvarImagem($imagem) {
    $diretorio = 'dist/img/'; // Diretório para salvar a imagem
    $nomeArquivo = basename($imagem['name']); // Nome do arquivo
    $caminhoCompleto = $diretorio . $nomeArquivo; // Caminho completo para salvar

    // Verifica se o arquivo é realmente uma imagem
    $checarImagem = getimagesize($imagem['tmp_name']);
    if ($checarImagem !== false) {
        // Verifica se o arquivo foi movido corretamente
        if (move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {
            return $nomeArquivo; // Retorna o nome do arquivo se o upload for bem-sucedido
        } else {
            return false; // Retorna false se houver erro ao mover o arquivo
        }
    } else {
        return false; // Retorna false se o arquivo não for uma imagem válida
    }
}

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
    if ($username != NULL && $senha != NULL && $email != NULL && $perm == 1) {
        // Tratar o upload da imagem
        if (!file_exists($_FILES['arquivo']['name'])) {		
			
			$pt_file =  '../../views/dist/img/'.$_FILES['arquivo']['name'];
			
			if ($pt_file != '../../views/dist/img/'){	
				
				$destino =  '../../views/dist/img/'.$_FILES['arquivo']['name'];				
				$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
				move_uploaded_file($arquivo_tmp, $destino);
				chmod ($destino, 0644);	

				$nomeimagem =  'dist/img/'.$_FILES['arquivo']['name'];
				
			}elseif($_POST['valor'] != NULL){
				
				$nomeimagem = $_POST['valor'];				
			
				}else{
				$nomeimagem = 'dist/img/avatar.png';
				}
			}

        // Inserir endereço primeiro
        $enderecoId = $enderecos->InsertEndereco($rua, $numero, $bairro, $cidade, $estado, $cep);
        if ($enderecoId) {
            // Inserir usuário com o ID do endereço
            $usuario->InsertUsuario($username, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $enderecoId, $nomeimagem);
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
