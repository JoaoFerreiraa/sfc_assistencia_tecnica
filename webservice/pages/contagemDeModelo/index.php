<?php
require_once '../../_Class/Conexao.php';

$objConexaoRelatorio = new Conexao();
//DADOS GLOBAIS
if (isset($_GET['data']))
    $todasAsFolhas = $objConexaoRelatorio->Consultar("select folha_de_rosto.modelo, COUNT(folha_de_rosto.modelo) as 'quantidade' from folha_de_rosto where folha_de_rosto.lancamento_almoxarife like '%".$_GET['data']."%' GROUP BY folha_de_rosto.modelo");
else
    $todasAsFolhas = $objConexaoRelatorio->Consultar("select folha_de_rosto.modelo, COUNT(folha_de_rosto.modelo) as 'quantidade' from folha_de_rosto where GROUP BY folha_de_rosto.modelo");

$json = json_encode($todasAsFolhas);

echo $json;

//where folha_de_rosto.entrada_laboratorio like '%/01/2021%' SCRIPT PARA PODER CONSULTAR E FAZER O FITLRO
