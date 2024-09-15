<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/produto.class.php';

echo $head;
echo $header;
echo $aside;

echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar <small>Produto</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Editar Produto</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="">';

echo ' <a href="./" class="btn btn-success">Voltar</a>
      <div class="row">
        <!-- left column -->
';
        
        if(isset($_GET['id'])){
            $idproduto = $_GET['id'];
            $resp = $produtos->editProduto($idproduto);

echo'
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Produto</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="../../App/Database/insertprod.php" method="POST" onsubmit="removerEspacos()">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome do Produto</label>
                  <input type="text" name="nomeproduto" class="form-control" id="exampleInputEmail1" placeholder="Nome Produto" value="'.$resp['Produto']['nome'].'" maxlength="45">

                  <label for="exampleInputEmail1">Descrição</label>
                  <input type="text" name="descricaoproduto" class="form-control" id="exampleInputEmail1" placeholder="Descrição..." value="'.$resp['Produto']['descricao'].'" maxlength="45">

                  <label for="exampleInputEmail1">Valor</label>
                  <input type="text" name="valorproduto" class="form-control" id="exampleInputEmail1" placeholder="R$" value="'.$resp['Produto']['valor'].'">

                  <label for="exampleInputEmail1">Quantidade</label>
                  <input type="number" name="quantidadeproduto" class="form-control" id="exampleInputEmail1" placeholder="Qtd" value="'.$resp['Produto']['quantidade'].'" oninput="validarQuantidade(this)" onchange="validarQuantidadeFinal(this)">

                 <label for="ativo">Status do Produto</label>
                  <select name="ativo" class="form-control" id="ativo">
                    <option value="1" ' . ($resp['Produto']['ativo'] == 1 ? 'selected' : '') . '>Ativo</option>
                    <option value="0" ' . ($resp['Produto']['ativo'] == 0 ? 'selected' : '') . '>Inativo</option>
                  </select>

                
                </div>
                <input type="hidden" name="idproduto" value="'.$idproduto.'">
                 <input type="hidden" name="iduser" value="'.$idUsuario.'">
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Alterar</button>
                <a class="btn btn-danger" href="../../views/produto">Cancelar</a>
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