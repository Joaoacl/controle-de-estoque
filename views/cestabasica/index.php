<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/cestas.class.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">
		<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cestas Básicas
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cestas Básicas</li>
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

              <h3 class="box-title">Lista de Cestas Básicas</h3>

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
               $cestas->index();
              
        echo '</ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a href="'.$url.'cestabasica/addcesta.php" type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add Cestas</a>
            </div>
          </div>
	 
';
echo '</div>';
echo '</section>';
      
       
	  

echo '</div>';

echo  $footer;
echo $javascript;
?>

