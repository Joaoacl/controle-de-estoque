<?php

/*
 Class produtos
*/

 require_once 'connect.php';

  class Categorias extends Connect
 {
 	
 	public function index()
 	{
 		$query = "SELECT *FROM `categoriacesta`";
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
                  <form class="badge" name="ativ'.$row['idcategoriaCesta'].'" action="action.php" method="post">
                  <input type="hidden" name="id" id="id" value="'.$row['idcategoriaCesta'].'">

                  <input type="hidden" name="status" id="status" value="'.$row['ativo'].'">
                  <input type="checkbox" id="status" name="status" ';
                   if($row['ativo'] == 1){ echo 'checked'; } 
                  echo ' value="'.$row['ativo'].'" onclick="this.form.submit();"></form>
                  <!-- todo text -->
                  <span class="text"> '.$row['nome'].'</span>
				  
                  <!-- Emphasis label -->
                  <!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->
                  <!-- General tools such as edit or delete-->
                 <div class="tools d-flex justify-content-around">
                    <a href="editcategoria.php?id='.$row['idcategoriaCesta'].'" class="btn btn-outline-primary btn-sm" title="Editar"><i class="fa fa-edit fa-lg"></i></a>
                    <a href="deletecategoria.php?id='.$row['idcategoriaCesta'].'" class="btn btn-outline-danger btn-sm" title="Excluir"><i class="fa fa-trash-o fa-lg"></i></a>
                  </div>
                </li>';
                 				
 			}
 			
 		}

 	}

 	public function listCategorias($value = NULL){

 		$query = "SELECT *FROM `categoriacesta`";
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

 	public function InsertCategoria($nomeCategoria){

 		$query = "INSERT INTO `categoriacesta`(`idcategoriaCesta`, `nome`, `ativo`) VALUES (NULL,'$nomeCategoria', '1')";
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
				$array = array('Categoria'=> [ 'nome' => $nomeCategoria ]);
				
				return $array;
			}
		}else{
			return 0;
		}
	}

	public function updateCategoria($idcategoriaCesta, $nomeCategoria){
		$query = "UPDATE `categoriacesta` SET `nome` = '$nomeCategoria' WHERE `idcategoriaCesta` = '$idcategoriaCesta'";
    	$result = mysqli_query($this->SQL, $query) or die(mysqli_error($this->SQL));

    if ($result) {
        header('Location: ../../views/categoria/index.php?alert=1');
    } else {
        header('Location: ../../views/categoria/index.php?alert=0');
    }
	}
	

	public function deleteCategoria($idcategoriaCesta){
		if(mysqli_query($this->SQL, "DELETE FROM `categoriacesta` WHERE `idcategoriaCesta` = '$idcategoriaCesta'") or die ( mysqli_error($this->SQL))){
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