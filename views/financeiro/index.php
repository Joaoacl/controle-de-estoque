<?php
require_once '../../App/auth.php';
require_once '../../App/Models/venda.class.php';
require_once '../../layout/script.php';

echo $head;
echo $header;
echo $aside;


if ($perm != 1) {
    
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

                <!-- Canvas para o Gráfico -->
                <canvas id="relatorioFinanceiroGrafico" width="400" height="200"></canvas>
            </div>
        </div>
    </section>
</div>
<?php
echo $footer;
echo $javascript;
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const totalVendas = <?php echo json_encode($dadosFinanceiros['total_vendas']); ?>;
    const custoTotal = <?php echo json_encode($dadosFinanceiros['custo_total']); ?>;
    const lucro = <?php echo json_encode($dadosFinanceiros['lucro']); ?>;

    
    const ctx = document.getElementById('relatorioFinanceiroGrafico').getContext('2d');
    const relatorioFinanceiroGrafico = new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: ['Total de Vendas', 'Custo Total', 'Lucro'],
            datasets: [{
                label: 'Valores (R$)',
                data: [totalVendas, custoTotal, lucro], 
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)', 
                    'rgba(255, 99, 132, 0.6)', 
                    'rgba(75, 192, 192, 0.6)'   
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true 
                }
            },
            responsive: true, 
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>
