<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/compra.class.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Solicitações de Compra
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Solicitações de Compra</li>
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

              <h3 class="box-title">Lista de Solicitações de Compra</h3>

             <!-- Botão para acessar o relatório de compras -->
              <a href="'.$url.'compras/relatorio_compras.php" class="btn btn-info pull-right">
                <i class="fa fa-file"></i> Relatório de Vendas
              </a>
          
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">';
              $btn_color = "btn-primary";
              $icon = "fa-check-square-o";

              if(isset($_POST['ativo']) != NULL){               

                $value = $_POST['ativo']; 
                if($value == 1){
                 
                  $ativo = 0;
                  $button_name = "Finalizados";              
      
                }else{
                  $ativo = 1;
                  $button_name = "Em andamento";
                  $icon = "fa-tasks";
                  $btn_color = "btn-primary";
                }     
      
              }else{
                $value = 1;
                $ativo = 0;
                $button_name = "Finalizados";
              }
                          
              $compras->index($value);
              
        echo '</ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a href="'.$url.'compras/addcompra.php" type="button" class="btn btn-success pull-right"><i class="fa fa-cart-arrow-down"></i> Solicitar Compra</a>
              <form action="index.php" method="post">
              <button name="ativo" type="submit" value="'.$ativo.'" class="btn '.$btn_color.' pull-left"><i class="fa '.$icon.'"></i> '.$button_name.'</button></form>
            </div>
          </div>
';
echo '</div>';
echo '</section>';
echo '</div>';
echo $footer;
echo $javascript;
?>
