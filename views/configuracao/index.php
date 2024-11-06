<?php
require_once '../../App/auth.php';
require_once '../../layout/script.php';
require_once '../../App/Models/config.class.php';

$maxDesconto = $config->getMaxDesconto(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoMaxDesconto = $_POST['max_desconto'];
    $config->setMaxDesconto($novoMaxDesconto);
    $_SESSION['mensagem_sucesso'] = "Configuração atualizada com sucesso!";
    header("Location: index.php");
    exit();
}

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';
echo '<section class="content-header">
        <h1>Configuração <small>Percentual Máximo de Desconto</small></h1>
      </section>';
echo '<section class="content">
        <div class="row">';

    if($perm == 1){

            echo'<div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Configurar Desconto Máximo</h3>
                    </div>
                    <form method="POST">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="max_desconto">Desconto Máximo (%)</label>
                                <input type="number" name="max_desconto" class="form-control" id="max_desconto" 
                                       value="' . htmlspecialchars($maxDesconto) . '" min="0" max="100" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>';

    }else{
        echo'Você não possui acesso!';
    }

echo'</section>';
echo '</div>';

if (isset($_SESSION['mensagem_sucesso'])) {
    echo "<script>alert('" . $_SESSION['mensagem_sucesso'] . "');</script>";
    unset($_SESSION['mensagem_sucesso']);
}

echo $footer;
echo $javascript;
?>
