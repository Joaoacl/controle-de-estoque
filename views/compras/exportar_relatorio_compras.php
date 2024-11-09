<?php
require_once '../../App/Models/compra.class.php';

// Definindo os cabeçalhos para o download do arquivo Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="relatorio_compras.xls"');

echo "\xEF\xBB\xBF";

$compras = new Compras();
$result = $compras->getRelatorioCompras();

// Iniciando a tabela em formato Excel
echo '<table border="1">';
echo '<tr>
        <th>ID Compra</th>
        <th>Fornecedor</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Banco / Conta</th>
        <th>Produtos</th>
        <th>Quantidades</th>
        <th>Data da Compra</th>
        <th>Data de Entrega</th>
        <th>Status</th>
      </tr>';

// Iterando sobre os resultados e preenchendo a tabela
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . $row['idcompra'] . '</td>
            <td>' . $row['nome_fornecedor'] . '</td>
            <td>' . $row['telefone_fornecedor'] . '</td>
            <td>' . $row['email_fornecedor'] . '</td>
            <td>' . $row['banco_fornecedor'] . ' / ' . $row['agencia_fornecedor'] . ' - ' . $row['conta_fornecedor'] . '</td>
            <td>' . $row['itensComprados'] . '</td>
            <td>' . $row['quantidades'] . '</td>
            <td>' . date('d/m/Y', strtotime($row['dataCompra'])) . '</td>
            <td>' . ($row['dataEntrega'] ? date('d/m/Y', strtotime($row['dataEntrega'])) : 'N/A') . '</td>
            <td>' . ($row['ativo'] == 1 ? 'Em andamento' : 'Entregue') . '</td>
          </tr>';
}
echo '</table>';
?>
