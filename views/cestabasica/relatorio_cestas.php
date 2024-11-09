<?php
require_once '../../App/auth.php';
require_once '../../App/Models/cestas.class.php';
require_once '../../layout/script.php';

$cestas = new Cestas();
$result = $cestas->getRelatorioCestas();

echo $head;
echo $header;
echo $aside;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Relatório de Cestas Básicas</h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Cestas Básicas Cadastradas</h3>
                <a href="exportar_relatorio_cestas.php" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome da Cesta</th>
                            <th>Descrição</th>
                            <th>Valor (R$)</th>
                            <th>Categoria</th>
                            <th>Produtos</th>
                            <th>Quantidades</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['idcestaBasica']; ?></td>
                            <td><?php echo $row['nome_cesta']; ?></td>
                            <td><?php echo $row['descricao']; ?></td>
                            <td>R$ <?php echo $row['valor']; ?></td>
                            <td><?php echo $row['nome_categoria']; ?></td>                      
                            <td><?php echo $row['itensCesta']; ?></td>
                            <td><?php echo $row['quantidades']; ?></td>
                            <td class="<?php echo ($row['ativo'] == 1) ? 'success' : 'danger'; ?>"><?php echo ($row['ativo'] == 1) ? 'Ativa' : 'Inativa'; ?></td>
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
