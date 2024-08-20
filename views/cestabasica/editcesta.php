<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/categoria.class.php';
//require_once '../../App/Models/fabricante.class.php';
require_once '../../App/Models/cestas.class.php';

if(isset($_POST['idcestaBasica'])){

$resp = $cestas->editCestas($_POST['idcestaBasica']);


echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';

echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Adicionar <small>Produtos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cestas Básicas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">';


echo ' 
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cesta Básica</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="../../App/Database/insertcesta.php" method="POST">
              <div class="box-body">
              	<div class="form-group">
                  <label for="exampleInputEmail1">Nome da Cesta</label>

            <select class="form-control" name="codCesta">
            ';
            $categoria->listCategorias($resp['Cestas']['categoriaCesta_idcategoriaCesta']);
            echo '</select>
            </div>


                <div class="form-group">
                  <label for="exampleInputEmail1">Nome Cesta</label>
                  <input type="text" name="nomeCesta" class="form-control" id="exampleInputEmail1" placeholder="Nome da Cesta" value="'.$resp['Cestas']['nome'].'">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Descrição</label>
                  <input type="text" name="descricao" class="form-control" id="exampleInputEmail1" placeholder="Descrição..." value="'.$resp['Cestas']['descricao'].'">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Valor</label>
                  <input type="text" name="valor" class="form-control" id="exampleInputEmail1" placeholder="R$" value="'.$resp['Cestas']['valor'].'">
                </div>
           
                 <input type="hidden" name="iduser" value="'.$idUsuario.'">
                 <input type="hidden" name="idcestaBasica" value="'.$resp['Cestas']['idcestaBasica'].'">


              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Cadastrar</button>
                <a class="btn btn-danger" href="../../views/cestabasica">Cancelar</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
</div>';

echo '</div>';
echo '</div>';
echo '</section>';
echo '</div>';
echo  $footer;
echo $javascript;
}else{
	header('Location: ./');
}
?>