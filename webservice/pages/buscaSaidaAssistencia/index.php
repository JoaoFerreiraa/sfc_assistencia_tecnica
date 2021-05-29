<?php
require_once '../../_Class/Conexao.php';
header("Content-type: application/json; charset=utf-8");
$objConexaoRelatorio = new Conexao();
//DADOS GLOBAIS
if (isset($_GET['data']))
    $todasAsFolhas = $objConexaoRelatorio->Consultar("SELECT folha_de_rosto.cod, folha_de_rosto.laudo_emitido as 'datas', count(folha_de_rosto.laudo_emitido) as 'contagem' FROM `folha_de_rosto` 
    where folha_de_rosto.laudo_emitido like '%" . $_GET['data'] . "%' 
    GROUP BY folha_de_rosto.laudo_emitido  
    ORDER BY `cod` ASC");

else
    $todasAsFolhas = $objConexaoRelatorio->Consultar("SELECT folha_de_rosto.cod, folha_de_rosto.laudo_emitido as 'datas', count(folha_de_rosto.laudo_emitido) as 'contagem' FROM `folha_de_rosto` 
    where folha_de_rosto.laudo_emitido like '%%' 
    GROUP BY folha_de_rosto.laudo_emitido  
    ORDER BY `cod` ASC");

usort($todasAsFolhas, 'compara');

function compara($a1, $a2)
{
    $ts1 = substr($a1[1], 6, 4) . substr($a1[1], 3, 2) . substr($a1[1], 0, 2);
    $ts2 = substr($a2[1], 6, 4) . substr($a2[1], 3, 2) . substr($a2[1], 0, 2);
    return strcmp($ts1, $ts2);
}
$json = json_encode($todasAsFolhas);

// var_dump($json);

echo $json;

//where folha_de_rosto.entrada_laboratorio like '%/01/2021%' SCRIPT PARA PODER CONSULTAR E FAZER O FITLRO
