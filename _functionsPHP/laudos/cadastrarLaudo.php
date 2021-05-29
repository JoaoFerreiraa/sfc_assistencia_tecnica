<?php
require '../../_Class/Usuario.php';
require '../../_Class/LaudoEmitido.php';
require '../../_Class/FolhaDeRosto.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}

$objLaudoEmitido = new LaudoEmitido();
$objfolhaDeRosto = new FolhaDeRosto();
$objfolhaDeRosto->setCod($_GET['folha']);
$objfolhaDeRosto->consultar_por_codigo();
$objLaudoEmitido->setPecas_trocadas($_GET['pecasTrocadas']);
$objLaudoEmitido->setSerial_number($_GET['serialNumber']);
$objLaudoEmitido->setTec_emissor($_GET['tecEmissor']);
$objLaudoEmitido->setModelo_maquina($_GET['modelo']);
$objLaudoEmitido->setCod_folha($_GET['folha']);
$objfolhaDeRosto->setLaudo_emitido(date("d/m/Y"));
$objfolhaDeRosto->editar_laudo_emitido();
if($objLaudoEmitido->criar()){
    echo 1;
}
else{
    echo 0; 
}
