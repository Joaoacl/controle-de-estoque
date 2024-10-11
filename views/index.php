<?php
require_once '../App/auth.php';
require_once '../layout/script.php';
require_once '../layout/conteudo.php';

// Inicializando o array de notificações se ele não existir
if (!isset($_SESSION['notificacoes'])) {
    $_SESSION['notificacoes'] = [];
}

// Verifica se o botão de limpar notificações foi clicado
if (isset($_POST['limpar_notificacoes'])) {
  // Limpa as notificações
  $_SESSION['notificacoes'] = [];
}

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';

$contagemNotificacoes = isset($_SESSION['notificacoes']) ? count($_SESSION['notificacoes']) : 0;

echo '<p class="">Bem vindo, '.$username.'</p>';
if($perm == 1){
    echo 'Você é';
    echo' Administrador';
}else{
    echo 'Você é';
    echo' Vendedor';
}

if (isset($_SESSION['notificacoes']) && !empty($_SESSION['notificacoes'])) {
    echo '<div class="alert alert-warning">';
    foreach ($_SESSION['notificacoes'] as $notificacao) {
        echo '<p>' . $notificacao . '</p>';
    }
    echo '</div>';
}


echo '</div>';
echo $footer;
echo $javascript;
?>

<style>
  .notification-container {
    background-color: #f8f9fa; /* Fundo leve */
    border: 1px solid #ddd; /* Borda suave */
    border-radius: 8px; /* Borda arredondada */
    padding: 15px; /* Espaçamento interno */
    margin-top: 20px; /* Margem no topo */
}

.notification-list {
    list-style-type: none; /* Remove o estilo padrão da lista */
    padding: 0; /* Remove padding */
    margin: 0; /* Remove margem */
}

.notification-list li {
    padding: 10px 0; /* Espaçamento entre itens */
    display: flex;
    align-items: center; /* Alinha ícone com o texto */
    border-bottom: 1px solid #ddd; /* Linha separadora */
}

.notification-list li:last-child {
    border-bottom: none; /* Remove linha do último item */
}

.notification-icon {
    color: #f39c12; /* Cor laranja para destaque */
    margin-right: 10px; /* Espaço entre ícone e texto */
}

.notification-list strong {
    color: #333; /* Destaca texto */
}

</style>

<script>
document.querySelector('.open').addEventListener('click', function() {
    $('#modalNotificacoes').modal('show');
});
</script>

