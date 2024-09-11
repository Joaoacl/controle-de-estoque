<?php

/*
 Class produtos
*/

 require_once 'connect.php';

  class Cestas extends Connect
 {
 	
 	public function index()
 	{
 		$query = "SELECT c.idcestaBasica, c.nome AS nome_cesta, c.descricao, c.valor, c.ativo, cat.nome AS nome_categoria 
              FROM `cestabasica` c
              JOIN `categoriaCesta` cat ON c.categoriaCesta_idcategoriaCesta = cat.idcategoriaCesta";
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
                  <form class="text" name="ativ'.$row['idcestaBasica'].'" action="action.php" method="post">
                  <input type="hidden" name="id" id="id" value="'.$row['idcestaBasica'].'">

                  <input type="hidden" name="status" id="status" value="'.$row['ativo'].'">
                  <input type="checkbox" id="status" name="status" ';
                   if($row['ativo'] == 1){ echo 'checked'; } 
                  echo ' value="'.$row['ativo'].'" onclick="this.form.submit();"></form>
                  <!-- todo text -->
                  <span class="badge left text">'.$row['nome_cesta'].'</span> </span> 
                  | '.$row['descricao'].'
                  | VALOR: <strong>R$' . $row['valor'] . '</strong> 
                  | CATEGORIA: <strong>'.$row['nome_categoria'].'</strong>                      
                  </span>

                  <!-- Emphasis label -->
                  
                  <!-- General tools such as edit or delete-->
                  <div class="tools d-flex justify-content-around">
                    <a href="editcesta.php?id='.$row['idcestaBasica'].'" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fa fa-edit fa-lg"></i></a>
                    <a href="deletecesta.php?id='.$row['idcestaBasica'].'" class="btn btn-outline-danger btn-sm" title="Excluir"><i class="fa fa-trash-o fa-lg"></i></a>
                  </div>
                </li>';
                 				
 			}
 			
 		}

 	}

 	public function InsertCestas($nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta){

 		$query = "INSERT INTO `cestabasica`(`idcestaBasica`, `nome`, `descricao`, `valor`, `categoriaCesta_idcategoriaCesta`) VALUES (NULL, '$nomeCesta','$descricao', '$valor', '$categoriaCesta_idcategoriaCesta')";
 		if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){
      return mysqli_insert_id($this->SQL);
 			header('Location: ../../views/cestabasica/index.php?alert=1');
 		}else{
 			header('Location: ../../views/cestabasica/index.php?alert=0');
 		}
 	}//InsertItens

   public function insertProdutoNaCesta($idcestaBasica, $idProduto)
   {
       $query = "INSERT INTO `cestabasica_has_produto` (`cestaBasica_idcestaBasica`, `produto_idproduto`, `quantidade`) VALUES ('$idcestaBasica', '$idProduto', 1)";
       mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
   }
   

  public function editCestas($value)
  {
    $query = "SELECT *FROM `cestabasica` WHERE `idcestaBasica` = '$value'";
    $result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

    if($row = mysqli_fetch_array($result)){

        $idcestaBasica = $row['idcestaBasica'];
        $nomeCesta = $row['nome'];
        $descricao = $row['descricao'];
        $valor = $row['valor'];
        $categoriaCesta_idcategoriaCesta = $row['categoriaCesta_idcategoriaCesta'];
        
       return $resp = array('Cestas' => ['idcestaBasica' => $idcestaBasica,
                      'nome' => $nomeCesta,
                      'descricao'   => $descricao,
                      'valor' => $valor,
                      'categoriaCesta_idcategoriaCesta' => $categoriaCesta_idcategoriaCesta]);  
     }
    
  }

  public function updateCestas($idcestaBasica, $nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta, $produtosSelecionados)
  {
    $queryUpdateCesta = "UPDATE `cestabasica` SET 
                `nome`= '$nomeCesta',
                `descricao`= '$descricao',
                `valor`= '$valor',
                `categoriaCesta_idcategoriaCesta`= '$categoriaCesta_idcategoriaCesta'
              WHERE `idcestaBasica`= '$idcestaBasica'";

    mysqli_query($this->SQL, $queryUpdateCesta) or die(mysqli_error($this->SQL));


    $queryDeleteProdutos = "DELETE FROM `cestabasica_has_produto` WHERE `cestaBasica_idcestaBasica` = '$idcestaBasica'";
    mysqli_query($this->SQL, $queryDeleteProdutos) or die(mysqli_error($this->SQL));


    foreach($produtosSelecionados as $idProduto) {
    $this->insertProdutoNaCesta($idcestaBasica, $idProduto);
    }


    header('Location: ../../views/cestabasica/index.php?alert=1');
}

  public function deleteCestas($idcestaBasica)
  {
    $queryDeleteProdutos = "DELETE FROM `cestabasica_has_produto` WHERE `cestaBasica_idcestaBasica` = '$idcestaBasica'";
    mysqli_query($this->SQL, $queryDeleteProdutos) or die(mysqli_error($this->SQL));

    $query = "DELETE FROM `cestabasica` WHERE `idcestaBasica` = '$idcestaBasica'";
    $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    if ($result) {
        // Item deletado com sucesso
        return true;
    } else {
        // Falha ao deletar item
        return false;
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