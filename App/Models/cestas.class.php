<?php

/*
 Class Cestas
*/

 require_once 'connect.php';

  class Cestas extends Connect
 {
 	
    public function index($value)
    {
        $query = "SELECT c.idcestaBasica, c.nome AS nome_cesta, c.descricao, c.valor, c.ativo, c.public, cat.nome AS nome_categoria 
                  FROM `cestabasica` c
                  JOIN `categoriaCesta` cat ON c.categoriaCesta_idcategoriaCesta = cat.idcategoriaCesta WHERE c.`public` = 1 AND c.`ativo` = '$value'";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

        if ($result) {
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Cesta</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Categoria</th>
                        <th>Ativo</th>
                        <th>Opções</th>
                    </tr>
                  </thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_array($result)) {
                $ativo_class = ($row['ativo'] == 0) ? 'class="warning"' : '';
                
                echo '<tr ' . $ativo_class . '>';
                echo '<td>' . $row['idcestaBasica'] . '</td>';
                echo '<td>' . $row['nome_cesta'] . '</td>';
                echo '<td>' . $row['descricao'] . '</td>';
                echo '<td>R$ ' . $row['valor'] . '</td>';
                echo '<td>' . $row['nome_categoria'] . '</td>';
                echo '<td>' . ($row['ativo'] == 1 ? 'Sim' : 'Não') . '</td>';
                
                echo '<td>
                        <a href="editcesta.php?id=' . $row['idcestaBasica'] . '" class="btn btn-primary btn-sm">Editar</a>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idcestaBasica'] . '">Excluir</button>

                        <!-- Modal -->
                      <div class="modal fade" id="deleteModal' . $row['idcestaBasica'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idcestaBasica'] . '" aria-hidden="true" >
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
                      </td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        }
    }
  

 	public function InsertCestas($nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta, $ativo){
    
    //$valor = str_replace(',', '.', $valor);

 		$query = "INSERT INTO `cestabasica`(`idcestaBasica`, `nome`, `descricao`, `valor`, `categoriaCesta_idcategoriaCesta`, `ativo`, `public`) VALUES (NULL, '$nomeCesta','$descricao', '$valor', '$categoriaCesta_idcategoriaCesta', '$ativo', '1')";
 		if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){
      return mysqli_insert_id($this->SQL);
 			header('Location: ../../views/cestabasica/index.php?alert=1');
 		}else{
 			header('Location: ../../views/cestabasica/index.php?alert=0');
 		}
 	}//InsertItens

   public function insertProdutoNaCesta($idcestaBasica, $idProduto, $quantidade) {
    $query = "INSERT INTO `cestabasica_has_produto` (`cestaBasica_idcestaBasica`, `produto_idproduto`, `quantidade`) 
              VALUES ('$idcestaBasica', '$idProduto', '$quantidade')";
    mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
    }

    public function listCestas($value = NULL){

      $query = "SELECT *FROM `cestabasica`  WHERE `ativo` = 1 AND `public` = 1" ;
      $result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));
 
      if($result){
      
        while ($row = mysqli_fetch_array($result)) {
         if($value == $row['idcestaBasica']){ 
           $selected = "selected";
         }else{
           $selected = "";
         }
          echo '<option value="'.$row['idcestaBasica'].'" '.$selected.' >'.$row['nome'].' | cód: '.$row['idcestaBasica'].'</option>';
        }
 
    }
  }

  public function getCestaById($idCesta)
  {
    // Consulta para obter as informações da cesta básica
    $queryCesta = "SELECT idcestaBasica, nome, descricao, valor 
                   FROM cestabasica 
                   WHERE idcestaBasica = '$idCesta'";
    $resultCesta = mysqli_query($this->SQL, $queryCesta) or die(mysqli_error($this->SQL));

    if ($resultCesta && mysqli_num_rows($resultCesta) > 0) {
        $cesta = mysqli_fetch_assoc($resultCesta);

        // Consulta para obter os produtos que compõem a cesta
        $queryProdutos = "SELECT p.idproduto, p.nome AS nome_produto, cbp.quantidade 
                          FROM produto p
                          JOIN cestabasica_has_produto cbp ON p.idproduto = cbp.produto_idproduto
                          WHERE cbp.cestaBasica_idcestaBasica = '$idCesta'";
        $resultProdutos = mysqli_query($this->SQL, $queryProdutos) or die(mysqli_error($this->SQL));

        $produtos = [];
        while ($row = mysqli_fetch_assoc($resultProdutos)) {
            $produtos[] = $row;
        }

        // Adiciona os produtos ao array da cesta
        $cesta['produtos'] = $produtos;

        return $cesta;
    }

    return null;
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

  public function updateCestas($idcestaBasica, $nomeCesta, $descricao, $valor, $categoriaCesta_idcategoriaCesta, $produtosSelecionados, $quantidades, $ativo)
  {
      // Atualiza os dados da cesta
      $queryUpdateCesta = "UPDATE `cestabasica` SET 
                  `nome`= '$nomeCesta',
                  `descricao`= '$descricao',
                  `valor`= '$valor',
                  `categoriaCesta_idcategoriaCesta`= '$categoriaCesta_idcategoriaCesta',
                  `ativo` = '$ativo'
                WHERE `idcestaBasica`= '$idcestaBasica'";
  
      mysqli_query($this->SQL, $queryUpdateCesta) or die(mysqli_error($this->SQL));
  
      // Remove os produtos anteriores da cesta para inserir os novos
      $queryDeleteProdutos = "DELETE FROM `cestabasica_has_produto` WHERE `cestaBasica_idcestaBasica` = '$idcestaBasica'";
      mysqli_query($this->SQL, $queryDeleteProdutos) or die(mysqli_error($this->SQL));
  
      // Insere os produtos selecionados com as quantidades corretas
      foreach($produtosSelecionados as $idProduto) {
          // Verifica se existe uma quantidade definida para o produto
          $quantidade = isset($quantidades[$idProduto]) ? $quantidades[$idProduto] : 1;
  
          // Insere cada produto com sua quantidade
          $this->insertProdutoNaCesta($idcestaBasica, $idProduto, $quantidade);
      }
  
      // Redireciona para a página de visualização das cestas
      header('Location: ../../views/cestabasica/index.php?alert=update_sucesso');
  }

  public function InsertCestaVendida($idCesta, $idvenda, $data_venda, $quantidade)
  {
      $query = "INSERT INTO `cestabasica_has_venda`(`cestaBasica_idcestaBasica`, `venda_idvenda`, `quantidade`, `dataVenda`) VALUES ('$idCesta','$idvenda', '$quantidade', '$data_venda')";
        if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

          header('Location: ../../views/vendas/index.php?alert=sucesso');
        }else{
          header('Location: ../../views/vendas/index.php?alert=0');
        }
  }
  

  public function deleteCestas($idcestaBasica)
  {
    //$queryDeleteProdutos = "DELETE FROM `cestabasica_has_produto` WHERE `cestaBasica_idcestaBasica` = '$idcestaBasica'";
    //mysqli_query($this->SQL, $queryDeleteProdutos) or die(mysqli_error($this->SQL));

    $query = "UPDATE `cestabasica` SET `public` = 0 WHERE `idcestaBasica` = '$idcestaBasica'";
    $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    if ($result) {
        // Item deletado com sucesso
        header('Location: ../../views/cestabasica/index.php?alert=deletado');
    } else {
        // Falha ao deletar item
        header('Location: ../../views/cestabasica/index.php?alert=0');
    }
  }


  public function getRelatorioCestas() {
    $query = "SELECT 
                c.idcestaBasica, 
                c.nome AS nome_cesta, 
                c.descricao, 
                c.valor, 
                c.ativo, 
                cat.nome AS nome_categoria,
                GROUP_CONCAT(p.nome SEPARATOR ', ') AS itensCesta,
                GROUP_CONCAT(cbp.quantidade SEPARATOR ', ') AS quantidades
              FROM cestabasica c
              JOIN categoriaCesta cat ON c.categoriaCesta_idcategoriaCesta = cat.idcategoriaCesta
              JOIN cestabasica_has_produto cbp ON c.idcestaBasica = cbp.cestaBasica_idcestaBasica
              JOIN produto p ON cbp.produto_idproduto = p.idproduto
              WHERE c.public = 1
              GROUP BY c.idcestaBasica";
    
    $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
    return $result;
  }


  public function cestasAtivo($value, $idcestaBasica)
  {

    if($value == 0){ $v = 1; }else{ $v = 0; }

    $query = "UPDATE `cestabasica` SET `ativo` = '$v' WHERE `idcestaBasica` = '$idcestaBasica'";
    $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
       
    header('Location: ../../views/cestabasica/');
  
  }//ItensAtivo



 }

 $cestas = new Cestas;