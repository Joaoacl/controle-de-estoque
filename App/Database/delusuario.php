<?php
require_once '../auth.php';
require_once '../Models/usuario.class.php';
require_once '../Models/log.class.php';

$usuario = new Usuario();
$log = new Log();

if (isset($_POST['upload']) && $_POST['upload'] == 'Cadastrar') {
    
    $idusuario = $_POST['idusuario'];

    $usuarioNome = $usuario->getNomeUsuario($idusuario);

    $usuario->deleteUsuario($idusuario);

    $log->registrar(
        'usuários',
        $username,
        'exclusão',
        "Usuário ID: $idusuario ($usuarioNome)  foi excluído"
    );

} else {
    header('Location: ../../views/usuarios/index.php'); // 
}


?>