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

if(isset($_GET['folha'])){
    $objParadaTemporaria->setCod_folha( $_GET['folha']);
    if($objParadaTemporaria->removerParada() == true){
        header("Location:../../pages/ver/minhasFolhas");
    }else{
        echo '<script>alert("Não foi possivel remover uma parada temporária para essa folha! Talvez ela ja tenha sido removida?");
            window.location.href = "../../pages/ver/minhasFolhas.php";
        </script>';
    }

} 