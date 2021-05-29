<?php
require_once '../../_Class/Conexao.php';

$objConexaoRelatorio = new Conexao();
$QtdPecasNaoTrocadas = 0;
$QtdPecasTrocadas = 0;
//DADOS GLOBAIS
if (isset($_GET['data']))
    $todasAsFolhas = $objConexaoRelatorio->Consultar("select folha_de_rosto.pecas_trocadas from folha_de_rosto where folha_de_rosto.entrada_laboratorio like '%" . $_GET['data'] . "%'");
else
    $todasAsFolhas = $objConexaoRelatorio->Consultar("select folha_de_rosto.pecas_trocadas from folha_de_rosto");

if ($todasAsFolhas != false) {
    foreach ($todasAsFolhas as $folha) {
        if($folha['pecas_trocadas'] == null)
        continue;
        else if ($folha['pecas_trocadas'] == "Sem peças trocadas," || $folha['pecas_trocadas'] == "null" || $folha['pecas_trocadas'] == "NULL" || $folha['pecas_trocadas'] == "-" || $folha['pecas_trocadas'] == "S/D" || $folha['pecas_trocadas'] == "") {
            $QtdPecasNaoTrocadas += 1;
        } else 
            $QtdPecasTrocadas += 1;
    }
}

$json = array("pecasTrocas" => $QtdPecasTrocadas, "pecasNaoTrocadas" => $QtdPecasNaoTrocadas);


$json = json_encode($json);

echo $json;

//where folha_de_rosto.entrada_laboratorio like '%/01/2021%' SCRIPT PARA PODER CONSULTAR E FAZER O FITLRO
