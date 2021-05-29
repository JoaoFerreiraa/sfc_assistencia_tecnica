<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';


if (isset($_GET['codFolha'])) {
    $objConexao = new Conexao();
    $cmdSql = "CALL logs_consultarPorFolha(".$_GET['codFolha'].")";

    $retornoConsulta = $objConexao->Consultar($cmdSql);

    $retornoConsulta = json_encode($retornoConsulta);
    echo $retornoConsulta;
}
