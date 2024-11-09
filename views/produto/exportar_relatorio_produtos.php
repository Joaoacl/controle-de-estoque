<?php
require_once '../../App/Models/produto.class.php';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="relatorio_produtos.xls"');
header('Cache-Control: max-age=0');

echo "\xEF\xBB\xBF";

$produtos = new Produtos();
$result = $produtos->getRelatorioProdutos();

echo '<table border="1">';
echo '<tr>
        <th>ID Produto</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Valor (R$)</th>
        <th>Qtd em  estoque</th>
        <th>Qtd Minima</th>
        <th>Status</th>
      </tr>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . $row['idproduto'] . '</td>
            <td>' . $row['nome'] . '</td>
            <td>' . $row['descricao'] . '</td>
            <td>R$ ' . $row['valor'] . '</td>
            <td>' . $row['quantidade'] . '</td>
            <td>' . $row['quantidade_minima'] . '</td>
            <td>' . ($row['ativo'] == 1 ? 'Ativo' : 'Inativo') . '</td>
          </tr>';
}
echo '</table>';
?>
