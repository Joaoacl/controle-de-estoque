<?php

/*
 Class Clientes
*/

 require_once 'connect.php';
 require_once 'enderecos.class.php';

  class Fornecedor extends Connect
 {
 	
 	public function index($value)
 	{
 		$query = "SELECT *FROM `fornecedor` WHERE `public` = 1 AND `ativo` = '$value'";
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
                      <div class="modal fade" id="deleteModal' . $row['idfornecedor'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idfornecedor'] . '" aria-hidden="true" >
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModalLabel' . $row['idfornecedor'] . '">Excluir Usuário</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      Você tem certeza que deseja excluir o usuário <strong>' . $row['nome'] . '</strong>?
                                  </div>
                                  <div class="modal-footer">
                                      <form action="../../App/Database/delfornecedor.php" method="POST">
                                          <input type="hidden" name="idfornecedor" value="' . $row['idfornecedor'] . '">
                                          <button type="button" name="upload" value="Cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" name="upload" value="Cadastrar" class="btn btn-danger">Excluir</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  
                  <!-- todo text -->
                  <span class="badge btn-primary">'.$row['idfornecedor'].' </span> 
				  <span class="text">'.$row['nome'].'</span>
				  <span class="text"> | Telefone: '.$row['telefone'].'</span>
				  <span class="text"> | Email: '.$row['email'].'</span>
                  <span class="text"> | Conta: '.$row['numConta'].'</span>
                  <span class="text"> | Agência: '.$row['agencia'].'</span>
                  <span class="text"> | Banco: '.$row['banco'].'</span>
                  <!-- Emphasis label -->
                  <!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
                    <a href="editfornecedor.php?id='.$row['idfornecedor'].'" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fa fa-edit fa-lg"></i></a>
                    <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idfornecedor'] . '" title="Excluir">
                          <i class="fa fa-trash-o fa-lg"></i>
                      </a>
                  </div>
                </li>';
                 				
 			}
 			
 		}

 	}

 	public function listFornecedores($value = NULL){

			$query = "SELECT *FROM `fornecedor`";
			$result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

			if($result){
			
				while ($row = mysqli_fetch_array($result)) {
			if($value == $row['idfornecedor']){ 
			$selected = "selected";
			}else{
			$selected = "";
			}
					echo '<option value="'.$row['idfornecedor'].'" '.$selected.' >'.$row['nome'].'</option>';
				}

		}
	}

 	public function InsertFornecedor($nomeFornecedor, $telefone, $email, $numConta, $agencia, $banco, $enderecoId){

			$query = "INSERT INTO `fornecedor`(`idfornecedor`, `nome`, `telefone`, `email`, `numConta`, `agencia`, `banco`, `endereco_idendereco`, `ativo`) VALUES (NULL,'$nomeFornecedor','$telefone', '$email', '$numConta', '$agencia', '$banco', '$enderecoId', '1')";
			if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

				header('Location: ../../views/fornecedor/index.php?alert=1');
			}else{
				header('Location: ../../views/fornecedor/index.php?alert=0');
			}


	}

	public function editFornecedor($idfornecedor)
	{
	   // Consulta o usuário
	   $queryUsuario = "SELECT * FROM `fornecedor` WHERE `idfornecedor` = '$idfornecedor'";
	   if ($resultFornecedor = mysqli_query($this->SQL, $queryUsuario) or die(mysqli_error($this->SQL))) {
   
		   if ($rowFornecedor = mysqli_fetch_array($resultFornecedor)) {
			   // Dados do usuário
			   $idfornecedor = $rowFornecedor['idfornecedor'];
			   $nomeFornecedor = $rowFornecedor['nome'];
			   $telefone = $rowFornecedor['telefone'];
			   $email = $rowFornecedor['email'];
			   $numConta = $rowFornecedor['numConta'];
			   $agencia = $rowFornecedor['agencia'];
               $banco = $rowFornecedor['banco'];
			   $ativo = $rowFornecedor['ativo'];
			   $idendereco = $rowFornecedor['endereco_idendereco']; // ID do endereço
   
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
					   'Fornecedor' => [
						   'idfornecedor' => $idfornecedor,
						   'nome' => $nomeFornecedor,
						   'telefone' => $telefone,	
                           'email' => $email,
						   'numConta' => $numConta,					  
						   'agencia' => $agencia,
                           'banco' => $banco,
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

	public function UpdateFornecedor($idfornecedor, $nomeFornecedor, $telefone, $email, $numConta, $agencia, $banco, $ativo)
  {
      // Prepara a query de atualização
      $query = "UPDATE fornecedor SET 
                  `nome` = ?, 
                  `telefone` = ?,
				  `email` = ?,                  
                  `numConta` = ?, 
                  `agencia` = ?, 
                  `banco` = ?,
                  `ativo` = ?
                WHERE `idfornecedor` = ?";

      // Preparar o statement usando a conexão
      $stmt = $this->SQL->prepare($query);

      // Verifica se o statement foi preparado corretamente
      if ($stmt === false) {
          die('Erro ao preparar a query: ' . $this->SQL->error);
      }

      // Associa os parâmetros à query
      $stmt->bind_param("sssssssi", $nomeFornecedor, $telefone, $email, $numConta, $agencia, $banco, $ativo, $idfornecedor);

      // Executa a query
      if ($stmt->execute()) {
          return true; // Sucesso
      } else {
          return false; // Falha
      }
  }

  public function deleteFornecedor($idfornecedor){
	if(mysqli_query($this->SQL, "UPDATE `fornecedor` SET `public` = 0 WHERE `idfornecedor` = '$idfornecedor'") or die ( mysqli_error($this->SQL))){
		header('Location: ../../views/fornecedor/index.php?alert=deletado');
	} else {
		header('Location: ../../views/fornecedor/index.php?alert=nao_deletado');
	}

}

 }

 $fornecedor = new Fornecedor;