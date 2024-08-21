<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/cestas.class.php';
require_once '../../App/Models/categoria.class.php';



echo $head;
echo $header;
echo $aside;

echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar <small>Cesta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Editar Cesta</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">';

echo ' <a href="./" class="btn btn-success">Voltar</a>
      <div class="row">
        <!-- left column -->
';
        
        if(isset($_GET['id'])){
            $idcestaBasica = $_GET['id'];
            $resp = $cestas->editCestas($idcestaBasica);

echo'
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
                  <input type="text" name="nomecesta" class="form-control" id="exampleInputEmail1" placeholder="Nome Cesta" value="'.$resp['Cestas']['nome'].'">
                
                  <label for="exampleInputEmail1">Descrição</label>
                  <input type="text" name="descricao" class="form-control" id="exampleInputEmail1" placeholder="Descrição" value="'.$resp['Cestas']['descricao'].'">

                  <label for="exampleInputEmail1">Valor</label>
                  <input type="text" name="valor" class="form-control" id="exampleInputEmail1" placeholder="R$" value="'.$resp['Cestas']['valor'].'">

                  <label for="exampleInputEmail1">Categoria Cesta</label>
                  <select name="codCesta" class="form-control" id="categoria">';

                  $categorias->listCategorias($resp['Cestas']['categoriaCesta_idcategoriaCesta']);

echo            '
                </select>
                </div>
                <input type="hidden" name="idcestaBasica" value="'.$idcestaBasica.'">
                 <input type="hidden" name="iduser" value="'.$idUsuario.'">
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Alterar</button>
                <a class="btn btn-danger" href="../../views/cestabasica">Cancelar</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
</div>';
        }//if
echo '</div>';
echo '</div>';
echo '</section>';
echo '</div>';
echo  $footer;
echo $javascript;
?>