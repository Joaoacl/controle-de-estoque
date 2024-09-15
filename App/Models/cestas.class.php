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
              JOIN `categoriaCesta` cat ON c.categoriaCesta_idcategoriaCesta = cat.idcategoriaCesta WHERE c.`public`";
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
                  <span class="text">
                  
                  <!-- todo text -->
                  <span class="badge left text">'.$row['nome_cesta'].'</span> </span> 
                  | '.$row['descricao'].'
                  | VALOR: <strong>' . $row['valor'] . '</strong> 
                  | CATEGORIA: <strong>'.$row['nome_categoria'].'</strong>                      
                  </span>

                  <!-- Emphasis label -->
                  
                  <!-- General tools such as edit or delete-->
                  <div class="tools d-flex justify-content-around">
                    <a href="editcesta.php?id='.$row['idcestaBasica'].'" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fa fa-edit fa-lg"></i></a>
                   


                    <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idcestaBasica'] . '" title="Excluir">
                      <i class="fa fa-trash-o fa-lg"></i>
                    </a>

              
                <!-- Modal -->
                    <div class="modal" id="deleteModal' . $row['idcestaBasica'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idcestaBasica'] . '" aria-hidden="true" >
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel' . $row['idcestaBasica'] . '">Excluir Cesta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Você tem certeza que deseja excluir a cesta <strong>' . $row['nome_cesta'] . '</strong>?
                          </div>
                          <div class="modal-footer">
                            <form action="../../App/Database/delcesta.php" method="POST">
                              <input type="hidden" name="idcestaBasica" value="' . $row['idcestaBasica'] . '">
                              <button type="button" name="upload" value="Cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                              <button type="submit" name="upload" value="Cadastrar" class="btn btn-danger">Excluir</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </li>';
                 				
 			}
 			
 		}

 	}

 	public function InsertCestas($nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta, $ativo){
    
    $valor = str_replace(',', '.', $valor);

 		$query = "INSERT INTO `cestabasica`(`idcestaBasica`, `nome`, `descricao`, `valor`, `categoriaCesta_idcategoriaCesta`, `ativo`, `public`) VALUES (NULL, '$nomeCesta','$descricao', '$valor', '$categoriaCesta_idcategoriaCesta', '$ativo', '1')";
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
        $ativo = $row['ativo'];

       return $resp = array('Cestas' => ['idcestaBasica' => $idcestaBasica,
                      'nome' => $nomeCesta,
                      'descricao'   => $descricao,
                      'valor' => $valor,
                      'categoriaCesta_idcategoriaCesta' => $categoriaCesta_idcategoriaCesta, 'ativo' => $ativo]);  
     }
    
  }

  public function updateCestas($idcestaBasica, $nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta, $produtosSelecionados, $ativo)
  {
    $queryUpdateCesta = "UPDATE `cestabasica` SET 
                `nome`= '$nomeCesta',
                `descricao`= '$descricao',
                `valor`= '$valor',
                `categoriaCesta_idcategoriaCesta`= '$categoriaCesta_idcategoriaCesta',
                `ativo` = '$ativo'
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
    //$queryDeleteProdutos = "DELETE FROM `cestabasica_has_produto` WHERE `cestaBasica_idcestaBasica` = '$idcestaBasica'";
    //mysqli_query($this->SQL, $queryDeleteProdutos) or die(mysqli_error($this->SQL));

    $query = "UPDATE `cestabasica` SET `public` = 0 WHERE `idcestaBasica` = '$idcestaBasica'";
    $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    if ($result) {
        // Item deletado com sucesso
        header('Location: ../../views/cestabasica/index.php?alert=1');
    } else {
        // Falha ao deletar item
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