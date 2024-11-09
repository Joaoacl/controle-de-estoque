<?php
require_once '../../App/Models/venda.class.php';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="relatorio_vendas.xls"');

echo "\xEF\xBB\xBF";

$vendas = new Vendas();
$result = $vendas->getRelatorioVendas();

echo '<table border="1">';
echo '<tr>
        <th>ID Venda</th>
        <th>Cliente</th>
        <th>Vendedor</th>
        <th>Itens Vendidos</th>
        <th>Detalhes (Nome e Quantidade)</th>
        <th>Valor Total</th>
        <th>Data da Venda</th>
      </tr>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . $row['idvenda'] . '</td>
            <td>' . $row['nome_cliente'] . '</td>
            <td>' . $row['nome_vendedor'] . '</td>
            <td>' . $row['itensVendidos'] . '</td>
            <td>' . $row['quantidadeVendida'] . '</td>
            <td>R$ ' . ($row['valorTotal']) . '</td>
            <td>' . date('d/m/Y', strtotime($row['dataVenda'])) . '</td>
          </tr>';
}
echo '</table>';
?>
