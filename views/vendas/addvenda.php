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
            <form role="form" action="../../App/Database/insertvenda.php" method="POST" onsubmit="return verificarCestasSelecionadas();">
    <div class="box-body">
        <!-- Seleção de Cliente -->
        <div class="form-group">
            <label for="codCli">Cliente</label>
            <select class="form-control select2" name="codCli" id="codCli" onchange="carregarDadosCliente(this.value)" required>
                <option value="">Selecione um Cliente</option>
                ';
                $clientes->listClientes();
                echo '
            </select>
        </div>

        <div class="form-group">
          <label>Desconto do Cliente (%)</label>
          <input type="text" name="desconto" class="form-control" id="descontoCliente" readonly>
        </div>

        <!-- Seleção de Cesta e Quantidade -->
        <div class="form-group">
            <label for="codCesta">Selecione a Cesta</label>
            <select class="form-control" name="codCesta" id="codCesta" onchange="carregarDadosCesta(this.value)">
                <option value="">Selecione uma cesta</option>
                ';
                $cestas->listCestas();
                echo '
            </select>
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
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" max="100" value="1">
        </div>

        <button type="button" class="btn btn-primary" onclick="adicionarCesta()">Adicionar Cesta</button>

        <!-- Lista de Cestas Selecionadas -->
        <div class="form-group">
            <h4>Cestas Selecionadas</h4>
            <ul id="listaCestas"></ul>
        </div>

        <!-- Valor total e data da venda -->
        <div class="form-group">
            <label for="valorTotalDesconto">Valor Total (R$)</label>
            <input type="text" name="valorTotal" class="form-control" id="valorTotalDesconto" placeholder="R$" oninput="mascaraValor(this)" required readonly>
        </div>

        <div class="form-group">
            <label for="dataVenda">Data da Venda</label>
            <input type="date" name="dataVenda" class="form-control" id="dataVenda" required>
        </div>

        <input type="hidden" name="iduser" value="'.$idUsuario.'">
        <input type="hidden" name="cestasSelecionadas" id="cestasSelecionadas"> <!-- Input escondido para armazenar os dados das cestas -->

        <div class="box-footer">
            <button type="submit" name="upload" class="btn btn-primary" value="Cadastrar">Finalizar</button>
            <a class="btn btn-danger" href="../../views/vendas">Cancelar</a>
        </div>
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

<style>
    /* Ajusta o Select2 para se alinhar melhor com o Bootstrap 3 */
    .select2-container .select2-selection--single {
        height: 34px; /* Altura padrão de um form-control do Bootstrap 3 */
        padding-top: 3px;
    }
    .select2-container .select2-selection__arrow {
        height: 34px; /* Altura do ícone de seta */
    }
</style>


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
            // Exibir informações da cesta
            document.getElementById('descricaoCesta').textContent = data.descricao;
            document.getElementById('valorCesta').value = `R$ ${data.valor.replace(".", ",")}`;

            const produtosList = document.getElementById('produtosCesta');
            produtosList.innerHTML = '';  // Limpar lista de produtos
            data.produtos.forEach(produto => {
                const li = document.createElement('li');
                li.textContent = `${produto.nome_produto} - Qtd: ${produto.quantidade}`;
                produtosList.appendChild(li);
            });
        })
        .catch(error => console.error('Erro ao carregar dados da cesta:', error));
    } else {
        // Limpar os campos se nenhuma cesta estiver selecionada
        limparCamposCesta();
    }
};

function limparCamposCesta() {
    console.log("Limpando campos da cesta...");
    document.getElementById('descricaoCesta').textContent = 'Selecione uma cesta para ver a descrição e os produtos.';
    document.getElementById('produtosCesta').innerHTML = '';
    document.getElementById('valorCesta').value = '';
};

function verificarCestasSelecionadas() {
    if (cestas.length === 0) {
        alert("Você precisa adicionar pelo menos uma cesta para realizar a venda.");
        return false; // Impede o envio do formulário
    }
    return true; // Permite o envio do formulário
};

function adicionarCesta() {
  console.log("Função adicionarCesta chamada");
    const idCesta = document.getElementById('codCesta').value;
    const nomeCesta = document.getElementById('codCesta').selectedOptions[0].text;
    const quantidade = parseInt(document.getElementById('quantidade').value);

    if (idCesta && quantidade > 0) {
        // Adicionar cesta à lista
        const cesta = { id: idCesta, nome: nomeCesta, quantidade: quantidade };
        cestas.push(cesta);
        
        // Atualizar a lista e o valor total
        atualizarListaCestas();
        atualizarValorTotal();

        // Limpar os campos de seleção e os campos de descrição/produtos
        document.getElementById('codCesta').value = '';
        document.getElementById('quantidade').value = 1;

        limparCamposCesta();
    } else {
        alert("Selecione uma cesta e defina uma quantidade válida.");
    }
};

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
     
        })
        .catch(error => console.error('Erro ao carregar dados do cliente:', error));
    }
};

let cestas = [];

function adicionarCesta() {
    const idCesta = document.getElementById('codCesta').value;
    const nomeCesta = document.getElementById('codCesta').selectedOptions[0].text;
    const quantidade = parseInt(document.getElementById('quantidade').value);

    // Calcula o total atual de cestas para verificar o limite de 100
    const totalCestas = cestas.reduce((total, cesta) => total + cesta.quantidade, 0) + quantidade;

    if (totalCestas > 100) {
        alert("O total de cestas selecionadas não pode exceder 100.");
        return;
    }

    if (idCesta && quantidade > 0) {
        // Adiciona a cesta à lista de cestas selecionadas
        const cesta = { id: idCesta, nome: nomeCesta, quantidade: quantidade };
        cestas.push(cesta);

        atualizarListaCestas();
        atualizarValorTotal();

        // Limpar os campos de seleção
        document.getElementById('codCesta').value = '';
        document.getElementById('quantidade').value = 1;
        limparCamposCesta();
    } else {
        alert("Selecione uma cesta e defina uma quantidade válida.");
    }
};

function atualizarListaCestas() {
    const listaCestas = document.getElementById('listaCestas');
    listaCestas.innerHTML = '';

    cestas.forEach((cesta, index) => {
        const item = document.createElement('li');
        item.textContent = `${cesta.nome} - Quantidade: ${cesta.quantidade}`;
        
        // Botão para remover a cesta da lista
        const btnRemover = document.createElement('button');
        btnRemover.textContent = 'Remover';
        btnRemover.className = 'btn btn-danger btn-sm ml-2';
        btnRemover.onclick = () => {
            cestas.splice(index, 1); // Remove a cesta da lista
            atualizarListaCestas();
            atualizarValorTotal();
        };
        
        item.appendChild(btnRemover);
        listaCestas.appendChild(item);
    });

    // Armazena as cestas selecionadas em um campo oculto no formato JSON
    document.getElementById('cestasSelecionadas').value = JSON.stringify(cestas);
};

function atualizarValorTotal() {
    let total = 0;
    const desconto = parseFloat(document.getElementById('descontoCliente').value) || 0;
    const promises = cestas.map(cesta => {
        return fetch('getCestaData.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `idCesta=${cesta.id}`
        })
        .then(response => response.json())
        .then(data => {
            total += parseFloat(data.valor) * cesta.quantidade;
        });
    });

    Promise.all(promises).then(() => {
        const valorComDesconto = total - (total * (desconto / 100));
        document.getElementById('valorTotalDesconto').value = valorComDesconto.toFixed(2).replace(".", ",");
    }).catch(error => console.error('Erro ao calcular o valor total:', error));
};


$(document).ready(function() {
  $("#codCli").select2({
    placeholder: "Selecione um Cliente",
    allowClear: true,
    width: "100%" // Garante que ocupe toda a largura do select
  });
  console.log("Select2 aplicado ao campo #codCli");
});


if (typeof $.fn.select2 !== 'undefined') {
    console.log('Select2 carregado com sucesso.');
  } else {
    console.error('Select2 não foi carregado.');
  }


document.addEventListener('DOMContentLoaded', function() {
    const dataField = document.getElementById('dataVenda');
    const today = new Date().toISOString().split('T')[0];
    dataField.value = today;
});
</script>
