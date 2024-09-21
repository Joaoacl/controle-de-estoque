<?php
require_once '../App/auth.php';
require_once '../layout/script.php';
require_once '../layout/conteudo.php';

echo $head;
echo $header;
echo $aside;
echo '<div class="content-wrapper">';


echo '<p class="">Bem vindo, '.$username.'</p>';
if($perm == 1){
    echo 'Você é';
    echo'Administrador';
}else{
    echo 'Você é';
    echo' Vendedor';
}




echo '</div>';
echo $footer;
echo $javascript;

?>