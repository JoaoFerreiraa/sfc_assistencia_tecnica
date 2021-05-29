<?php
require_once '../../_Class/Conexao.php';
header("Content-type: application/json; charset=utf-8"); 
$objConexaoRelatorio = new Conexao();
$pecasArray = array();
//DADOS GLOBAIS
if (isset($_GET['data']))
    $todasAsFolhas = $objConexaoRelatorio->Consultar("select folha_de_rosto.pecas_trocadas from folha_de_rosto where folha_de_rosto.lancamento_almoxarife like '%" . $_GET['data'] . "%'");

else
    $todasAsFolhas = $objConexaoRelatorio->Consultar("select folha_de_rosto.pecas_trocadas from folha_de_rosto");


// var_dump($todasAsFolhas);

foreach ($todasAsFolhas as $pecas) {
    $pecas = explode(",", $pecas[0]);
    if(count($pecas) > 2){
        foreach($pecas as $peca){
            if($peca != null){
                if(!array_key_exists($peca, $pecasArray)){
                    $pecasArray[$peca] = 1;
                }else{
                    $pecasArray[$peca] +=1;
                }
            }
        }
    }else{
        if($pecas[0] != null){
            if(!array_key_exists($pecas[0], $pecasArray)){
                $pecasArray[$pecas[0]] = 1;
            }else{
                $pecasArray[$pecas[0]] +=1;
            }   
        }
    }

}
// var_dump($pecasArray);

$json = json_encode($pecasArray, JSON_PRETTY_PRINT);

echo $json;

//where folha_de_rosto.entrada_laboratorio like '%/01/2021%' SCRIPT PARA PODER CONSULTAR E FAZER O FITLRO
