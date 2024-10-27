<?php

/*
 Class produtos
*/

require_once 'connect.php';


class Produtos extends Connect
{
 	
    public function index($value)
    {
        $query = "SELECT * FROM `produto` WHERE `public` = 1 AND `ativo` = '$value'";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
    
        if ($result) {
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Quantidade</th>
                        <th>Descrição</th>
                        <th>Ativo</th>
                        <th>Opções</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
    
            while ($row = mysqli_fetch_array($result)) {
                $ativo_class = ($row['ativo'] == 0) ? 'class="label-warning"' : '';
                $quantidade_class = ($row['quantidade'] < 10) ? 'class="danger"' : '';
                $text_quantidade_class = ($row['quantidade'] < 10) ? 'class="text-danger"' : '';
    
                echo '<tr ' . $ativo_class . ' ' . $quantidade_class . '>';
                echo '<td>' . $row['idproduto'] . '</td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['valor'] . '</td>';
                echo '<td ' . $text_quantidade_class . '>' . $row['quantidade'] . '</td>';
                echo '<td>' . $row['descricao'] . '</td>';
                echo '<td>' . ($row['ativo'] == 1 ? 'Sim' : 'Não') . '</td>';
                
                echo '<td>
                        <a href="editproduto.php?id=' . $row['idproduto'] . '" class="btn btn-primary btn-sm">Editar</a>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idproduto'] . '">Excluir</button>
    
                           <!-- Modal -->
                      <div class="modal fade" id="deleteModal' . $row['idproduto'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idproduto'] . '" aria-hidden="true" >
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
                      </td>';
                echo '</tr>';
            }
    
            echo '</tbody>';
            echo '</table>';
        }
    }
    
  

  public function listProdutosCheckbox($produtosSelecionados = []) {
    $query = "SELECT * FROM `produto` WHERE `ativo` = 1 AND `public` = 1";
    $result = mysqli_query($this->SQL, $query) or die (mysqli_error($this->SQL));

    if($result) {
        echo '<table class="table table-bordered">';
        echo '<thead>
                <tr>
                    <th>Selecionar</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                </tr>
            </thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_array($result)) {
            // Verificar se o produto está na cesta (caso seja edição)
            $checked = array_key_exists($row['idproduto'], $produtosSelecionados) ? "checked" : "";
            $quantidade = $checked ? $produtosSelecionados[$row['idproduto']] : 1;

          
            // Supondo que você esteja em um loop para listar produtos
            echo '<tr>';
            echo '<td><input class="form-check-input" type="checkbox" name="produtos[]" value="'.$row['idproduto'].'" onchange="verificarSelecionados()" '.$checked.'></td>';
            echo '<td><label class="form-check-label">'.$row['nome'].'</label></td>';
            echo '<td><input type="number" name="quantidade['.$row['idproduto'].']" class="quantidade" min="1" max="10" value="'.$quantidade.'" '.($checked ? '' : 'disabled').'> unidades</td>';
            echo '</tr>';

            
            
            }

            echo '</tbody>';
            echo '</table>';
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
            $this->verificarEstoque($idproduto);
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
        $this->verificarEstoque($idproduto);
        header('Location: ../../views/produto/index.php?alert=update_sucesso');
    } else {
        header('Location: ../../views/produto/index.php?alert=0');
    }
	}

    public function verificarEstoque($idproduto) {
        $query = "SELECT nome, quantidade, quantidade_minima FROM `produto` WHERE `idproduto` = '$idproduto'";
        $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
    
        if ($produto = mysqli_fetch_assoc($result)) {
            if ($produto['quantidade'] <= $produto['quantidade_minima']) {
                // Adicione a lógica de notificação aqui, exemplo:
                $_SESSION['notificacoes'][] = "O produto " . $produto['nome'] . " está com estoque baixo. Apenas " . $produto['quantidade'] . " unidades restantes.";
            }
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

