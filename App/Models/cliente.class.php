<?php

/*
 Class Clientes
*/

 require_once 'connect.php';
 require_once 'enderecos.class.php';

  class Clientes extends Connect
 {
 	
 	public function index($value)
 	{
 		$query = "SELECT *FROM `cliente` WHERE `public` = 1 AND `ativo` = '$value'";
 		$result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

 		if($result){
 		
 			while ($row = mysqli_fetch_array($result)) {

				  if($row['ativo'] == 0){
                        $c = 'class="label-warning"';
                    }else{
                        $c = " ";
                    }
 				echo '<li '.$c.'>
                  <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>

					      <!-- Modal -->
                      <div class="modal fade" id="deleteModal' . $row['idcliente'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idcliente'] . '" aria-hidden="true" >
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModalLabel' . $row['idcliente'] . '">Excluir Usuário</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      Você tem certeza que deseja excluir o usuário <strong>' . $row['nome'] . '</strong>?
                                  </div>
                                  <div class="modal-footer">
                                      <form action="../../App/Database/delcliente.php" method="POST">
                                          <input type="hidden" name="idcliente" value="' . $row['idcliente'] . '">
                                          <button type="button" name="upload" value="Cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" name="upload" value="Cadastrar" class="btn btn-danger">Excluir</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  
                  <!-- todo text -->
                  <span class="badge btn-primary">'.$row['idcliente'].' </span> 
				  <span class="text">'.$row['nome'].'</span>
				  <span class="text"> | Telefone: '.$row['telefone'].'</span>
				  <span class="text"> | Desconto: '.$row['desconto'].'%</span>
                  <!-- Emphasis label -->
                  <!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
                    <a href="editcliente.php?id='.$row['idcliente'].'" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fa fa-edit fa-lg"></i></a>
                    <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idcliente'] . '" title="Excluir">
                          <i class="fa fa-trash-o fa-lg"></i>
                      </a>
                  </div>
                </li>';
                 				
 			}
 			
 		}

 	}

 	public function listClientes($value = NULL){

			$query = "SELECT *FROM `cliente`";
			$result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

			if($result){
			
				while ($row = mysqli_fetch_array($result)) {
			if($value == $row['idcliente']){ 
			$selected = "selected";
			}else{
			$selected = "";
			}
					echo '<option value="'.$row['idcliente'].'" '.$selected.' >'.$row['nome'].'</option>';
				}

		}
	}

 	public function InsertCliente($nomeCliente, $cpf, $desconto, $email, $telefone, $enderecoId){

			$query = "INSERT INTO `cliente`(`idcliente`, `nome`, `cpf`, `desconto`, `email`, `telefone`, `endereco_idendereco`, `ativo`) VALUES (NULL,'$nomeCliente','$cpf', '$desconto', '$email', '$telefone', '$enderecoId', '1')";
			if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

				header('Location: ../../views/clientes/index.php?alert=1');
			}else{
				header('Location: ../../views/clientes/index.php?alert=0');
			}


	}

	public function editCliente($idcliente)
	{
	   // Consulta o usuário
	   $queryUsuario = "SELECT * FROM `cliente` WHERE `idcliente` = '$idcliente'";
	   if ($resultUsuario = mysqli_query($this->SQL, $queryUsuario) or die(mysqli_error($this->SQL))) {
   
		   if ($rowCliente = mysqli_fetch_array($resultUsuario)) {
			   // Dados do usuário
			   $idcliente = $rowCliente['idcliente'];
			   $nomeCliente = $rowCliente['nome'];
			   $cpf = $rowCliente['cpf'];
			   $desconto = $rowCliente['desconto'];
			   $email = $rowCliente['email'];
			   $telefone = $rowCliente['telefone'];
			   $ativo = $rowCliente['ativo'];
			   $idendereco = $rowCliente['endereco_idendereco']; // ID do endereço
   
			   // Consulta o endereço do usuário
			   $queryEndereco = "SELECT * FROM `endereco` WHERE `idendereco` = '$idendereco'";
			   $resultEndereco = mysqli_query($this->SQL, $queryEndereco) or die(mysqli_error($this->SQL));
   
			   if ($rowEndereco = mysqli_fetch_array($resultEndereco)) {
				   // Dados do endereço
				   $rua = $rowEndereco['rua'];
				   $numero = $rowEndereco['numero'];
				   $bairro = $rowEndereco['bairro'];
				   $cidade = $rowEndereco['cidade'];
				   $estado = $rowEndereco['estado'];
				   $cep = $rowEndereco['cep'];
   
				   // Monta o array com os dados do usuário e endereço
				   $array = array(
					   'Cliente' => [
						   'idcliente' => $idcliente,
						   'nome' => $nomeCliente,
						   'cpf' => $cpf,	
						   'desconto' => $desconto,					  
						   'email' => $email,
						   'telefone' => $telefone,
						   'ativo' => $ativo
					   ],
					   'Endereco' => [
						   'rua' => $rua,
						   'numero' => $numero,
						   'bairro' => $bairro,
						   'cidade' => $cidade,
						   'estado' => $estado,
						   'cep' => $cep
					   ]
				   );
   
				   return $array; // Retorna os dados do usuário e do endereço
			   } else {
				   return array('error' => 'Endereço não encontrado.');
			   }
		   }
	   } else {
		   return 0;
	   }
	}

	public function UpdateCliente($idcliente, $nome, $cpf, $desconto, $email, $telefone, $ativo)
  {
      // Prepara a query de atualização
      $query = "UPDATE cliente SET 
                  `nome` = ?, 
                  `cpf` = ?,
				  `desconto` = ?,                  
                  `email` = ?, 
                  `telefone` = ?, 
                  `ativo` = ?
                WHERE `idcliente` = ?";

      // Preparar o statement usando a conexão
      $stmt = $this->SQL->prepare($query);

      // Verifica se o statement foi preparado corretamente
      if ($stmt === false) {
          die('Erro ao preparar a query: ' . $this->SQL->error);
      }

      // Associa os parâmetros à query
      $stmt->bind_param("ssssssi", $nome, $cpf, $desconto, $email, $telefone, $ativo, $idcliente);

      // Executa a query
      if ($stmt->execute()) {
          return true; // Sucesso
      } else {
          return false; // Falha
      }
  }

  public function deleteCliente($idcliente){
	if(mysqli_query($this->SQL, "UPDATE `cliente` SET `public` = 0 WHERE `idcliente` = '$idcliente'") or die ( mysqli_error($this->SQL))){
		header('Location: ../../views/clientes/index.php?alert=deletado');
	} else {
		header('Location: ../../views/clientes/index.php?alert=nao_deletado');
	}

}

 }

 $clientes = new Clientes;