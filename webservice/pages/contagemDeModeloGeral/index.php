<?php
require_once '../../_Class/Conexao.php';
header("Content-type: application/json; charset=utf-8"); 
$objConexaoRelatorio = new Conexao();
//DADOS GLOBAIS
if (isset($_GET['data']))
    $todasAsFolhas = $objConexaoRelatorio->Consultar("select * from folha_de_rosto where folha_de_rosto.lancamento_almoxarife like '%".$_GET['data']."%' GROUP BY folha_de_rosto.modelo");
    
else
    $todasAsFolhas = $objConexaoRelatorio->Consultar("select folha_de_rosto.lancamento_almoxarife, folha_de_rosto.pecas_trocadas from folha_de_rosto");

$json = json_encode($todasAsFolhas, JSON_PRETTY_PRINT);

// var_dump($json);

echo $json;

//where folha_de_rosto.entrada_laboratorio like '%/01/2021%' SCRIPT PARA PODER CONSULTAR E FAZER O FITLRO
