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
$objRevisao->setStatus($_GET['status']);
if($_GET['status'] == '2')
$objRevisao->setMotivo('Administrador voltou a sua folha');
else
$objRevisao->setMotivo('');

$objRevisao->setRevisor($_SESSION['usuario']['cod']);

if($objRevisao->editar()){
    echo '<script>window.history.back();</script>';
}else{
    echo 'Hmm... Me parece que não consegui alterar os dados... Sera que ja não esta tudo certo?';
}

