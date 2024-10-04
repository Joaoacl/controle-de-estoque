<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/categoria.class.php';

echo $head;
echo $header;
echo $aside;

echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar <small>Categoria</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Editar Categoria</li>
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
            $idcategoriaCesta = $_GET['id'];
            $resp = $categorias->editCategoria($idcategoriaCesta);

echo'
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Categoria</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="../../App/Database/insertcat.php" method="POST" onsubmit="removerEspacos()">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome da Categoria</label>
                  <input type="text" name="nomecategoria" class="form-control" id="exampleInputEmail1" placeholder="Nome Categoria" value="'.$resp['Categoria']['nome'].'" maxlength="45">

                  <label for="ativo">Status da Cesta</label>
                  <select name="ativo" class="form-control" id="ativo">
                    <option value="1" ' . ($resp['Categoria']['ativo'] == 1 ? 'selected' : '') . '>Ativo</option>
                    <option value="0" ' . ($resp['Categoria']['ativo'] == 0 ? 'selected' : '') . '>Inativo</option>
                  </select>

                </div>


                <input type="hidden" name="idcategoriaCesta" value="'.$idcategoriaCesta.'">
                 <input type="hidden" name="iduser" value="'.$idUsuario.'">
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Alterar</button>
                <a class="btn btn-danger" href="../../views/categoria">Cancelar</a>
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