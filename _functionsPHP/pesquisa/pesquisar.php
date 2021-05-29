<?php
if (!isset($path)) {
    $path = '../../';
}

if (!isset($_SESSION))
    session_start();

require_once $path . '_Class/Usuario.php';
require_once $path . '_Class/FolhaDeRosto.php';
require_once $path . '_Class/TecnicoResponsavelFolha.php';
require_once $path . '_Class/Revisao.php';
require_once $path . '_Class/LaudoEmitido.php';

$objRevisao = new Revisao();

$objConexao = new Conexao();
$cmdSql = "SELECT * FROM `folha_de_rosto` WHERE ";
$contarCmdSql = 0;
//montar o cmdSql para fazer o filtro

if (!empty($_GET['dataEntrada'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " folha_de_rosto.lancamento_almoxarife = '" . date("d/m/Y", strtotime($_GET['dataEntrada'])) . "'";
    $contarCmdSql += 1;
endif;

if (!empty($_GET['dataSaida'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " folha_de_rosto.laudo_emitido = '" . date("d/m/Y", strtotime($_GET['dataSaida'])) . "'";
    $contarCmdSql += 1;
endif;

if (!empty($_GET['tipo_solicitacao'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " folha_de_rosto.tipo_solicitacao like '%" . $_GET['tipo_solicitacao'] . "%'";
    $contarCmdSql += 1;
endif;

if (!empty($_GET['reincidencia'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " folha_de_rosto.reincidencia like '%" . $_GET['reincidencia'] . "%'";
    $contarCmdSql += 1;
endif;

if (!empty($_GET['dataEntradaLaboratorio'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " folha_de_rosto.entrada_laboratorio = '" . date("d/m/Y", strtotime($_GET['dataEntradaLaboratorio'])) . "'";
    $contarCmdSql += 1;
endif;

if (!empty($_GET['usuario'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " folha_de_rosto.usuario = " . $_GET['usuario'] . "";
    $contarCmdSql += 1;
endif;

if (!empty($_GET['modelo'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " folha_de_rosto.modelo = '" . $_GET['modelo'] . "'";
    $contarCmdSql += 1;
endif;

if (!empty($_GET['partNumber'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " folha_de_rosto.part_number = '" . $_GET['partNumber'] . "'";
    $contarCmdSql += 1;
endif;

if (!empty($_GET['pesquisa'])) :
    if ($contarCmdSql > 0)
        $cmdSql .= " AND";
    $cmdSql .= " (folha_de_rosto.nome_cliente like '%" . $_GET['pesquisa'] . "%'  OR folha_de_rosto.numero_serie like '%" . $_GET['pesquisa'] . "%' or folha_de_rosto.modelo like '%" . $_GET['pesquisa'] . "%')";
    $contarCmdSql += 1;
endif;

if ($contarCmdSql == 0) {
    $cmdSql = "SELECT * FROM `folha_de_rosto` order by folha_de_rosto.cod DESC LIMIT 400";
}

$objFolhaDeRosto = new FolhaDeRosto();
$objUsuarioAux = new Usuario();


$folhasDeRosto = $objConexao->Consultar($cmdSql);
if ($folhasDeRosto !== false) {

    foreach ($folhasDeRosto as $folha) {
        $responsaveis = NULL;
        $objTecnicoResponsavelFolha = new TecnicoResponsavelFolha();
        $objTecnicoResponsavelFolha->setCod_folha_de_rosto($folha['cod']);
        $responsaveisRetorno = $objTecnicoResponsavelFolha->consultaResponsaveis();

        if ($responsaveisRetorno !== false) {
            foreach ($responsaveisRetorno as $val) {
                $objUsuarioAuxResponsavel = new Usuario();
                $objUsuarioAuxResponsavel->setCod((int) $val['tec_responsavel']);
                $objUsuarioAuxResponsavel->consulta_usuario_por_cod();
                $responsaveis .= $objUsuarioAuxResponsavel->getNome() . " / ";
            }
        } else {
            $responsaveis = "Aguardando responsáveis";
        }

        $cmdSql = "CALL logs_consultarPorFolhaUltimo('" . $folha['cod'] . "')";
        $ultimoLog = $objConexao->Consultar($cmdSql)[0];


        $objUsuarioAux->setCod((int) $folha['usuario']);
        $objUsuarioAux->consulta_usuario_por_cod();

        if (isset($_GET['cargo']))
            $cargo = $_GET['cargo'];

        if ($folha['entrada_laboratorio'] == null) {
            $folha['entrada_laboratorio'] = "Indisponível";
        }
        if (empty($folha['numero_serie'])) {
            $folha['numero_serie'] = "Sem número de serie";
        }


        switch ($cargo) {
            case 'AT':
                if (empty($folha['laudo_emitido'])) {
                    $folha['laudo_emitido'] = "Indisponível";
                }
                $classeMsg = "bg-success";
                $data = str_replace("/", "-", $folha['lancamento_almoxarife']);

                $date1 = date_create(date('Y-m-d', strtotime($data)));
                $date2 = date_create(date("Y-m-d"));
                $diff = date_diff($date1, $date2);

                $diferencaDeDatas = $diff->format("%a");

                if ($diferencaDeDatas > 5) {
                    $classeMsg = "bg-danger";
                } else if ($diferencaDeDatas > 2) {
                    $classeMsg = "bg-warning";
                }

                $msgFooter = $diferencaDeDatas . " dia(s)";
                if (strlen($folha['laudo_emitido']) > 5 && $folha['laudo_emitido'] !== "Indisponível") {
                    $msgFooter = "<a class='badge badge-danger' href='../ver/laudo.php?folha=";
                    $msgFooter .= $folha['numero_serie'] . "'>Ver Laudo</a>";
                    $classeMsg = "bg-info";
                }

                if ($folha['reincidencia'] == "Sim") {
                    $classeMsg = "bg-dark";
                }

                if ($folha['entrada_laboratorio'] == null) {
                    $folha['entrada_laboratorio'] = "Indisponível";
                }
                if (empty($folha['numero_serie'])) {
                    $folha['numero_serie'] = "Sem número de serie";
                }
                echo '
                                    <tr class="' . $classeMsg . ' text-white">

                                    <th scope="row">' . $folha['cod'] . '</th>
                                    <td>' . $folha['lancamento_almoxarife'] . '</td>
                                    <td>' . $folha['nome_cliente'] . '</td>
                                    <td>' . $folha['tipo_solicitacao'] . '</td>
                                    <td>' . $folha['modelo'] . '</td>
                                    <td><a class="badge badge-light" href="../responsabilizar/folhasDeRosto.php?folha=' . $folha['cod'] . '">' . $folha['numero_serie'] . '</a></td>
                                    <td>' . $folha['reincidencia'] . '</td>
                                    <td>' . $folha['entrada_laboratorio'] . '</td>
                                    <td>' . $responsaveis . '</td>
                                    <td>' . $ultimoLog['log'] . '</td>
                                    <td>' . $msgFooter . '</td>
                                    <td>' . $folha['laudo_emitido'] . '</td>

                                    </tr>
                                    ';
                break;
            case 'Adm':
                if (empty($folha['laudo_emitido'])) {
                    $folha['laudo_emitido'] = "Indisponível";
                }
                if ($folha['reincidencia'] == "Sim" || $folha['reincidencia'] == "SIM") {
                    $classeMsg = "bg-dark text-white";
                } else {
                    $classeMsg = "bg-white text-dark";
                }

                if ($folha['entrada_laboratorio'] == null) {
                    $folha['entrada_laboratorio'] = "Indisponível";
                }
                if (empty($folha['numero_serie'])) {
                    $folha['numero_serie'] = "Sem número de serie";
                }

                echo '
                <tr class="' . $classeMsg . ' text-white">

                <th scope="row">' . $folha['cod'] . '</th>
                    <td>' . $folha['nome_cliente'] . '</td>
                    <td>' . $folha['tipo_solicitacao'] . '</td>
                    <td>' . $folha['modelo'] . '</td>
                    <td><a class="badge badge-danger btn" data-toggle="modal" data-target="#exampleModal" onclick="alteraModal(' . $folha['cod'] . ')">' . $folha['numero_serie'] . '</a></td>
                    <td>' . $folha['reincidencia'] . '</td>
                    <td>' . $folha['entrada_laboratorio'] . '</td>
                    <td>' . $folha['nome_cliente'] . '</td>
                    <td>' . $responsaveis . '</td>
                    <td>' . $ultimoLog['log'] . '</td>
                    <td><a href="editar.php?folha=' . $folha['cod'] . '" class="badge badge-danger btn">Editar</a></td>

                </tr>';
                break;
            case 'EmitirLaudo':
                $classeMsg = "bg-success";
                $data = str_replace("/", "-", $folha['lancamento_almoxarife']);

                $date1 = date_create(date('Y-m-d', strtotime($data)));
                $date2 = date_create(date("Y-m-d"));
                $diff = date_diff($date1, $date2);

                $diferencaDeDatas = $diff->format("%a");

                if ($diferencaDeDatas > 5) {
                    $classeMsg = "bg-danger";
                } else if ($diferencaDeDatas > 2) {
                    $classeMsg = "bg-warning";
                }

                $msgFooter = $diferencaDeDatas . " dia(s)";

                if ($folha['reincidencia'] == "Sim" || $folha['reincidencia'] == "SIM") {
                    $classeMsg = "bg-dark text-white";
                } else {
                    $classeMsg = "bg-white text-dark";
                }

                //VERIFICA SE A MAQUINA PASSOU POR TODOS OS PROCESSOS
                if (!empty($folha['defeito_apresentado']) && !empty($folha['servicos_executados']) && !empty($folha['pecas_trocadas'])) {
                    //VERIFICIA SE O LAUDO JA FOI EMITIDO
                    if (!empty($folha['laudo_emitido'])) {
                        if ($folha['laudo_emitido'] > 4) {
                            //AVISO-> VARIÁVEL UTILIZADA PARA VERIFICAR SE A MAQUINA FOI FINALIZADA! NAO EXCLUIR
                            $msgFooter = 'Finalizado';
                        }
                    } else
                        $objRevisao->setCod_folha($folha['cod']);

                    $maquina = $objRevisao->consultar_porCodFolha()[0];
                    $statusRevisao = NULL;

                    if ($maquina != false) {
                        switch ($maquina['status']) {
                            case '0':
                                $statusRevisao = "Esperando revisão";
                                break;
                            case '1':
                                $statusRevisao = "Tudo certo";
                                break;
                            case '2':
                                $statusRevisao = "Voltar para técninco";
                                break;
                            default:
                                $statusRevisao = "s";
                                break;
                        }
                    }

                    if ($statusRevisao != "Tudo certo") {
                        $msgLaudo = $statusRevisao;
                    }


                    //adiciona os botoes de ação
                    if ($msgFooter == "Finalizado") {
                        $objLaudoEmitido = new LaudoEmitido();
                        $objLaudoEmitido->setSerial_number($folha['numero_serie']);
                        $retornoLaudo = $objLaudoEmitido->consultar_por_serial();
                        $modelo = "COMPAQ Presario " . $retornoLaudo[0]['modelo_maquina'];

                        $msgLaudo = '<a class="badge badge-danger" href="../../pages/saida/escolher.php?folha='.$folha['cod'].'">Visualizar</a>';
                    } else {
                        $msgLaudo = '<a class="badge badge-danger" href="../../PDF/editarLaudo?folha=' . $folha['cod'] . '">Laudo pronto para ser gerado</a>';
                    }
                } else {
                    $msgLaudo = "Máquina em processo";
                }

                if (empty($folha['entrada_laboratorio'])) {
                } else {
                    if (empty($folha['laudo_emitido'])) {
                        $folha['laudo_emitido'] = "Indisponível";
                    }
                    echo '
                    <tr class="' . $classeMsg . ' text-white">
                
                    <th scope="row">' . $folha['cod'] . '</th>
                    <td>' . $folha['lancamento_almoxarife'] . '</td>
                    <td>' . $folha['nome_cliente'] . '</td>
                    <td>' . $folha['tipo_solicitacao'] . '</td>
                    <td>' . $folha['modelo'] . '</td>
                    <td>' . $folha['numero_serie'] . '</td>
                    <td>' . $folha['reincidencia'] . '</td>
                    <td>' . $folha['entrada_laboratorio'] . '</td>
                    <td>' . $objUsuarioAux->getNome() . '</td>
                    <td>' . $responsaveis . '</td>
                    <td>' . $folha['laudo_emitido'] . '</td>
                    <td>' . $msgLaudo . '</td>
                </tr>';
                }
                break;

            default:
                if ($folha['reincidencia'] == "Sim" || $folha['reincidencia'] == "SIM") {
                    $classeMsg = "bg-dark text-white";
                } else {
                    $classeMsg = "bg-white text-dark";
                }

                echo '
            <tr class="' . $classeMsg . '">

            <th scope="row">' . $folha['cod'] . '</th>
                <td>' . $folha['nome_cliente'] . '</td>
                <td>' . $folha['tipo_solicitacao'] . '</td>
                <td>' . $folha['modelo'] . '</td>
                <td><a class="badge badge-danger btn" data-toggle="modal" data-target="#exampleModal" onclick="alteraModal(' . $folha['cod'] . ')">' . $folha['numero_serie'] . '</a></td>
                <td>' . $folha['reincidencia'] . '</td>
                <td>' . $folha['entrada_laboratorio'] . '</td>
                <td>' . $folha['nome_cliente'] . '</td>
                <td>' . $responsaveis . '</td>
                <td>' . $ultimoLog['log'] . '</td>
                <td>' . $folha['laudo_emitido'] . '</td>

            </tr>';
                break;
        }
    }
}
