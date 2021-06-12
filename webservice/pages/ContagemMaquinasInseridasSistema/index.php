<?php
require_once '../../_Class/Conexao.php';
header("Content-type: application/json; charset=utf-8"); 
$objConexaoRelatorio = new Conexao();
//DADOS GLOBAIS
if (isset($_GET['data']))
    $todasAsFolhas = $objConexaoRelatorio->Consultar(
        "SELECT DATE_FORMAT(logs.data, '%d/%m/%Y') AS 'datas',
        COUNT(*) AS 'contagem'
        FROM   logs    
        WHERE logs.data like '%".$_GET['data']."%'
        AND logs.log LIKE '%criou%'
        GROUP BY DATE(logs.data)
        ORDER BY logs.cod ASC");
        
else
    $todasAsFolhas = $objConexaoRelatorio->Consultar(
        "SELECT DATE_FORMAT(logs.data, '%d/%m/%Y') AS 'datas',
        COUNT(*) AS 'contagem'
        FROM   logs    
        WHERE logs.data like '%%'
        AND logs.log LIKE '%criou%'
        GROUP BY DATE(logs.data)
        ORDER BY logs.cod ASC");
 
    usort( $todasAsFolhas, 'compara' );
 
    function compara( $a1, $a2 ) {
    	$ts1 = substr($a1[1],6,4).substr($a1[1],3,2).substr($a1[1],0,2);
    	$ts2 = substr($a2[1],6,4).substr($a2[1],3,2).substr($a2[1],0,2);
    	return strcmp($ts1, $ts2);
    }

$json = json_encode($todasAsFolhas);

// var_dump($todasAsFolhas);

echo $json;

//where folha_de_rosto.entrada_laboratorio like '%/01/2021%' SCRIPT PARA PODER CONSULTAR E FAZER O FITLRO
