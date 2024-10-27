<?php
// getCestaData.php
require_once '../../App/Models/cestas.class.php';

if (isset($_POST['idCesta'])) {
    $idCesta = $_POST['idCesta'];
    $cesta = $cestas->getCestaById($idCesta); // Supondo que existe uma função getCestaById() que retorna os dados da cesta
    echo json_encode($cesta);
}
