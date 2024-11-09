<?php
require_once '../App/auth.php';
require_once '../layout/script.php';
require_once '../layout/conteudo.php';

// Inicializando o array de notificações se ele não existir
if (!isset($_SESSION['notificacoes'])) {
    $_SESSION['notificacoes'] = [];
}

// Verifica se o botão de limpar notificações foi clicado
if (isset($_POST['limpar_notificacoes'])) {
  // Limpa as notificações
  $_SESSION['notificacoes'] = [];
}

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';

$contagemNotificacoes = isset($_SESSION['notificacoes']) ? count($_SESSION['notificacoes']) : 0;

echo '<div class="alert alert-primary mt-3" role="alert">';
echo '<h4 class="alert-heading">Bem-vindo, <strong>' . htmlspecialchars($username) . '</strong>!</h4>';
if ($perm == 1) {
    echo '<p class="mb-0">Você é <span class="badge btn-success">Administrador</span></p>';
} else {
    echo '<p class="mb-0">Você é <span class="badge btn-info">Vendedor</span></p>';
}
echo '</div>';


echo'<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><i class="ion ion-bag"></i> Vendas</font></font></h3>

              <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Vendas de Produtos</font></font></p>
            </div>
          
            <a href="'.$url.'vendas/relatorio_vendas.php" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Ver Relatório </font></font><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><i class="ion ion-stats-bars"></i> Financeiro </font></font><sup style="font-size: 20px"><font style="vertical-align: inherit;"></font></sup></h3>

              <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Relatório Financeiro</font></font></p>
            </div>
            
            <a href="'.$url.'financeiro/" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Ver Relatório </font></font><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><i class="fa fa-cart-arrow-down"></i> Compras</h3>
              <p>Compras de Produtos</p>
            </div>
          
            <a href="'.$url.'compras/relatorio_compras.php" class="small-box-footer">
              Ver Relatório <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>


        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><i class="fa fa-th-large"></i> Estoque</font></font></h3>

              <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Estoque de Produtos</font></font></p>
            </div>
           
            <a href="'.$url.'produto/relatorio_produtos.php" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Ver Relatório </font></font><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        

    </section>';

echo '</div>';
echo $footer;
echo $javascript;
?>

<style>
  .notification-container {
    background-color: #f8f9fa; /* Fundo leve */
    border: 1px solid #ddd; /* Borda suave */
    border-radius: 8px; /* Borda arredondada */
    padding: 15px; /* Espaçamento interno */
    margin-top: 20px; /* Margem no topo */
}

.notification-list {
    list-style-type: none; /* Remove o estilo padrão da lista */
    padding: 0; /* Remove padding */
    margin: 0; /* Remove margem */
}

.notification-list li {
    padding: 10px 0; /* Espaçamento entre itens */
    display: flex;
    align-items: center; /* Alinha ícone com o texto */
    border-bottom: 1px solid #ddd; /* Linha separadora */
}

.notification-list li:last-child {
    border-bottom: none; /* Remove linha do último item */
}

.notification-icon {
    color: #f39c12; /* Cor laranja para destaque */
    margin-right: 10px; /* Espaço entre ícone e texto */
}

.notification-list strong {
    color: #333; /* Destaca texto */
}


.small-box h3 {
  font-size: 24px; /* Ajuste do tamanho do título */
  margin: 0;
  padding: 0;
}

.small-box p {
  margin: 0;
  padding: 5px 0;
}

.small-box-footer {
  font-weight: bold;
}

</style>

<script>
document.querySelector('.open').addEventListener('click', function() {
    $('#modalNotificacoes').modal('show');
});
</script>

