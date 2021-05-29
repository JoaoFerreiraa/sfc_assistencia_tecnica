<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
require '../../_Class/ParadaTemporaria.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}

$objParadaTemporaria = new ParadaTemporaria();

$objParadaTemporaria->setCod_Tecnico($_SESSION['usuario']['cod']);
if(isset($_GET['motivo']) && isset($_GET['folha'])){
    $objParadaTemporaria->setMotivo($_GET['motivo']);
    $objParadaTemporaria->setCod_folha( $_GET['folha']);
    if($objParadaTemporaria->criar() == true){
        header("Location:../../pages/ver/minhasFolhas");
    }else{
        echo '<script>alert("Não foi possivel criar uma parada temporária para essa folha! Talvez ela ja esteja parada?");
            window.location.href = "../../pages/ver/minhasFolhas.php";
        </script>';
    }

} 