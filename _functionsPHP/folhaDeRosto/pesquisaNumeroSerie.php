<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}
if (isset($_GET['numero_serial'])) {
    $objFolhaDeRosto = new FolhaDeRosto();

    $objFolhaDeRosto->setNumero_serie($_GET['numero_serial']);
    $retornoConsulta = $objFolhaDeRosto->consultar_por_serial();
    
    if($retornoConsulta !== false){
        echo 1;
    }else{
        echo 0;
    }
}
