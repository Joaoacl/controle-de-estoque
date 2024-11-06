<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/venda.class.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Vendas
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Vendas</li>
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

              <h3 class="box-title">Lista de Vendas</h3>

      
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">';
              $btn_color = "btn-warning";
              $icon = "fa fa-ban";

              if(isset($_POST['public']) != NULL){               

                $value = $_POST['public']; 
                if($value == 1){
                 
                  $public = 0;
                  $button_name = "Canceladas";              
      
                }else{
                  $public = 1;
                  $button_name = "Ativas";
                  $icon = "fa-check";
                  $btn_color = "btn-primary";
                }     
      
              }else{
                $value = 1;
                $public = 0;
                $button_name = "Cancelados";
              }
              $vendas->index($value);
              
        echo '</ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a href="'.$url.'vendas/addvenda.php" type="button" class="btn btn-success pull-right"><i class="fa fa-cart-plus"></i> Fazer Venda</a>

              <form action="index.php" method="post">
              <button name="public" type="submit" value="'.$public.'" class="btn '.$btn_color.' pull-left"><i class="fa '.$icon.'"></i> '.$button_name.'</button>
              </form>
            </div>
          </div>
';
echo '</div>';
echo '</section>';
echo '</div>';
echo $footer;
echo $javascript;
?>
