<?php

/*
 Class produtos
*/

 require_once 'connect.php';

  class Categorias extends Connect
 {
 	
	public function index($value)
	{
		$query = "SELECT idcategoriaCesta, nome, ativo, public 
				FROM `categoriacesta` 
				WHERE `public` = 1 AND `ativo` = '$value'";
		$result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

		if ($result) {
			echo '<table class="table table-striped">';
			echo '<thead>
					<tr>
						<th>ID</th>
						<th>Nome da Categoria</th>
						<th>Ativo</th>
						<th>Opções</th>
					</tr>
				</thead>';
			echo '<tbody>';

			while ($row = mysqli_fetch_array($result)) {
				$ativo_class = ($row['ativo'] == 0) ? 'class="warning"' : '';

				echo '<tr ' . $ativo_class . '>';
				echo '<td>' . $row['idcategoriaCesta'] . '</td>';
				echo '<td>' . $row['nome'] . '</td>';
				echo '<td>' . ($row['ativo'] == 1 ? 'Sim' : 'Não') . '</td>';

				echo '<td>
						<a href="editcategoria.php?id=' . $row['idcategoriaCesta'] . '" class="btn btn-primary btn-sm">Editar</a>
						<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['idcategoriaCesta'] . '">Excluir</button>

								<!-- Modal -->
								<div class="modal fade" id="deleteModal' . $row['idcategoriaCesta'] . '" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel' . $row['idcategoriaCesta'] . '" aria-hidden="true" >
								<div class="modal-dialog" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="deleteModalLabel' . $row['idcategoriaCesta'] . '">Excluir Categoria</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										Você tem certeza que deseja excluir a categoria <strong>' . $row['nome'] . '</strong>?
									</div>
									<div class="modal-footer">
										<form action="../../App/Database/delcategoria.php" method="POST">
										<input type="hidden" name="idcategoriaCesta" value="' . $row['idcategoriaCesta'] . '">
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

	

 	public function listCategorias($value = NULL){

 		$query = "SELECT *FROM `categoriacesta`  WHERE `ativo` = 1 AND `public` = 1" ;
 		$result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL));

 		if($result){
 		
 			while ($row = mysqli_fetch_array($result)) {
        if($value == $row['idcategoriaCesta']){ 
          $selected = "selected";
        }else{
          $selected = "";
        }
 				echo '<option value="'.$row['idcategoriaCesta'].'" '.$selected.' >'.$row['nome'].'</option>';
 			}

 	}
 }

 	public function InsertCategoria($nomeCategoria, $ativo){

 		$query = "INSERT INTO `categoriacesta`(`idcategoriaCesta`, `nome`, `ativo`, `public`) VALUES (NULL,'$nomeCategoria', '$ativo', '1')";
 		if($result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL))){

 			header('Location: ../../views/categoria/index.php?alert=1');
 		}else{
 			header('Location: ../../views/categoria/index.php?alert=0');
 		}


 	}

	public function editCategoria($idcategoriaCesta){
		$query = "SELECT *FROM `categoriacesta` WHERE `idcategoriaCesta` = '$idcategoriaCesta'";
 		if($result = mysqli_query($this->SQL, $query) or die ( mysqli_error($this->SQL))){

			if($row = mysqli_fetch_array($result)){
				$nomeCategoria = $row['nome'];
				$ativo = $row['ativo'];

				$array = array('Categoria'=> [ 'nome' => $nomeCategoria, 'ativo' => $ativo]);
				
				return $array;
			}
		}else{
			return 0;
		}
	}

	public function updateCategoria($idcategoriaCesta, $nomeCategoria, $ativo){
		$query = "UPDATE `categoriacesta` SET `nome` = '$nomeCategoria', `ativo` = '$ativo'
		WHERE `idcategoriaCesta` = '$idcategoriaCesta'";
    	$result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    if ($result) {
        header('Location: ../../views/categoria/index.php?alert=1');
    } else {
        header('Location: ../../views/categoria/index.php?alert=0');
    }
	}
	

	public function deleteCategoria($idcategoriaCesta){
		if(mysqli_query($this->SQL, "UPDATE `categoriacesta` SET `public` = 0 WHERE `idcategoriaCesta` = '$idcategoriaCesta'") or die ( mysqli_error($this->SQL))){
			header('Location: ../../views/categoria/index.php?alert=1');
		} else {
			header('Location: ../../views/categoria/index.php?alert=0');
		}
		
	}

	public function categoriaAtivo($value, $idcategoriaCesta)
	{
  
	  if($value == 0){ $v = 1; }else{ $v = 0; }
  
	  $query = "UPDATE `categoriacesta` SET `ativo` = '$v' WHERE `idcategoriaCesta` = '$idcategoriaCesta'";
	  $result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));
		 
	  header('Location: ../../views/categoria/');
	}

 }

 $categorias = new Categorias;