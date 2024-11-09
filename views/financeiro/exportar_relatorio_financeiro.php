<?php
require_once '../../App/Models/venda.class.php';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="relatorio_financeiro.xls"');
header('Cache-Control: max-age=0');

// Adicionar BOM para UTF-8
echo "\xEF\xBB\xBF";

$vendas = new Vendas();
$dadosFinanceiros = $vendas->getRelatorioFinanceiro();

echo '<table border="1">';
echo '<tr>
        <th>Total de Vendas (R$)</th>
        <th>Custo Total de Produtos (R$)</th>
        <th>Lucro (R$)</th>
      </tr>';
echo '<tr>
        <td>R$ ' . number_format($dadosFinanceiros['total_vendas'], 2, ',', '.') . '</td>
        <td>R$ ' . number_format($dadosFinanceiros['custo_total'], 2, ',', '.') . '</td>
        <td>R$ ' . number_format($dadosFinanceiros['lucro'], 2, ',', '.') . '</td>
      </tr>';
echo '</table>';
?>
