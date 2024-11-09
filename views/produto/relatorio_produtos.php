<?php
require_once '../../App/auth.php';
require_once '../../App/Models/produto.class.php';
require_once '../../layout/script.php';

$produtos = new Produtos();
$result = $produtos->getRelatorioProdutos();

echo $head;
echo $header;
echo $aside;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Relatório de Produtos em Estoque</h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Produtos Cadastrados</h3>
                <a href="exportar_relatorio_produtos.php" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Valor (R$)</th>
                            <th>Qtd em  estoque</th>
                            <th>Qtd Mínima</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['idproduto']; ?></td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['descricao']; ?></td>
                            <td>R$ <?php echo $row['valor']; ?></td>
                            <td><?php echo $row['quantidade']; ?></td>
                            <td><?php echo $row['quantidade_minima']; ?></td>
                            <td class="<?php echo ($row['ativo'] == 1) ? 'success' : 'danger'; ?>"><?php echo ($row['ativo'] == 1) ? 'Ativo' : 'Inativo'; ?></td>
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
