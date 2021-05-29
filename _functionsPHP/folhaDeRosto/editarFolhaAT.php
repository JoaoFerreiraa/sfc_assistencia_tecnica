<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}
$pecasTrocadas = NULL;

$objFolhaDeRosto = new FolhaDeRosto();
$objFolhaDeRosto->setUsuario($_SESSION['usuario']['cod']);
$objFolhaDeRosto->setCod($_GET['folha']);
$objFolhaDeRosto->setEntrada_laboratorio(date("d/m/Y", strtotime($_GET['dataEntradaLaboratório'])));
$objFolhaDeRosto->setReincidencia($_GET['reicidencia']);
$objFolhaDeRosto->setTipo_solicitacao($_GET['tipoSolicitacao']);
$objFolhaDeRosto->setDefeito_apresentado($_GET['defeitosApresentado']);
$objFolhaDeRosto->setServicos_executados($_GET['servicosExecutados']);
$objFolhaDeRosto->setSaida_laboratorio($_GET['saidaLab']);
$objFolhaDeRosto->setLaudo_emitido($_GET['LaudoEmitido']);
$objFolhaDeRosto->setSaida_logistica($_GET['saidaLogistica']);

if (isset($_GET['pecasTrocadas'])) {
    foreach ($_GET['pecasTrocadas'] as $val) {
        $pecasTrocadas .= $val . ",";
    }
    $objFolhaDeRosto->setPecas_trocadas($pecasTrocadas);
}
// $objFolhaDeRosto->editar_por_cod_AT()
if ($objFolhaDeRosto->editar_por_cod_AT()) {
    echo '<script>window.location.href = "../../pages/ver/minhasFolhas.php"</script>';
} else {
    echo "Algo de errado ocorreu com a edição, por favor, chame o administrador. <br> Talvez você não fez nenhuma edição?";
}