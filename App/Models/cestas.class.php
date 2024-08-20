<?php

/*
 Class produtos
*/

 require_once 'connect.php';

  class Cestas extends Connect
 {
 	
 	public function index()
 	{
 		$query = "SELECT *FROM `cestabasica`";
 		$result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

 		if($result){
 		
 			while ($row = mysqli_fetch_array($result)) {
 				echo '<li>
                  <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <span class="text">
                  <!-- checkbox -->
                  <form class="badge" name="ativ'.$row['idcestaBasica'].'" action="action.php" method="post">
                  <input type="hidden" name="id" id="id" value="'.$row['idcestaBasica'].'">

                  <input type="hidden" name="status" id="status" value="'.$row['ativo'].'">
                  <input type="checkbox" id="status" name="status" ';
                   if($row['ativo'] == 1){ echo 'checked'; } 
                  echo ' value="'.$row['ativo'].'" onclick="this.form.submit();"></form>
                  <!-- todo text -->
                  <span class="badge left ">'.$row['nome'].'</span> </span> 
                  '.$row['descricao'].'
                  - R$'.$row['valor'].'  
                  - '.$row['categoriaCesta_idcategoriaCesta'].'                      
                  </span>

                  <!-- Emphasis label -->
                  
                  <!-- General tools such as edit or delete-->
                  <div class="tools right ">
                    
                    <form class="right" name="editcesta'.$row['idcestaBasica'].'" action="editcesta.php" method="post">
                      <input type="hidden" name="idcestaBasica" id="idcestaBasica" value="'.$row['idcestaBasica'].'">
                      <a href="editcesta.php" type="button" onclick="this.form.submit();"><i class="fa fa-edit"></i></a></form>
                    <form class="right" name="delcesta'.$row['idcestaBasica'].'" action="delcesta.php" method="post">
                    <input type="hidden" name="idcestaBasica" id="idcestaBasica" value="'.$row['idcestaBasica'].'">
                     <a href="#" type="button" onclick="this.form.submit();"><i class="fa fa-trash-o"></i></a></form>
                  </div>
                </li>';
                 				
 			}
 			
 		}

 	}

 	public function InsertCestas($nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta){

 		$query = "INSERT INTO `cestabasica`(`idcestaBasica`, `nome`, `descricao`, `valor`, `categoriaCesta_idcategoriaCesta`) VALUES (NULL, '$nomeCesta','$descricao', '$valor', '$categoriaCesta_idcategoriaCesta')";
 		if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

 			header('Location: ../../views/cestabasica/index.php?alert=1');
 		}else{
 			header('Location: ../../views/cestabasica/index.php?alert=0');
 		}
 	}//InsertItens

  public function editCestas($value)
  {
    $query = "SELECT *FROM `cestabasica` WHERE `idcestaBasica` = '$value'";
    $result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

    if($row = mysqli_fetch_array($result)){

        $idcestaBasica = $row['idcestaBasica'];
        $descricao = $row['descricao'];
        $valor = $row['valor'];
        $categoriaCesta_idcategoriaCesta = $row['categoriaCesta_idcategoriaCesta'];
        
       return $resp = array('Cestas' => ['idcestaBasica' => $idcestaBasica,
                      'descricao'   => $descricao,
                      'valor' => $valor,
                      'categoriaCesta_idcategoriaCesta' => $categoriaCesta_idcategoriaCesta]);  
     }
    
  }

  public function updateCestas($nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta)
  {
    $query = "UPDATE `cestabasica` SET 
                    `descricao`= '$descricao',
                    `valor`='$valor',
                    `categoriaCesta_idcategoriaCesta`='$categoriaCesta_idcategoriaCesta'
                    WHERE `idcestaBasica`= '$idcestaBasica'";

    if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

      header('Location: ../../views/cestabasica/index.php?alert=1');
    }else{
      header('Location: ../../views/cestabasica/index.php?alert=0');
    }

  }

  /*
  public function QuantItensVend($value, $idItens)
  { 
    $query = "UPDATE `itens` SET `QuantItensVend` = '$value' WHERE `idItens`= '$idItens'";
    
    if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

      header('Location: ../../views/itens/index.php?alert=1');
    }else{
      header('Location: ../../views/itens/index.php?alert=0');
    }
  }
    */

  public function cestasAtivo($value, $idcestaBasica)
  {

    if($value == 0){ $v = 1; }else{ $v = 0; }

    $query = "UPDATE `cestabasica` SET `ativo` = '$v' WHERE `idcestaBasica` = '$idcestaBasica'";
    $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
       
    header('Location: ../../views/cestabasica/');
    /*

    $this->queryAtivo = "SELECT `Ativo` FROM `itens` WHERE `idItens`= '$idItens'";
    $this->resultAtivo = mysqli_query($this->SQL, $this->queryAtivo) or die ( mysqli_error($this->SQL));
      
      if($rep = mysqli_fetch_array($this->resultAtivo)) {
       $valueResp = $rep['Ativo'];
      } 

    switch ($valueResp) {
      case 1:
          $value = 0;
        break;
      case 0:
          $value = 1;
        break;      
     
   }

    
    $this->query = "UPDATE `itens` SET `Ativo` = '$value' WHERE `idItens`= '$idItens'";
    if($this->result = mysqli_query($this->SQL, $this->query) or die(mysqli_error($this->SQL))){

      header('Location: ../../views/itens/index.php?alert=1');
    }else{
      header('Location: ../../views/itens/index.php?alert=0');
    }*/
  
  }//ItensAtivo



 }

 $cestas = new Cestas;