<?php

/**
 * Conexão com o banco de dados
 */
class Connect
{

	var $localhost = "localhost";
	var $root = "root"; 
	var $passwd = "";   
	var $database = "controlestoque";
	var $SQL;



	public function __construct()
	{
		$this->SQL = mysqli_connect($this->localhost, $this->root, $this->passwd);
		mysqli_select_db($this->SQL, $this->database);
		if (!$this->SQL) {
			die("Conexão com o banco de dados falhou!:" . mysqli_connect_error($this->SQL));
		}
	}

	function login($username, $password) {
		// Usando prepared statements para prevenir SQL Injection
		$stmt = $this->SQL->prepare("SELECT * FROM `usuario` WHERE `email` = ?");
		
		if (!$stmt) {
			// Exibe o erro se a query estiver incorreta
			die('Erro ao preparar a consulta: ' . $this->SQL->error);
		}
	
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
	
		// Exibe o número de linhas retornadas
		if ($result->num_rows > 0) {
			$dados = $result->fetch_assoc();
	
			
			if (strcmp($password, $dados['senha'])) {
				// Se a senha estiver correta, cria as sessões
				$_SESSION['idUsuario'] = $dados['idusuario'];
				$_SESSION['usuario']   = $dados['nomeUsuario'];
				$_SESSION['perm']      = $dados['permissao'];
				$_SESSION['foto']      = $dados['imagem'];
	
				header("Location: ../views/");
				exit;
			} else {
				// Caso a senha esteja incorreta
				header("Location: ../login.php?alert=2");
				exit;
			}
		} else {
			// Caso o email não seja encontrado
			echo "Nenhum usuário encontrado com esse email.";
			exit;
			header("Location: ../login.php?alert=1");
			exit;
		}
	}
	

}
$connect = new Connect;