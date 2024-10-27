<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/categoria.class.php';
require_once '../../App/Models/produto.class.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Adicionar <small>Cesta Básica</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Cesta Básica</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="">';

echo ' <a href="./" class="btn btn-success">Voltar</a>
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
            <form role="form" action="../../App/Database/insertcesta.php" method="POST" onsubmit="removerEspacos()">
              <div class="box-body">

                 <div class="form-group">
                  <label for="exampleInputEmail1">Nome Cesta</label>
                  <input type="text" name="nomecesta" class="form-control" id="exampleInputEmail1" placeholder="Nome Cesta" maxlength="45" required>
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Descrição</label>
                  <input type="text" name="descricao" class="form-control" id="exampleInputEmail1" placeholder="Breve Descrição..." maxlength="45" required>
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Valor (R$)</label>
                  <input type="text" name="valor" class="form-control" id="exampleInputEmail1" placeholder="R$" oninput="mascaraValor(this)" onchange="validarValorFinal(this)" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Categoria Cesta</label>

                    <select class="form-control" name="codCesta">
                    ';
                    $categorias->listCategorias();
                    echo '</select>
                </div>

                <div class="form-group">
                  <label for="produtos">Produtos da Cesta (Selecione os produtos que compõem essa cesta e sua quantidade)</label>
                  <form id="formCesta">
                    ';
                    $produtos->listProdutosCheckbox();
                    echo '
                    
                  </form>
                </div>

                <input type="hidden" name="iduser" value="'.$idUsuario.'">


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
?>

<script>
function verificarSelecionados() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const quantidades = document.querySelectorAll('.quantidade');
    let totalSelecionados = 0;

    checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
            quantidades[index].disabled = false;
            totalSelecionados++;
        } else {
            quantidades[index].disabled = true;
            quantidades[index].value = 1; // Reseta o valor da quantidade quando desmarcar
        }
    });

    // Atualiza o contador de itens selecionados
    document.getElementById('totalSelecionados').textContent = totalSelecionados;

    // Se mais de 10 itens estiverem selecionados, desabilita os outros checkboxes
    if (totalSelecionados >= 10) {
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.disabled = true;
            }
        });
    } else {
        checkboxes.forEach(checkbox => {
            checkbox.disabled = false;
        });
    }
}

// Adiciona um evento que chama a função toda vez que um checkbox é alterado
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', verificarSelecionados);
});

// Chama a função logo ao carregar a página para garantir que o estado inicial esteja correto
document.addEventListener('DOMContentLoaded', verificarSelecionados);
</script>
