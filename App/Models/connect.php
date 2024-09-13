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

	function login($username, $password)
	{

		$query  = "SELECT * FROM `usuario` WHERE `email` = '$username'";
		$result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
		$total  = mysqli_num_rows($result);

		if ($total) {

			$dados = mysqli_fetch_array($result);
			if (!strcmp($password, $dados['senha'])) {

				$_SESSION['idUsuario'] = $dados['idusuario'];
				$_SESSION['usuario']   = $dados['nome'];
				$_SESSION['perm']      = $dados['permissao'];
				$_SESSION['foto']      = $dados['imagem'];

				header("Location: ../views/");
			} else {
				header("Location: ../login.php?alert=2");
			}
		} else {
			header("Location: ../login.php?alert=1");
		}
	}

}
$connect = new Connect;