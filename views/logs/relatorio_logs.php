<?php
require_once '../../App/auth.php';
require_once '../../App/Models/log.class.php';
require_once '../../layout/script.php';

$logs = $log->getLogs();

echo $head;
echo $header;
echo $aside;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Relatório de Logs</h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Histórico de Logs</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Entidade</th>
                            <th>Usuário</th>
                            <th>Data e Hora</th>
                            <th>Operação</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($logs)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['entidade']; ?></td>
                            <td><?php echo $row['user']; ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($row['datahora'])); ?></td>
                            <td><?php echo $row['operacao']; ?></td>
                            <td><?php echo $row['detalhes']; ?></td>
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
