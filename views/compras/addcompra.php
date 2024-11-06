<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/produto.class.php';
require_once '../../App/Models/fornecedor.class.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';
echo '
<section class="content-header">
  <h1>Realizar <small>Solicitação de Compra</small></h1>
  <ol class="breadcrumb">
    <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Solicitação de Compra</li>
  </ol>
</section>
<section class="content">
  <div class="">
    <a href="./" class="btn btn-success">Voltar</a>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Solicitação de Compra</h3>
          </div>
          <form role="form" action="../../App/Database/insertcompra.php" method="POST" onsubmit="return verificarProdutosSelecionados();">
            <div class="box-body">
              <div class="form-group">
                <label for="codFornecedor">Fornecedor</label>
                <select class="form-control select2" name="codFornecedor" id="codFornecedor" required>
                  <option value="">Selecione um Fornecedor</option>';
                  $fornecedor->listFornecedores();
                  echo '
                </select>
              </div>
              <div class="form-group">
                <label for="codProduto">Produto</label>
                <select class="form-control" name="codProduto" id="codProduto">
                  <option value="">Selecione um Produto</option>';
                  $produtos->listProdutos(); 
                  echo '
                </select>
              </div>
              <div class="form-group">
                <label for="quantidade">Quantidade</label>
                <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" max="1000" value="1">
              </div>
              <button type="button" class="btn btn-primary" onclick="adicionarProduto()">Adicionar Produto</button>
              <div class="form-group">
                <h4>Produtos Selecionados</h4>
                <ul id="listaProdutos"></ul>
              </div>
              <input type="hidden" name="produtosSelecionados" id="produtosSelecionados"> <!-- Produtos em JSON -->
              <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Solicitar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>';
echo '</div>';
echo $footer;
echo $javascript;
?>

<script>
let produtos = [];

function adicionarProduto() {
    const idProduto = document.getElementById('codProduto').value;
    const nomeProduto = document.getElementById('codProduto').selectedOptions[0].text;
    const quantidade = parseInt(document.getElementById('quantidade').value);

    if (idProduto && quantidade > 0) {
        // Calcula o total de produtos adicionados
        const totalQuantidade = produtos.reduce((total, produto) => total + produto.quantidade, 0) + quantidade;

        if (totalQuantidade > 1000) {
            alert("Você não pode adicionar mais de 1000 produtos no total.");
            return;
        }

        const produto = { id: idProduto, nome: nomeProduto, quantidade: quantidade };
        produtos.push(produto);
        atualizarListaProdutos();

        document.getElementById('codProduto').value = '';
        document.getElementById('quantidade').value = 1;
    } else {
        alert("Selecione um produto e defina uma quantidade válida.");
    }
}

function atualizarListaProdutos() {
    const listaProdutos = document.getElementById('listaProdutos');
    listaProdutos.innerHTML = '';

    produtos.forEach((produto, index) => {
        const item = document.createElement('li');
        item.textContent = `${produto.nome} - Quantidade: ${produto.quantidade}`;

        const btnRemover = document.createElement('button');
        btnRemover.textContent = 'Remover';
        btnRemover.className = 'btn btn-danger btn-sm ml-2';
        btnRemover.onclick = () => {
            produtos.splice(index, 1);
            atualizarListaProdutos();
        };

        item.appendChild(btnRemover);
        listaProdutos.appendChild(item);
    });

    document.getElementById('produtosSelecionados').value = JSON.stringify(produtos);
}

function verificarProdutosSelecionados() {
    if (produtos.length === 0) {
        alert("Você precisa adicionar pelo menos um produto para realizar a solicitação de compra.");
        return false; 
    }
    return true; 
}

$(document).ready(function() {
  $("#codFornecedor").select2({
    placeholder: "Selecione um Fornecedor",
    allowClear: true,
    width: "100%" 
  });
});
</script>
