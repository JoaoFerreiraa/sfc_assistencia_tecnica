<?php
require_once '../../_Class/Conexao.php';
header("Content-type: application/json; charset=utf-8"); 
$objConexaoRelatorio = new Conexao();
$pecasArray = array();
//DADOS GLOBAIS

$anos = $objConexaoRelatorio->Consultar("SELECT folha_de_rosto.lancamento_almoxarife as 'datas' FROM `folha_de_rosto` WHERE folha_de_rosto.lancamento_almoxarife like '%/20%' GROUP BY folha_de_rosto.lancamento_almoxarife");


$anosSeparados = array();
foreach ($anos as $datas){
    $explodeAnos = explode("/",$datas[0]);
    if(!in_array($explodeAnos[2],$anosSeparados))
    array_push($anosSeparados, $explodeAnos[2]);
}


$json = json_encode($anosSeparados, JSON_PRETTY_PRINT);

echo $json;

//where folha_de_rosto.entrada_laboratorio like '%/01/2021%' SCRIPT PARA PODER CONSULTAR E FAZER O FITLRO
