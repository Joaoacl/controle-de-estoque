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
        Adicionar <small>Produto</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Produto</li>
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
              <h3 class="box-title">Produto</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <form role="form" action="../../App/Database/insertprod.php" method="POST" onsubmit="removerEspacos()">
              <div class="box-body">
   
                  <label for="exampleInputEmail1">Nome Produto</label>
                  <input type="text" name="nomeproduto" class="form-control" id="exampleInputEmail1" placeholder="Nome Produto" maxlength="45">
                
                  
                  <label for="exampleInputEmail1">Descrição</label>
                  <input type="text" name="descricaoproduto" class="form-control" id="exampleInputEmail1" placeholder="Breve Descrição..." maxlength="45">
             
                  
                  <label for="exampleInputEmail1">Valor</label>
                  <input type="text" name="valorproduto" class="form-control" id="exampleInputEmail1" placeholder="R$" oninput="mascaraValor(this)">
                

                  <label for="exampleInputEmail1">Quantidade</label>
                  <input type="number" name="quantidadeproduto" class="form-control" id="exampleInputEmail1" placeholder="Quantidade" min="1" oninput="validarQuantidade(this)" onchange="validarQuantidadeFinal(this)">
                </div>


                <input type="hidden" name="iduser" value="'.$idUsuario.'">


              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Cadastrar</button>
                <a class="btn btn-danger" href="../../views/produto">Cancelar</a>
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

<script>
function validarQuantidade(input) {
    // Garante que o valor sempre seja positivo enquanto digita
    if (input.value < 0) {
        input.value = Math.abs(input.value);
    }
}

function validarQuantidadeFinal(input) {
    // Corrige o valor final para 0 se estiver em branco ou negativo ao sair do campo
    if (input.value === "" || input.value < 0) {
        input.value = 1;
        alert("A quantidade não pode ser negativa ou vazia.");
    }
}
</script>