<?php

/*
 Class Usuarios
*/

 require_once 'connect.php';
 require_once 'enderecos.class.php';

  class Usuario extends Connect
 {
 	
    public function index($perm, $value)
    {
        if ($perm == 1) {
            $query = "SELECT * FROM `usuario` WHERE `public` = 1 AND `ativo` = '$value'";
            $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
    
            if ($result) {
                echo '<table class="table table-striped">';
                echo '<thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome do Usuário</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Cargo</th>                 
                            <th>Salário</th>
                            <th>Permissão</th>
                            <th>Ativo</th>
                            <th>Opções</th>
                        </tr>
                      </thead>';
                echo '<tbody>';
    
                while ($row = mysqli_fetch_array($result)) {
                    $ativo_class = ($row['ativo'] == 0) ? 'class="label-warning"' : '';
                    $permissao = ($row['permissao'] == 1) ? 'Administrador' : 'Vendedor';
    
                    echo '<tr ' . $ativo_class . '>';
                    echo '<td>' . $row['idusuario'] . '</td>';
                    echo '<td>' . $row['nomeUsuario'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['telefone'] . '</td>';
                    echo '<td>' . $row['cargo'] . '</td>';
                    echo '<td>' . $row['salario'] . '</td>';
                    echo '<td><span class="badge ' . ($row['permissao'] == 1 ? 'btn-success' : 'btn-info') . '">' . $permissao . '</span></td>';
                    echo '<td>' . ($row['ativo'] == 1 ? 'Sim' : 'Não') . '</td>';
    
                    echo '<td>
                            <a href="editusuario.php?id=' . $row['idusuario'] . '" class="btn btn-primary btn-sm">Editar</a>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idusuario'] . '">Excluir</button>
    
                        <!-- Modal -->
                      <div class="modal fade" id="deleteModal' . $row['idusuario'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idusuario'] . '" aria-hidden="true" >
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModalLabel' . $row['idusuario'] . '">Excluir Usuário</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      Você tem certeza que deseja excluir o usuário <strong>' . $row['nomeUsuario'] . '</strong>?
                                  </div>
                                  <div class="modal-footer">
                                      <form action="../../App/Database/delusuario.php" method="POST">
                                          <input type="hidden" name="idusuario" value="' . $row['idusuario'] . '">
                                          <button type="button" name="upload" value="Cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" name="upload" value="Cadastrar" class="btn btn-danger">Excluir</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                          </td>';
                    echo '</tr>';
                }
    
                echo '</tbody>';
                echo '</table>';
            }
        } else {
            return 0;
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

 	public function InsertUsuario($username, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $enderecoId, $pt_file){

 		$query = "INSERT INTO usuario (`nomeUsuario`, `cpf`, `salario`, `cargo`, `email`, `senha`, `telefone`, `permissao`, `endereco_idendereco`, `ativo`, `imagem`)
            VALUES ('$username', '$cpf', '$salario', '$cargo', '$email', '$senha', '$telefone', '$permissao', '$enderecoId', '1', '$pt_file')";
 		if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

 			header('Location: ../../views/usuarios/index.php?alert=1');
 		}else{
            die('Erro ao inserir usuário: ' . mysqli_error($this->SQL)); // Mostra o erro específico do MySQL
 		}
 	}

  public function getSenhaAtual($idusuario) {
    $query = "SELECT senha FROM `usuario` WHERE `idusuario` = '$idusuario'";
    $result = mysqli_query($this->SQL, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['senha'];
  }

  public function editUsuario($idusuario)
  {
    // Consulta o usuário
    $queryUsuario = "SELECT * FROM `usuario` WHERE `idusuario` = '$idusuario'";
    if ($resultUsuario = mysqli_query($this->SQL, $queryUsuario) or die(mysqli_error($this->SQL))) {

        if ($rowUsuario = mysqli_fetch_array($resultUsuario)) {
            // Dados do usuário
            $idusuario = $rowUsuario['idusuario'];
            $nomeUsuario = $rowUsuario['nomeUsuario'];
            $cpf = $rowUsuario['cpf'];
            $salario = $rowUsuario['salario'];
            $cargo = $rowUsuario['cargo'];
            $email = $rowUsuario['email'];
            $telefone = $rowUsuario['telefone'];
            $permissao = $rowUsuario['permissao'];
            $imagem = $rowUsuario['imagem'];
            $ativo = $rowUsuario['ativo'];
            $idendereco = $rowUsuario['endereco_idendereco']; // ID do endereço

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
                    'Usuario' => [
                        'idusuario' => $idusuario,
                        'nomeUsuario' => $nomeUsuario,
                        'cpf' => $cpf,
                        'salario' => $salario,
                        'cargo' => $cargo,
                        'email' => $email,
                        'telefone' => $telefone,
                        'permissao' => $permissao,
                        'imagem' => $imagem,
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

  public function UpdateUsuario($idusuario, $username, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $nomeimagem, $ativo)
  {
      // Prepara a query de atualização
      $query = "UPDATE usuario SET 
                  `nomeUsuario` = ?, 
                  `cpf` = ?, 
                  `salario` = ?, 
                  `cargo` = ?, 
                  `email` = ?, 
                  `senha` = ?, 
                  `telefone` = ?, 
                  `permissao` = ?, 
                  `imagem` = ?,
                  `ativo` = ?
                WHERE `idusuario` = ?";

      // Preparar o statement usando a conexão
      $stmt = $this->SQL->prepare($query);

      // Verifica se o statement foi preparado corretamente
      if ($stmt === false) {
          die('Erro ao preparar a query: ' . $this->SQL->error);
      }

      // Associa os parâmetros à query
      $stmt->bind_param("ssssssssssi", $username, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $nomeimagem, $ativo, $idusuario);

      // Executa a query
      if ($stmt->execute()) {
          return true; // Sucesso
      } else {
          return false; // Falha
      }
  }

  public function deleteUsuario($idusuario){
        if(mysqli_query($this->SQL, "UPDATE `usuario` SET `public` = 0 WHERE `idusuario` = '$idusuario'") or die ( mysqli_error($this->SQL))){
            header('Location: ../../views/usuarios/index.php?alert=deletado');
        } else {
            header('Location: ../../views/usuarios/index.php?alert=nao_deletado');
        }
    
    }

  

 }

 $usuario = new Usuario;