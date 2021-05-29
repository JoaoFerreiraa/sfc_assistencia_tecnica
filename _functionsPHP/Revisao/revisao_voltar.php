<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
require '../../_Class/Revisao.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}

$objRevisao = new Revisao();
$objRevisao->setCod($_GET['revisao']);
$objRevisao->setCod_folha($_GET['codFolha']);
$objRevisao->setStatus(2);
$objRevisao->setMotivo($_GET['motivo']);
$objRevisao->setRevisor($_SESSION['usuario']['cod']);

if($objRevisao->editar()){
    echo 1;
}else{
    echo 'Hmm... Me parece que não consegui alterar os dados... Sera que ja não esta tudo certo?';
}

