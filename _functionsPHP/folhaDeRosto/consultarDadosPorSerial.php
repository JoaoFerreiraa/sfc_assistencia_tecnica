<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';


if (isset($_GET['codFolha'])) {
    $objFolhaDeRosto = new FolhaDeRosto();

    $objFolhaDeRosto->setCod($_GET['codFolha']);
    $retornoConsulta = $objFolhaDeRosto->consultar_por_codigo();

    
    $retornoConsulta = json_encode($retornoConsulta);
    echo $retornoConsulta;
}
