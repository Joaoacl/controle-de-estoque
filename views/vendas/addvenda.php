<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/cestas.class.php';
require_once '../../App/Models/cliente.class.php';
require_once '../../App/Models/produto.class.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';
echo '<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Realizar <small>Venda</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Realizar Venda</li>
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

      
       echo' <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Realizar Venda</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <form role="form" action="../../App/Database/insertvenda.php" method="POST" onsubmit="removerEspacos()">
              <div class="box-body">

              
                <div class="form-group">
                  <label for="cesta">Selecione a Cesta</label>

                    <select class="form-control" name="codCesta" id="codCesta" onchange="carregarDadosCesta(this.value)">
                    <option value="">Selecione uma cesta</option>
                    ';
                    $cestas->listCestas();
                    echo '</select>
                </div>
              

                <div class="form-group">
                  <label>Descrição da Cesta</label>
                    <p id="descricaoCesta">Selecione uma cesta para ver a descrição e os produtos.</p>
                  </div>
                  <div class="form-group">
                    <label>Produtos da Cesta</label>
                      <ul id="produtosCesta"></ul>
                  </div>
                  <div class="form-group">
                    <label>Valor da Cesta</label>
                    <input type="text" name="valorCesta" class="form-control" id="valorCesta" readonly>
                </div>

                 <div class="form-group">
                  <label for="produtos">Cliente</label>

                  <select class="form-control" name="codCli" id="codCli" onchange="carregarDadosCliente(this.value)">
                  <option value="">Selecione um Cliente</option>
                    ';
                    $clientes->listClientes();
                    echo '</select>
                </div>

                <div class="form-group">
                <label>Desconto do Cliente (%)</label>
                <input type="text" name="desconto" class="form-control" id="descontoCliente" readonly>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Valor Total</label>
                  <input type="text" name="valorTotal" class="form-control" id="valorTotalDesconto" placeholder="R$" oninput="mascaraValor(this)" onchange="validarValorFinal(this)" required>
                </div>

                <div class="form-group">
                  <label for="dataVenda">Data da Venda</label>
                  <input type="date" name="dataVenda" class="form-control" id="dataVenda" required>
                </div>
              
                <input type="hidden" name="iduser" value="'.$idUsuario.'">


              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Finalizar</button>
                <a class="btn btn-danger" href="../../views/vendas">Cancelar</a>
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
function carregarDadosCesta(idCesta) {
    if (idCesta) {
        fetch('getCestaData.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `idCesta=${idCesta}`
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('descricaoCesta').textContent = data.descricao;
            document.getElementById('valorCesta').value = `R$ ${data.valor.replace(".", ",")}`;

            const produtosList = document.getElementById('produtosCesta');
            produtosList.innerHTML = '';
            data.produtos.forEach(produto => {
                const li = document.createElement('li');
                li.textContent = `${produto.nome_produto} - Qtd: ${produto.quantidade}`;
                produtosList.appendChild(li);
            });

            // Recalcular valor total com o desconto do cliente
            const idCliente = document.getElementById('codCli').value;
            carregarDadosCliente(idCliente);
        })
        .catch(error => console.error('Erro ao carregar dados da cesta:', error));
    }
}

function carregarDadosCliente(idCliente) {
    if (idCliente) {
        fetch('getClienteData.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `idCliente=${idCliente}`
        })
        .then(response => response.json())
        .then(data => {
            const desconto = data.desconto ? parseFloat(data.desconto) : 0;
            document.getElementById('descontoCliente').value = desconto;

            // Verificar se o valor da cesta está disponível e válido
            let valorCestaText = document.getElementById('valorCesta').value.replace("R$ ", "").replace(",", ".");
            let valorCesta = parseFloat(valorCestaText);

            // Se valorCesta não for um número, definir como 0
            if (isNaN(valorCesta)) {
                valorCesta = 0;
            }

            // Calcular o valor com desconto
            const valorComDesconto = valorCesta - (valorCesta * (desconto / 100));

            // Atualizar o campo de valor total com o valor calculado
            document.getElementById('valorTotalDesconto').value = `R$ ${valorComDesconto.toFixed(2).replace(".", ",")}`;
        })
        .catch(error => console.error('Erro ao carregar dados do cliente:', error));
    }
}


document.addEventListener('DOMContentLoaded', function() {
    const dataField = document.getElementById('dataVenda');
    const today = new Date().toISOString().split('T')[0];
    dataField.value = today;
});
</script>
