<?php
require_once '../../App/Models/cestas.class.php';

// Definindo cabeçalhos para download do Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="relatorio_cestas.xls"');

echo "\xEF\xBB\xBF";

$cestas = new Cestas();
$result = $cestas->getRelatorioCestas();

echo '<table border="1">';
echo '<tr>
        <th>ID Cesta</th>
        <th>Nome da Cesta</th>
        <th>Descrição</th>
        <th>Valor (R$)</th>
        <th>Categoria</th>
        <th>Status</th>
        <th>Produtos</th>
        <th>Quantidades</th>
      </tr>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . $row['idcestaBasica'] . '</td>
            <td>' . $row['nome_cesta'] . '</td>
            <td>' . $row['descricao'] . '</td>
            <td>R$ ' . $row['valor'] . '</td>
            <td>' . $row['nome_categoria'] . '</td>
            <td>' . ($row['ativo'] == 1 ? 'Ativa' : 'Inativa') . '</td>
            <td>' . $row['itensCesta'] . '</td>
            <td>' . $row['quantidades'] . '</td>
          </tr>';
}
echo '</table>';
?>
