<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';

if (isset($_GET['cod'])) {
    $objConexao = new Conexao();
    $cmdSql = "CALL usuario_consultarNomePorCod(".$_GET['cod'].")";

    $retornoConsulta = $objConexao->Consultar($cmdSql)[0][0];

    echo $retornoConsulta;
}
