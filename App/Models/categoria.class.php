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
                  <input type="checkbox" value="'.$row['idcategoriaCesta'].'">
                  <!-- todo text -->
                  <span class="text"><span class="badge left">'.$row['idcategoriaCesta'].'</span> '.$row['nome'].'</span>
				  
                  <!-- Emphasis label -->
                  <!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
                    <a href="editcategoria.php?id='.$row['idcategoriaCesta'].'"><i class="fa fa-edit"></i></a>
                    <i class="fa fa-trash-o"></i>
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

 		$query = "INSERT INTO `categoriacesta`(`idcategoriaCesta`, `nome`) VALUES (NULL,'$nomeCategoria')";
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

	public function delCategoria($idcategoriaCesta){
		if(mysqli_query($this->SQL, "DELETE FROM `categoriacesta` WHERE `idcategoriaCesta` = '$idcategoriaCesta'") or die ( mysqli_error($this->SQL))){
			header('Location: ../../views/categoria/index.php?alert=1');
		} else {
			header('Location: ../../views/categoria/index.php?alert=0');
		}
		
	}

 }

 $categorias = new Categorias;