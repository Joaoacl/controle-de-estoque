<?php
require_once '../../App/auth.php';
require_once '../../App/Models/venda.class.php';
require_once '../../layout/script.php';

echo $head;
echo $header;
echo $aside;

// Verificar se o usuário tem permissão de administrador (perm == 1)
if ($perm != 1) {
    // Exibir mensagem de acesso negado e encerrar o script
    echo '
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Acesso Negado</h1>
        </section>
        <section class="content">
            <div class="alert alert-danger">
                <strong>Aviso:</strong> Você não possui acesso a esta página.
            </div>
        </section>
    </div>';
    echo $footer;
    echo $javascript;
    exit();
}

$vendas = new Vendas();
$dadosFinanceiros = $vendas->getRelatorioFinanceiro();
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Relatório Financeiro</h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Resumo Financeiro</h3>
                <a href="exportar_relatorio_financeiro.php" class="btn btn-success pull-right">
                    <i class="fa fa-file-excel-o"></i> Exportar para Excel
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Total de Vendas (R$)</th>
                            <th>Custo Total de Produtos (R$)</th>
                            <th>Lucro (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R$ <?php echo number_format($dadosFinanceiros['total_vendas'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($dadosFinanceiros['custo_total'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($dadosFinanceiros['lucro'], 2, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<?php
echo $footer;
echo $javascript;
?>
