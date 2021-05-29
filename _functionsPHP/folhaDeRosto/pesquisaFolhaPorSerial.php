<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}
if (isset($_GET['numero_serial'])) {
    $objFolhaDeRosto = new FolhaDeRosto();
    $objUsuarioAux = new Usuario();
    $objUsuario = new Usuario();
    $objUsuario->setUsuario($_SESSION['usuario']['usuario']);
    $objUsuario->consulta_usuario_por_usuario();

    $objFolhaDeRosto->setNumero_serie($_GET['numero_serial']);
    $objFolhaDeRosto->consultar_por_serial();

    $objUsuarioAux->setCod((int) $objFolhaDeRosto->getUsuario());
    if ($objUsuarioAux->consulta_usuario_por_cod()) {
        $classeMsg = "bg-success";
        $data = str_replace("/", "-", $objFolhaDeRosto->getEntrada_laboratorio());

        $date1 = date_create(date('Y-m-d', strtotime($data)));
        $date2 = date_create(date("Y-m-d"));
        $diff = date_diff($date1, $date2);

        $diferencaDeDatas = $diff->format("%a");

        if ($diferencaDeDatas > 5) {
            $classeMsg = "bg-danger";
        } else if ($diferencaDeDatas > 2) {
            $classeMsg = "bg-warning";
        }

        $msgFooter = "AGING: " . $diferencaDeDatas . " dia(s)";
        if (strlen($objFolhaDeRosto->getLaudo_emitido()) > 5) {
            $msgFooter = "O laudo desta folha já foi emitido!";
        }
        echo '<a href="../responsabilizar/folhasDeRosto.php?folha=' . $objFolhaDeRosto->getCod() . '">
            <div class="card ' . $classeMsg . ' m-3 disabled" style="max-width: 18rem;">
                <div class="card-header">Nome do cliente: ' . $objFolhaDeRosto->getNome_cliente() . '</div>
                    <div class="card-body text-white">
                    <h5 class="card-title">Código da folha: ' . $objFolhaDeRosto->getCod() . '</h5>
                    <h5 class="card-title">Modelo: ' . $objFolhaDeRosto->getModelo() . '</h5>
                    <h5 class="card-title">Numero de Serie: ' . $objFolhaDeRosto->getNumero_serie() . '</h5>    
                        <p class="card-text">Data de entrada no laboratório: <strong>' . $objFolhaDeRosto->getEntrada_laboratorio() . '</strong></p>
                        <p class="card-text">Reincidência: ' . $objFolhaDeRosto->getReincidencia() . '</p>
                        <p class="card-text">Folha criada por: <strong>' . $objUsuarioAux->getNome() . '</strong></p>
                    </div>
                    <div class="card-footer text-black">' . $msgFooter . '</div>

            </div>
            </a>';
    } else {
        $objFolhaDeRosto = new FolhaDeRosto();
        $objUsuarioAux = new Usuario();
        $folhasDeRosto = $objFolhaDeRosto->consultar_todas();

        if (!isset($_GET['folha'])) {
            if ($folhasDeRosto !== false) {
                foreach ($folhasDeRosto as $value) {
                    $objUsuarioAux->setCod((int) $value['usuario']);
                    $objUsuarioAux->consulta_usuario_por_cod();
                    $classeMsg = "bg-success";
                    $data = str_replace("/", "-", $value['entrada_laboratorio']);

                    $date1 = date_create(date('Y-m-d', strtotime($data)));
                    $date2 = date_create(date("Y-m-d"));
                    $diff = date_diff($date1, $date2);

                    $diferencaDeDatas = $diff->format("%a");

                    if ($diferencaDeDatas > 5) {
                        $classeMsg = "bg-danger";
                    } else if ($diferencaDeDatas > 2) {
                        $classeMsg = "bg-warning";
                    }

                    $msgFooter = "AGING: " . $diferencaDeDatas . " dia(s)";
                    if (strlen($value['laudo_emitido']) > 5) {
                        $msgFooter = "O laudo desta folha já foi emitido!";
                    }
                    if ($objUsuario->getNivel() > 1) {
                        echo '<a href="../responsabilizar/folhasDeRosto.php?folha=' . $value['cod'] . '">
                    <div class="card ' . $classeMsg . ' m-3 disabled" style="max-width: 18rem;">
                        <div class="card-header">Nome do cliente: ' . $value['nome_cliente'] . '</div>
                            <div class="card-body text-white">
                            <h5 class="card-title">Código da folha: ' . $value['cod'] . '</h5>
                            <h5 class="card-title">Modelo: ' . $value['modelo'] . '</h5>
                            <h5 class="card-title">Numero de Serie: ' . $value['numero_serie'] . '</h5>
                                <p class="card-text">Data de entrada no laboratório: <strong>' . $value['entrada_laboratorio'] . '</strong></p>
                                <p class="card-text">Reincidência: ' . $value['reincidencia'] . '</p>
                                <p class="card-text">Folha criada por: <strong>' . $objUsuarioAux->getNome() . '</strong></p>
                            </div>
                            <div class="card-footer text-black">' . $msgFooter . '</div>

                    </div>
                    </a>';
                    } else {
                        echo '<div class="card ' . $classeMsg . ' m-3" style="max-width: 18rem;">
                        <div class="card-header">Nome do cliente: ' . $value['nome_cliente'] . '</div>
                            <div class="card-body text-white">
                                <h5 class="card-title">Modelo: ' . $value['modelo'] . '</h5>
                                <p class="card-text">Data de entrada no laboratório: <strong>' . $value['entrada_laboratorio'] . '</strong></p>
                                <p class="card-text">Reincidência: ' . $value['reincidencia'] . '</p>
                                <p class="card-text">Folha criada por: <strong>' . $objUsuarioAux->getNome() . '</strong></p>
                            </div>
                            <div class="card-footer text-black">' . $msgFooter . '</div>

                    </div>
                    ';
                    }
                }
            }
        }
    }
}
