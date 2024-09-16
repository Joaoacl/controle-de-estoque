<?php

/*
 Class Clientes
*/

 require_once 'connect.php';
 require_once 'enderecos.class.php';

  class Usuario extends Connect
 {
 	
 	public function index($perm)
 	{
        if($perm == 1){
            $query = "SELECT *FROM `usuario`";
            $result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

                while ($row = mysqli_fetch_array($result)) {
                    echo '<li>
                     <!-- drag handle -->
                         <span class="handle">
                           <i class="fa fa-ellipsis-v"></i>
                           <i class="fa fa-ellipsis-v"></i>
                         </span>
                     
                     <!-- todo text -->
                     <span class="text">'.$row['nomeUsuario'].'</span>
                     <span class=""> | Permissão:</span>';
                     
                     if($row['permissao'] == 1){
                        echo '<span class="text badge">Administrador</span>';
                     }else{
                        echo '<span class="text badge">Vendedor</span>';
                     }
                     echo'
                     
                     <!-- Emphasis label -->
                     <!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->

                     <!-- General tools such as edit or delete-->
                     <div class="tools">
                       <a href="editusuario.php?id='.$row['idusuario'].'" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fa fa-edit fa-lg"></i></a>

                       <i class="fa fa-trash-o"></i>
                     </div>
                   </li>';
                                    
                }
                
        }else{
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

 	public function InsertUsuario($username, $cpf, $salario, $cargo, $email, $senha, $telefone, $permissao, $enderecoId){

 		$query = "INSERT INTO usuario (`nomeUsuario`, `cpf`, `salario`, `cargo`, `email`, `senha`, `telefone`, `permissao`, `endereco_idendereco`, `ativo`)
            VALUES ('$username', '$cpf', '$salario', '$cargo', '$email', '$senha', '$telefone', '$permissao', '$enderecoId', '1')";
 		if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

 			header('Location: ../../views/usuarios/index.php?alert=1');
 		}else{
 			header('Location: ../../views/usuarios/index.php?alert=0');
 		}


 	}
 }

 $usuario = new Usuario;