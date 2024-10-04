<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/cestas.class.php';
require_once '../../App/Models/categoria.class.php';
require_once '../../App/Models/produto.class.php';


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
      <div class="">';

echo ' <a href="./" class="btn btn-success">Voltar</a>
      <div class="row">
        <!-- left column -->
';
        
        if(isset($_GET['id'])){
            $idcestaBasica = $_GET['id'];
            $resp = $cestas->editCestas($idcestaBasica);
            $produtosSelecionados = $produtos->getProdutosPorCesta($idcestaBasica);

echo'
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

                  <label for="exampleInputEmail1">ID da Cesta</label>
                  <input type="text" name="idcestaBasica" class="form-control" id="exampleInputEmail1" value="'.$resp['Cestas']['idcestaBasica'].'" readonly>

                  <label for="exampleInputEmail1">Nome da Cesta</label>
                  <input type="text" name="nomecesta" class="form-control" id="exampleInputEmail1" placeholder="Nome Cesta" value="'.$resp['Cestas']['nome'].'" maxlength="45">
                
                  <label for="exampleInputEmail1">Descrição</label>
                  <input type="text" name="descricao" class="form-control" id="exampleInputEmail1" placeholder="Descrição" value="'.$resp['Cestas']['descricao'].'" maxlength="45">

                  <label for="exampleInputEmail1">Valor</label>
                  <input type="text" name="valor" class="form-control" id="exampleInputEmail1" placeholder="R$" value="'.$resp['Cestas']['valor'].'" oninput="mascaraValor(this)" onchange="validarValorFinal(this)">

                  <label for="exampleInputEmail1">Categoria Cesta</label>
                  <select name="codCesta" class="form-control" id="categoria">';

                  $categorias->listCategorias($resp['Cestas']['categoriaCesta_idcategoriaCesta']);

echo            '</select>

                <label for="ativo">Status da Cesta</label>
                  <select name="ativo" class="form-control" id="ativo">
                    <option value="1" ' . ($resp['Cestas']['ativo'] == 1 ? 'selected' : '') . '>Ativo</option>
                    <option value="0" ' . ($resp['Cestas']['ativo'] == 0 ? 'selected' : '') . '>Inativo</option>
                  </select>

                </div>
                <div class="form-group ">
                  <label for="produtos">Produtos da Cesta (Selecione os produtos que compõem essa cesta)</label>';
                    $produtos->listProdutosCheckbox($produtosSelecionados);
echo            '
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
