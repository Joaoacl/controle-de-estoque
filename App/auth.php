<?php
session_start(); //Iniciando a sessão

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["idUsuario"]) || !isset($_SESSION["usuario"])) {
    header('Location: ../');
} else {

    $idUsuario = $_SESSION["idUsuario"];
    $username   = $_SESSION["usuario"];
    $perm       = $_SESSION["perm"];
    $foto      = $_SESSION["foto"];
    
}
