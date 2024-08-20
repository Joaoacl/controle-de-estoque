<?php

/*
 Class Clientes
*/

 require_once 'connect.php';
 require_once 'enderecos.class.php';

  class Clientes extends Connect
 {
 	
 	public function index()
 	{
 		$query = "SELECT *FROM `cliente`";
 		$result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

 		if($result){
 		
 			while ($row = mysqli_fetch_array($result)) {
 				echo '<li>
                  <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <!-- checkbox -->
                  <input type="checkbox" value="'.$row['idcliente'].'">
                  <!-- todo text -->
                  <span class="text"><span class="badge left">'.$row['idcliente'].'</span> '.$row['nome'].'</span>
                  <!-- Emphasis label -->
                  <!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
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

 		$query = "INSERT INTO `cliente`(`idcliente`, `nome`, `cpf`, `desconto`, `email`, `telefone`, `endereco_idendereco`) VALUES (NULL,'$nomeCliente','$cpf', '$desconto', '$email', '$telefone', '$enderecoId')";
 		if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

 			header('Location: ../../views/clientes/index.php?alert=1');
 		}else{
 			header('Location: ../../views/clientes/index.php?alert=0');
 		}


 	}
 }

 $clientes = new Clientes;