<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
require '../../_Class/LaudoEmitido.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}
$objUsuario = new Usuario();
$objFolhaDeRosto = new FolhaDeRosto();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

if (!isset($_GET['folha']) || $objUsuario->getNivel() < 2) {
    header("Location:../../dashboard.php");
} else {
    $objFolhaDeRosto->setCod($_GET['folha']);
    $objFolhaDeRosto->consultar_por_codigo();

    $lancamentoAlmoxarife = date('Y-m-d', strtotime($objFolhaDeRosto->getLancamento_almoxarife()));
    $entradaLaboratório = date('Y-m-d', strtotime($objFolhaDeRosto->getEntrada_laboratorio()));
}


$pecasTrocadas = NULL;

if (isset($_GET['pecasTrocadas'])) {
    foreach ($_GET['pecasTrocadas'] as $val) {
        $pecasTrocadas .= $val . ",";
    }
}


$objLaudoEmitido = new LaudoEmitido();
$objLaudoEmitido->setSerial_number($_GET['folha']);
$retornoLaudo = $objLaudoEmitido->consultar_por_serial();
$url = "?modelo=" . $retornoLaudo[0]['modelo_maquina'] . "&pecasTrocadas=" . $retornoLaudo[0]['pecas_trocadas'] . "&nSerie=" . $retornoLaudo[0]['serial_number'];


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Emissao de Laudo | SFC</title>



    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php'?>
    
    <!-- form para a folha de rosto -->

    <section>
        <div class="container">
            <!-- titulo para folha de rosto -->
            <div class="row">
                <div class="col-12">
                    <div class="row mt-2">
                        <div class="col-3">
                            <img src="../../assets/img/logo.png" alt="" width="150px">
                        </div>
                        <div class="col-9">
                            <h1 class=" text-muted">Assistencia Técnica | Emissão de Laudo</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- corpo para folha de rosto -->
            <div class="row mt-5">
                <div class="col-11">
                    <div class="alert alert-success" id="mensagem" role="alert">
                        Função inválida... Em breve!
                    </div>

                </div>

            </div>

        </div>
    </section>

</body>

</html>