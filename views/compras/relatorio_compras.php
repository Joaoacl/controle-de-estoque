<?php
require_once '../../App/auth.php';
require_once '../../App/Models/compra.class.php';
require_once '../../layout/script.php';

$compras = new Compras();
$result = $compras->getRelatorioCompras();

echo $head;
echo $header;
echo $aside;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Relatório de Solicitações de Compra</h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Compras Realizadas</h3>
                <a href="exportar_relatorio_compras.php" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo $row['idcompra']; ?></td>
                                    <td><?php echo $row['nome_fornecedor']; ?></td>
                                    <td><?php echo $row['telefone_fornecedor']; ?></td>
                                    <td><?php echo $row['email_fornecedor']; ?></td>
                                    <td><?php echo $row['banco_fornecedor'] . ' / ' . $row['agencia_fornecedor'] . ' - ' . $row['conta_fornecedor']; ?></td>
                                    <td><?php echo $row['itensComprados']; ?></td>
                                    <td><?php echo $row['quantidades']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['dataCompra'])); ?></td>
                                    <td><?php echo $row['dataEntrega'] ? date('d/m/Y', strtotime($row['dataEntrega'])) : 'N/A'; ?></td>
                                    <td><?php echo $row['ativo'] == 1 ? 'Em andamento' : 'Entregue'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10">Nenhuma solicitação de compra encontrada.</td>
                            </tr>
                        <?php endif; ?>
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
