<?php

/*
 Class produtos
*/

require_once 'connect.php';


class Produtos extends Connect
{
 	
  public function index($value)
  {
      $query = "SELECT *FROM `produto` WHERE `public` = 1 AND `ativo` = '$value'";
      $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
  
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
                    
                    <!-- todo text -->
                    <span class="text"> '.$row['nome'].'</span>
                    -<span class="text">'.$row['valor'].'</span>
                    <span class="text">| Qtd: '.$row['quantidade'].'</span>
                     <span class="text">| Descrição: '.$row['descricao'].'</span>';
  
              // Verificar se `public` é igual a 1
              if ($row['public'] == 1) {
                  echo '
                  <!-- General tools such as edit or delete-->
                  <div class="tools d-flex justify-content-around">
                      <a href="editproduto.php?id='.$row['idproduto'].'" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fa fa-edit fa-lg"></i></a>
  
                      <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idproduto'] . '" title="Excluir">
                          <i class="fa fa-trash-o fa-lg"></i>
                      </a>
  
                      <!-- Modal -->
                      <div class="modal" id="deleteModal' . $row['idproduto'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idproduto'] . '" aria-hidden="true" >
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModalLabel' . $row['idproduto'] . '">Excluir Produto</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      Você tem certeza que deseja excluir o produto <strong>' . $row['nome'] . '</strong>?
                                  </div>
                                  <div class="modal-footer">
                                      <form action="../../App/Database/delproduto.php" method="POST">
                                          <input type="hidden" name="idproduto" value="' . $row['idproduto'] . '">
                                          <button type="button" name="upload" value="Cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" name="upload" value="Cadastrar" class="btn btn-danger">Excluir</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
              }
  
              echo '</li>';
          }
      }
  }
  

  public function listProdutosCheckbox($produtosSelecionados = []) {
    $query = "SELECT * FROM `produto` WHERE `ativo` = 1 AND `public` = 1";
    $result = mysqli_query($this->SQL, $query) or die (mysqli_error($this->SQL));

    if($result) {
        while ($row = mysqli_fetch_array($result)) {
            // Verificar se o produto está na cesta (caso seja edição)
            $checked = array_key_exists($row['idproduto'], $produtosSelecionados) ? "checked" : "";
            $quantidade = $checked ? $produtosSelecionados[$row['idproduto']] : 1;

            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" name="produtos[]" value="'.$row['idproduto'].'" onchange="verificarSelecionados()" '.$checked.'>';
            echo ' <label class="form-check-label">'.$row['nome'].'</label>';
            echo ' | <input type="number" name="quantidade['.$row['idproduto'].']" class="quantidade" min="1" max="10" value="'.$quantidade.'" '.($checked ? '' : 'disabled').'> unidades';
            echo '</div>';
            }
        }
    }



	public function getProdutosPorCesta($idcestaBasica)
{
    $produtos = [];
    $query = "SELECT produto_idproduto, quantidade FROM `cestabasica_has_produto` WHERE `cestaBasica_idcestaBasica` = '$idcestaBasica'";
    $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[$row['produto_idproduto']] = $row['quantidade']; // Adiciona o ID do produto como chave e a quantidade como valor
    }

    return $produtos; 
    }

	
 	public function InsertProdutos($nomeProduto, $descricao, $valor, $quantidade, $ativo){

		$valor = str_replace(',', '.', $valor);
		
 		$query = "INSERT INTO `produto`(`idproduto`, `nome`, `valor`, `quantidade`, `descricao`, `public`, `ativo`) VALUES (NULL,'$nomeProduto', '$valor', '$quantidade', '$descricao', '1', '$ativo')";
 		if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

 			header('Location: ../../views/produto/index.php?alert=1');
 		}else{
 			header('Location: ../../views/produto/index.php?alert=0');
 		}


 	}

	public function editProduto($idproduto){
		$query = "SELECT *FROM `produto` WHERE `idproduto` = '$idproduto'";
 		if($result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL))){

			if($row = mysqli_fetch_array($result)){
				$nomeProduto = $row['nome'];
				$valor = $row['valor'];
				$quantidade = $row['quantidade'];
				$descricao = $row['descricao'];
        $ativo = $row['ativo'];
				$array = array('Produto'=> [ 'nome' => $nomeProduto, 'valor' => $valor, 'quantidade' => $quantidade, 'descricao' => $descricao, 'ativo' => $ativo]);
				
				return $array;
			}
		}else{
			return 0;
		}
	}

	public function updateProduto($idproduto, $nomeProduto, $valor, $quantidade, $descricao, $ativo){
		$query = "UPDATE `produto` SET `nome` = '$nomeProduto', `valor` = '$valor', `quantidade` = '$quantidade', `descricao` = '$descricao', `ativo` = '$ativo' WHERE `idproduto` = '$idproduto'";
    	$result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    if ($result) {
        header('Location: ../../views/produto/index.php?alert=1');
    } else {
        header('Location: ../../views/produto/index.php?alert=0');
    }
	}
	

	public function deleteProduto($idproduto){
		if(mysqli_query($this->SQL, "UPDATE `produto` SET `public` = 0 WHERE `idproduto` = '$idproduto'") or die ( mysqli_error($this->SQL))){
			header('Location: ../../views/produto/index.php?alert=1');
		} else {
			header('Location: ../../views/produto/index.php?alert=0');
		}
		
	}

	public function produtosAtivo($value, $idproduto)
	{
  
	  if($value == 0){ $v = 1; }else{ $v = 0; }
  
	  $query = "UPDATE `produto` SET `ativo` = '$v' WHERE `idproduto` = '$idproduto'";
	  $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
		 
	  header('Location: ../../views/produto/');
	}
    

}

 $produtos = new Produtos;

