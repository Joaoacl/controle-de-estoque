<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Adicionar <small>Clientes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Clientes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">';

echo ' <a href="./" class="btn btn-success">Voltar</a>
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cliente</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="../../App/Database/insertcli.php" method="POST">

              <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputEmail1">Nome do Cliente</label>
                  <input type="text" name="nomecliente" class="form-control" id="exampleInputEmail1" placeholder="Nome Cliente">

                  <label for="exampleInputEmail1">CPF</label>
                  <input type="text" name="cpf" class="form-control" id="exampleInputEmail1" placeholder="CPF">

                  <label for="exampleInputEmail1">Desconto</label>
                  <input type="text" name="desconto" class="form-control" id="exampleInputEmail1" placeholder="Percentual de desconto">

                  
                  <label for="exampleInputEmail1">Email</label>
                  <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">

                  <label for="exampleInputEmail1">Telefone</label>
                  <input type="text" name="telefone" class="form-control" id="exampleInputEmail1" placeholder="Telefone">

                  <h4 >Endereço</h4>

                  <label for="exampleInputEmail1">Rua</label>
                  <input type="text" name="rua" class="form-control" id="exampleInputEmail1" placeholder="Rua" required>

                  <label for="exampleInputEmail1">Número</label>
                  <input type="text" name="numero" class="form-control" id="exampleInputEmail1" placeholder="Número" required>

                  <label for="exampleInputEmail1">Bairro</label>
                  <input type="text" name="bairro" class="form-control" id="exampleInputEmail1" placeholder="Bairro" required>

                  <label for="exampleInputEmail1">Cidade</label>
                  <input type="text" name="cidade" class="form-control" id="exampleInputEmail1" placeholder="Cidade" required>

                  <label for="exampleInputEmail1">Estado</label>
                  <input type="text" name="estado" class="form-control" id="exampleInputEmail1" placeholder="Ex: SP, MG, PR" required>

                  <label for="exampleInputEmail1">CEP</label>
                  <input type="text" name="cep" class="form-control" 
                  id="exampleInputEmail1" placeholder="CEP" required>

                </div>
                
                </div>
                 <input type="hidden" name="iduser" value="'.$idUsuario.'">
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Cadastrar</button>
                <a class="btn btn-danger" href="../../views/clientes">Cancelar</a>
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
?>