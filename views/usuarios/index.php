<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/usuario.class.php'; //models cliente

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">
		<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Usuários
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Usuários</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    ';
    require '../../layout/alert.php';
   
    echo '
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Lista de Usuários</h3>

              <div class="box-tools pull-right">
                <ul class="pagination pagination-sm inline">
                  <li><a href="#">&laquo;</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">';
              $btn_color = "btn-primary";
              $icon = "fa fa-filter";
              if($perm == 1){
                
              if(isset($_POST['ativo']) != NULL){               

                $value = $_POST['ativo']; 
                if($value == 1){
                 
                  $ativo = 0;
                  $button_name = "Inativos";              
      
                }else{
                  $ativo = 1;
                  $button_name = "Publicados";
                  $icon = "fa-check";
                  $btn_color = "btn-primary";
                }     
      
              }else{
                $value = 1;
                $ativo = 0;
                $button_name = "Inativos";
              }
                     
                $usuario->index($perm, $value);
              
               
              
        echo '</ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a href="addusuarios.php" type="button" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Usuário</a>
              <form action="index.php" method="post">
             
              <button name="ativo" type="submit" value="'.$ativo.'" class="btn '.$btn_color.' pull-left"><i class="fa '.$icon.'"></i> '.$button_name.'</button></form>
             
            </div>
          </div>
	 
';
            }else{
              echo'Você não possui acesso!';
            }
echo '</div>';
echo '</section>';
      
       
	  

echo '</div>';

echo  $footer;
echo $javascript;
?>

