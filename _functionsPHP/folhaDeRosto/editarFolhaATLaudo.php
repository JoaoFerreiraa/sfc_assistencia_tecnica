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
$objFolhaDeRosto->setPecas_trocadas($pecasTrocadas);

$url = "?modelo=" . $_GET['modelo'] . "&pecasTrocadas=" . $pecasTrocadas . "&nSerie=" . $_GET['nSerie'];

$objLaudoEmitido = new LaudoEmitido();
$objLaudoEmitido->setSerial_number($_GET['nSerie']);
$retornoLaudo = $objLaudoEmitido->consultar_por_serial();


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/app.min.css">
    <title>Emissao de Laudo | SFC</title>



    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        @media (max-width: 1700px) {
            .container {
                margin-right: 0 !important;
            }
        }
    </style>
</head>

<body>
    <div class="left-side-menu">


        <div class="h-100" id="left-side-menu-container" data-simplebar>

            <!--- Sidemenu -->
            <ul class="metismenu side-nav">
                <li class="side-nav-item">
                    <span class="side-nav-link"> Bem vindo(a) <?php echo $objUsuario->getNome() ?> </span>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="">Sua função: <strong><?php echo $objUsuario->getFuncao() ?></strong></a>
                        </li>
                        <li>
                            <a href="">Seu nível <strong><?php echo $objUsuario->getNivel() ?></strong></a>
                        </li>
                    </ul>
                </li>
                <li class="side-nav-title side-nav-item">SFC - Shop Floor Control</li>

                <li class="side-nav-item">
                    <a href="../../dashboard.php" class="side-nav-link">
                        <span> Painel de controle </span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="../criar/folhaDeRosto.php">Criar folha de rosto</a>
                        </li>
                        <li>
                            <a href="../../manutencao.html">Relátorios</a>
                        </li>
                        <li>
                            <a href="../../pages/administracao/dashboard.php">Administração</a>
                        </li>
                        <?php
                        if ($objUsuario->getNivel() > 3) {
                            echo '<li>
                        <a href="../../criarUser.php">Criar Usuario</a>
                    </li>';
                        }
                        ?>
                    </ul>
                </li>

                <li class="side-nav-item">
                    <a href="../../index.php" class="side-nav-link">
                        <span> Sair </span>
                    </a>
                </li>

            </ul>

            <!-- Help Box -->
            <div class="help-box text-white text-center">
                <a href="" class="float-right close-btn text-white">
                    <i class="mdi mdi-close"></i>
                </a>
                <img src="../../assets/img/logo.png" height="50" alt="Helper Icon Image" />
                <h5 class="mt-3">Precisa de ajuda?</h5>
                <p class="mb-3">Acione o administrador através desse botão!</p>
                <a href="" class="btn btn-outline-light btn-sm">Ajuda!</a>
            </div>
            <!-- end Help Box -->
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>

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
                        <?php
                        if ($objFolhaDeRosto->editar_por_cod_AT()) {
                            echo 'A folha foi salva com sucesso! <br>';
                        } else {
                            echo "Algo de errado ocorreu com a edição, por favor, chame o administrador. <br> Talvez você não fez nenhuma edição?<br>";
                        }
                        echo 'Conferindo informações de registro de laudo...';
                        if ($retornoLaudo !== false) {
                            $modelo = "COMPAQ Presario " . $retornoLaudo[0]['modelo_maquina'];
                            echo '</br>Me parece que ja existe um laudo dessa maquina... </br>Deseja gerar outro laudo ou ver esse?';
                            echo '<br><a href="../../Laudos/editarLaudo.php' . $url . '">Gerar outro laudo</a>
                            <br>
                            <a href="../../Laudos/gerar_pdf.php?data='.$retornoLaudo[0]['data'].'&modelo=' . $modelo . '&numeroSerie=' . $retornoLaudo[0]['serial_number'] . '&pecas=' . $retornoLaudo[0]['pecas_trocadas'] . '">Ver laudo</a>';
                        } else {
                            echo 'Parece que não existe um laudo para essa folha... <br>';
                            echo 'Deseja emitir o laudo?';
                            echo '<br><a href="../../Laudos/editarLaudo.php' . $url . '">Gerar laudo</a>';
                        }
                        ?>
                    </div>

                </div>

            </div>

        </div>
    </section>

</body>

</html>