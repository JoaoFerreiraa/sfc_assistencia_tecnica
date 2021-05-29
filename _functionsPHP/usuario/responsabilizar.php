<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}
$objUsuario = new Usuario();

$objTecnicoResponsavelFolha = new TecnicoResponsavelFolha();
$objTecnicoResponsavelFolha->setCod_folha_de_rosto($_GET['codFolha']);
$objTecnicoResponsavelFolha->setTec_responsavel($_SESSION['usuario']['cod']);


$objFolhaDeRosto = new FolhaDeRosto();
$objFolhaDeRosto->setCod($_GET['codFolha']);
$objFolhaDeRosto->setEntrada_laboratorio(date("d/m/Y"));
if($objTecnicoResponsavelFolha->consultaResponsaveis() != false){
    $objTecnicoResponsavelFolha->editar();
    header("Location:../../pages/ver/minhasFolhas.php");
}else{
    if($objTecnicoResponsavelFolha->criar()){
        $objFolhaDeRosto->alterar_dataEntradaLab();
        header("Location:../../pages/ver/minhasFolhas.php");
    }
}
