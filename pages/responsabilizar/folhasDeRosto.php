<?php
session_start();
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}
$objUsuario = new Usuario();
$objFolhaDeRosto = new FolhaDeRosto();
$objTecnicoResponsavelFolha = new TecnicoResponsavelFolha();

$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();


if (!isset($_GET['folha']) || $objUsuario->getNivel() < 2) {
    header("Location:../../dashboard.php");
} else {
    $objFolhaDeRosto->setCod($_GET['folha']);
    $objFolhaDeRosto->consultar_por_codigo();


    $objTecnicoResponsavelFolha->setTec_responsavel($_SESSION['usuario']['cod']);
    $objTecnicoResponsavelFolha->setCod_folha_de_rosto($_GET['folha']);
    $responsavel = $objTecnicoResponsavelFolha->verificaResponsabilidadeDaFolha();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Consultar Folhas de Rosto | SFC</title>
</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php'?>

    <div class="container">
        <div id="acoes">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="text-muted mt-1">
                        Deseja se responsabilizar por essa folha?
                    </h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <?php

                $folhasDeRosto = $objFolhaDeRosto->consultar_por_codigo();

                $objUsuarioAux = new Usuario();
                $objUsuarioAux->setCod((int) $objFolhaDeRosto->getUsuario());
                $objUsuarioAux->consulta_usuario_por_cod();
                $classeMsg = "bg-success";
                $data = str_replace("/", "-", $objFolhaDeRosto->getLancamento_almoxarife());

                $date1 = date_create(date('Y-m-d', strtotime($data)));
                $date2 = date_create(date("Y-m-d"));
                $diff = date_diff($date1, $date2);

                $diferencaDeDatas = $diff->format("%a");

                if ($diferencaDeDatas > 5) {
                    $classeMsg = "bg-danger";
                } else if ($diferencaDeDatas > 2) {
                    $classeMsg = "bg-warning";
                }

                $msgFooter = "AGING dentro da assistência: " . $diferencaDeDatas . " dia(s)";
                if (strlen($objFolhaDeRosto->getLaudo_emitido()) > 5) {
                    $msgFooter = "O laudo desta folha já foi emitido! <a class='badge badge-light' href='../ver/laudo.php'></a>";
                    $classeMsg = "bg-info";
                }

                if ($objFolhaDeRosto->getReincidencia() == "Sim" || $objFolhaDeRosto->getReincidencia() == "SIM") {
                    $classeMsg = "bg-dark";
                }

                if ($objUsuario->getNivel() > 1) {
                    echo '<div class="card ' . $classeMsg . ' m-3" style="max-width: 18rem;">
                            <div class="card-header text-white">Nome do cliente: ' . $objFolhaDeRosto->getNome_cliente() . '</div>
                                <div class="card-body text-white">
                                    <h5 class="card-title">Código da folha: ' . $objFolhaDeRosto->getCod() . '</h5>    
                                    <h5 class="card-title">Modelo: ' . $objFolhaDeRosto->getModelo() . '</h5>
                                    <p class="card-text">Data de entrada no laboratório: <strong>' . $objFolhaDeRosto->getEntrada_laboratorio() . '</strong></p>
                                    <p class="card-text">Reincidência: ' . $objFolhaDeRosto->getReincidencia() . '</p>
                                    <p class="card-text">Folha criada por: <strong>' . $objUsuarioAux->getNome() . '</strong></p>
                                </div>
                                <div class="card-footer text-white">' . $msgFooter . '</div>

                        </div>';
                }
                // var_dump(count($objFolhaDeRosto->consultar_todas()));
                $urlBtn = "?folha" . $_GET['folha'];
                ?>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-6">
                    <?php
                    if ($responsavel) {
                        echo '<input type="button" class="btn btn-warnign btn-block btn-lg disabled" value="Você já é responsável por essa folha!">
                            <a href="../../pages/ver/folhasDeRosto.php"><input type="button" class="btn btn-danger btn-block btn-lg" value="Voltar"></a>';
                    } else {
                        echo '<form action="../../_functionsPHP/usuario/responsabilizar.php">
                            <input type="text" class="d-none disabled" name="codFolha" value=' . $_GET['folha'] . '>
                            <input type="submit" class="btn btn-success btn-block btn-lg" name="responsabilizar" value="Sim">
                        </form>
                        <a href="../../pages/ver/folhasDeRosto.php"><input type="button" class="btn btn-danger btn-block btn-lg" value="Não"></a>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <footer style="position: relative;bottom:0;width:100%;">
        <img class="card-img-bottom" style="width: 10% !important; float:right;" src="../../assets/img/logo.png" alt="Card image cap">
    </footer>
    <script src="../../assets/js/jquery-3.5.1.js"></script>

    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <?php

    ?>
</body>

</html>