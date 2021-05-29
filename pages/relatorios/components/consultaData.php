<?php
    
$objConexaoRelatorio = new Conexao();
$anos = $objConexaoRelatorio->Consultar("SELECT folha_de_rosto.lancamento_almoxarife as 'datas' FROM `folha_de_rosto` WHERE folha_de_rosto.lancamento_almoxarife like '%/20%' GROUP BY folha_de_rosto.lancamento_almoxarife");
$anosSeparados = array();
foreach ($anos as $datas){
    $explodeAnos = explode("/",$datas[0]);
    if(!in_array($explodeAnos[2],$anosSeparados))
    array_push($anosSeparados, $explodeAnos[2]);
}

?>