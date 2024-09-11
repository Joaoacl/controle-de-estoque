<?php

/*
 Class produtos
*/

require_once 'connect.php';

class Produtos extends Connect
{
 	
 	public function index()
 	{
 		$query = "SELECT *FROM `produto`";
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
                  <form class="text" name="ativ'.$row['idproduto'].'" action="action.php" method="post">
                  <input type="hidden" name="id" id="id" value="'.$row['idproduto'].'">

                  <input type="hidden" name="status" id="status" value="'.$row['ativo'].'">
                  <input type="checkbox" id="status" name="status" ';
                   if($row['ativo'] == 1){ echo 'checked'; } 
                  echo ' value="'.$row['ativo'].'" onclick="this.form.submit();"></form>
                  <!-- todo text -->
                  <span class="text badge"> '.$row['nome'].'</span>
                  <span class="text">R$'.$row['valor'].'</span>
                  <span class="text">| Qtd: '.$row['quantidade'].'</span>
				   <span class="text">| Descrição: '.$row['descricao'].'</span>

                  <!-- Emphasis label -->
                  <!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->
                  <!-- General tools such as edit or delete-->
                 <div class="tools d-flex justify-content-around">
                    <a href="editproduto.php?id='.$row['idproduto'].'" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fa fa-edit fa-lg"></i></a>
                    <a href="deleteproduto.php?id='.$row['idproduto'].'" class="btn btn-outline-danger btn-sm" title="Excluir"><i class="fa fa-trash-o fa-lg"></i></a>
                  </div>
                </li>';
                 				
 			}
 			
 		}

 	}

     public function listProdutosCheckbox($produtosSelecionados = []) {
        $query = "SELECT * FROM `produto` WHERE `ativo` = 1";
        $result = mysqli_query($this->SQL, $query) or die (mysqli_error($this->SQL));
    
        if($result) {
            while ($row = mysqli_fetch_array($result)) {
                $checked = in_array($row['idproduto'], $produtosSelecionados) ? "checked" : "";
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="checkbox" name="produtos[]" value="'.$row['idproduto'].'" '.$checked.'>';
                echo '<label class="form-check-label">'.$row['nome'].'</label>';
                echo '</div>';
            }
        }
    }

	public function getProdutosPorCesta($idcestaBasica)
	{
    $produtos = [];
    $query = "SELECT produto_idproduto FROM `cestabasica_has_produto` WHERE `cestaBasica_idcestaBasica` = '$idcestaBasica'";
    $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row['produto_idproduto'];
    }

    return $produtos; 
	}
 	public function InsertProdutos($nomeProduto, $descricao, $valor, $quantidade){

 		$query = "INSERT INTO `produto`(`idproduto`, `nome`, `valor`, `quantidade`, `descricao`, `ativo`) VALUES (NULL,'$nomeProduto', '$valor', '$quantidade', '$descricao', '1')";
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
				$array = array('Produto'=> [ 'nome' => $nomeProduto, 'valor' => $valor, 'quantidade' => $quantidade, 'descricao' => $descricao]);
				
				return $array;
			}
		}else{
			return 0;
		}
	}

	public function updateProduto($idproduto, $nomeProduto, $valor, $quantidade, $descricao){
		$query = "UPDATE `produto` SET `nome` = '$nomeProduto', `valor` = '$valor', `quantidade` = '$quantidade', `descricao` = '$descricao' WHERE `idproduto` = '$idproduto'";
    	$result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    if ($result) {
        header('Location: ../../views/produto/index.php?alert=1');
    } else {
        header('Location: ../../views/produto/index.php?alert=0');
    }
	}
	

	public function deleteProduto($idproduto){
		if(mysqli_query($this->SQL, "DELETE FROM `produto` WHERE `idproduto` = '$idproduto'") or die ( mysqli_error($this->SQL))){
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