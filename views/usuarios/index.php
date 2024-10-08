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
   
    
    if (isset($_GET['alert'])) {
      if ($_GET['alert'] == 'email_ja_existe') {
          echo '<div class="alert alert-danger">Este email já está cadastrado!</div>';
      } elseif ($_GET['alert'] == 'cpf_ja_existe') {
          echo '<div class="alert alert-danger">CPF já cadastrado!</div>';
      } elseif ($_GET['alert'] == 'campos_obrigatorios') {
          echo '<div class="alert alert-danger">Preencha todos os campos obrigatórios!</div>';
      } elseif ($_GET['alert'] == 'sucesso') {
        echo '<div class="alert alert-success">Usuário adicionado com sucesso!</div>';
      } elseif ($_GET['alert'] == 'update_sucesso') {
        echo '<div class="alert alert-success">Usuário alterado com sucesso!</div>';
      }

  };
  
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
              if($perm == 1){
                $usuario->index($perm);
              }else{
                echo'Você não possui acesso!';
              }
               
              
        echo '</ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a href="addusuarios.php" type="button" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Usuário</a>
            </div>
          </div>
	 
';
echo '</div>';
echo '</section>';
      
       
	  

echo '</div>';

echo  $footer;
echo $javascript;
?>

