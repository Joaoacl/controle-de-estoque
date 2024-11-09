<?php
require_once '../../App/auth.php';
require_once '../../App/Models/venda.class.php';
require_once '../../layout/script.php';

$vendas = new Vendas();
$result = $vendas->getRelatorioVendas();

echo $head;
echo $header;
echo $aside;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Relatório de Vendas</h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Vendas Realizadas</h3>
                <a href="exportar_relatorio_vendas.php" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Itens Vendidos</th>
                        <th>Quantidade</th>
                        <th>Valor Total (R$)</th>
                        <th>Data da Venda</th>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['idvenda']; ?></td>
                            <td><?php echo $row['nome_cliente']; ?></td>
                            <td><?php echo $row['nome_vendedor']; ?></td>
                            <td><?php echo $row['itensVendidos']; ?></td>
                            <td><?php echo $row['quantidadeVendida']; ?></td>
                            <td>R$ <?php echo $row['valorTotal']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['dataVenda'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
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
