<?php
session_start();
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
require '../../_Class/ParadaTemporaria.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}
$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

$objConexao = new Conexao();
$cmdSql = "call maquinas_voltaram_tecnico(" . $_SESSION['usuario']['cod'] . ")";
$retorno = $objConexao->Consultar($cmdSql);


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- DATA TABLE -->
    <link rel="stylesheet" href="../../assets/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../assets/datatable/css/buttons.dataTables.min.css">
    <title>Consultar Folhas de Rosto | SFC</title>

</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>

    <div class="container">
        <div id="acoes">

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionando máquina para parada temporária</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="../../_functionsPHP/paradaTemporaria/criar.php" method="get">
                                <label for="codFolha">Este é o cod da folha:</label><br>
                                <input type="text" readonly required id="codFolha" name="folha">
                                <label for="motivo" style="margin-top: 1rem;">Digite o motivo da parada temporária desta máquina</label>
                                <textarea name="motivo" id="motivo" cols="40" rows="4" style="padding:1rem;resize: none;" required></textarea>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="text-muted mt-5">
                        Você é Responsável por essas folhas:
                    </h1>
                </div>
            </div>

            <div class="row" id="cards">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Nº Série</th>
                            <th scope="col">Reincidência</th>
                            <th scope="col">Data de entrada</th>
                            <th scope="col">Criada por:</th>
                            <th scope="col">Responsável(eis)</th>
                            <th scope="col">AGING na assistência</th>
                            <th scope="col">Status</th>
                            <th scope="col">Parada temporária</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $objFolhaDeRosto = new FolhaDeRosto();
                        $objUsuarioAux = new Usuario();
                        if (!isset($_GET['folha'])) {
                            if ($objUsuario->getNivel() > 1) {

                                //consultando todas as folhas daquele tecnico
                                $objTecnicoResponsavelFolha = new TecnicoResponsavelFolha();
                                $objTecnicoResponsavelFolha->setTec_responsavel($_SESSION['usuario']['cod']);

                                $minhasFolhasDeRosto = $objTecnicoResponsavelFolha->consultarFolhas();

                                if ($minhasFolhasDeRosto !== false) {
                                    foreach ($minhasFolhasDeRosto as $minhaFolhaDeRosto) {
                                        $responsaveis = NULL;
                                        $objTecnicoResponsavelFolha = new TecnicoResponsavelFolha();
                                        $objTecnicoResponsavelFolha->setCod_folha_de_rosto($minhaFolhaDeRosto['cod_folha_de_rosto']);
                                        $responsaveisRetorno = $objTecnicoResponsavelFolha->consultaResponsaveis();
                                        if ($responsaveisRetorno !== false) {
                                            foreach ($responsaveisRetorno as $val) {
                                                $objUsuarioAuxResponsavel = new Usuario();
                                                $objUsuarioAuxResponsavel->setCod((int) $val['tec_responsavel']);
                                                $objUsuarioAuxResponsavel->consulta_usuario_por_cod();
                                                $responsaveis .= $objUsuarioAuxResponsavel->getNome() . " / ";
                                            }
                                        }

                                        //consulta da folha de rosto por codigo
                                        $objFolhaDeRosto->setCod($minhaFolhaDeRosto['cod_folha_de_rosto']);
                                        $folhasDeRosto = $objFolhaDeRosto->consultar_por_codigo();

                                        //consulta usuario da folha para poder mostrar o nome posteriormente
                                        $objUsuarioAux->setCod((int) $objFolhaDeRosto->getUsuario());
                                        $objUsuarioAux->consulta_usuario_por_cod();
                                        $classeMsg = "bg-success";


                                        //calculo para mostrar a quantidade de dias
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
                                            $classeMsg = "bg-info";
                                        }

                                        if ($objFolhaDeRosto->getReincidencia() == "Sim" || $objFolhaDeRosto->getReincidencia() == "SIM") {
                                            $classeMsg = "bg-dark";
                                        }

                                        if (empty($objFolhaDeRosto->getNumero_serie())) {
                                            $objFolhaDeRosto->setNumero_serie("Sem número de serie");
                                        }

                                        //verifica o status da maquina, se foi preenchido todos os campos e esta pronto para a revisao
                                        if (!empty($objFolhaDeRosto->getDefeito_apresentado()) && !empty($objFolhaDeRosto->getServicos_executados()) && !empty($objFolhaDeRosto->getPecas_trocadas())) {
                                            $classeMsg = "d-none";
                                        } else {
                                            $msgStatus = "Máquina em processo";

                                            //consultar na parada por codigo da folha para mostrar o status
                                            $objParadaTemporaria = new ParadaTemporaria();
                                            $objParadaTemporaria->setCod_folha($objFolhaDeRosto->getCod());
                                            $resultParada = $objParadaTemporaria->consultarPorCodFolha();
                                            if ($resultParada != false) {
                                                $msgStatus = $objParadaTemporaria->getStatus_parada() . " Motivo: " . $objParadaTemporaria->getMotivo();
                                            }
                                        }

                                        if ($classeMsg != "d-none") {
                                            //colocando os dados na tabela
                                            echo '
                                <tr class="' . $classeMsg . ' text-white">
                                
                                    <th scope="row"><a class="text-white" href="../editar/folhasDeRosto.php?folha=' . $objFolhaDeRosto->getCod() . '">' . $objFolhaDeRosto->getCod() . '</a></th>
                                    <td>' . $objFolhaDeRosto->getNome_cliente() . '</td>
                                    <td>' . $objFolhaDeRosto->getModelo() . '</td>
                                    <td><a class="badge badge-light" href="../editar/folhasDeRosto.php?folha=' . $objFolhaDeRosto->getCod() . '">' . $objFolhaDeRosto->getNumero_serie() . '</a></td>
                                    <td>' . $objFolhaDeRosto->getReincidencia() . '</td>
                                    <td>' . $objFolhaDeRosto->getEntrada_laboratorio() . '</td>
                                    <td>' . $objUsuarioAux->getNome() . '</td>
                                    <td>' . $responsaveis . '</td>
                                    <td>' . $msgFooter . '</td>
                                    <td>' . $msgStatus . '</td>
                                    <td style="text-align:center;">
                                        <a class="btn badge badge-danger" style="font-size: 11pt;" data-toggle="modal" data-target="#exampleModal" onclick="trocarInformacoesModalParadaTemporaria(' . $objFolhaDeRosto->getCod() . ')">Ativar</a>
                                        <a class="badge badge-light" style="font-size: 11pt; margin:5px;" href="../../_functionsPHP/paradaTemporaria/remover.php?folha=' . $objFolhaDeRosto->getCod() . '">Desativar</a>

                                    </td>
                                    
                                </tr>';
                                        }
                                    }
                                } else {
                                    '<strong>Ainda não possui nenhuma folha por aqui!</strong>';
                                }
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Button trigger modal -->
        <button type="button" id="revisao" class="btn btn-dark text-white" data-toggle="modal" data-target="#modalVoltar" style="position: fixed;bottom: 3em;right: 3em;font-size:2em;">
            <?php if (!empty($retorno)) {
                echo '<img src="../../assets/img/warning.svg" alt="" srcset="" width="32px" class="mr-2">';
                echo count($retorno);
            } else {
                echo 0;
            } ?>
        </button>
        <!-- Modal -->
        <div class="modal fade" id="modalVoltar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 1200px!important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Suas máquinas que voltaram para o laboratório</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Nº Série</th>
                                    <th scope="col">Responsável(eis)</th>
                                    <th scope="col">AGING na assitência</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Motivo</th>
                                    <th scope="col">Parada temporária</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $objFolhaDeRosto = new FolhaDeRosto();
                                $objUsuarioAux = new Usuario();
                                if (!isset($_GET['folha'])) {
                                    if ($objUsuario->getNivel() > 1) {



                                        $minhasFolhasDeRosto = $retorno;

                                        if ($minhasFolhasDeRosto !== false) {
                                            foreach ($minhasFolhasDeRosto as $minhaFolhaDeRosto) {


                                                $objFolhaDeRosto->setCod($minhaFolhaDeRosto['cod_folha']);
                                                $folhasDeRosto = $objFolhaDeRosto->consultar_por_codigo();

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
                                                    $classeMsg = "bg-info";
                                                }

                                                if ($objFolhaDeRosto->getReincidencia() == "Sim" || $objFolhaDeRosto->getReincidencia() == "SIM") {
                                                    $classeMsg = "bg-dark";
                                                }
                                                if (empty($objFolhaDeRosto->getNumero_serie())) {
                                                    $objFolhaDeRosto->setNumero_serie("Sem número de serie");
                                                }

                                                foreach ($retorno as $value) {
                                                    if ($value['cod_folha'] == $objFolhaDeRosto->getCod())
                                                        $motivo = $value['motivo'];
                                                }


                                                $msgStatus = "A MAQUINA VOLTOU";

                                                //consultar na parada por codigo da folha para mostrar o status
                                                $objParadaTemporaria = new ParadaTemporaria();
                                                $objParadaTemporaria->setCod_folha($objFolhaDeRosto->getCod());
                                                $resultParada = $objParadaTemporaria->consultarPorCodFolha();
                                                if ($resultParada != false) {
                                                    $msgStatus = $objParadaTemporaria->getStatus_parada() . " Motivo: " . $objParadaTemporaria->getMotivo();
                                                }

                                                echo '
                                <tr class="' . $classeMsg . ' text-white">
                                
                                    <th scope="row"><a class="text-white" href="../editar/folhasDeRosto.php?folha=' . $objFolhaDeRosto->getCod() . '">' . $objFolhaDeRosto->getCod() . '</a></th>
                                    <td>' . $objFolhaDeRosto->getNome_cliente() . '</td>
                                    <td>' . $objFolhaDeRosto->getModelo() . '</td>
                                    <td><a class="badge badge-light" href="../editar/at.php?folha=' . $objFolhaDeRosto->getCod() . '">' . $objFolhaDeRosto->getNumero_serie() . '</a></td>
                                    <td>' . $objFolhaDeRosto->getReincidencia() . '</td>
                                    <td>' . $objFolhaDeRosto->getEntrada_laboratorio() . '</td>
                                    <td>' . $msgStatus . '</td>
                                    <td>' . $motivo . '</td>
                                    <td style="text-align:center;">
                                        <a class="btn badge badge-danger" style="font-size: 11pt;" data-toggle="modal" data-target="#exampleModal" data-dismiss="modal" onclick="trocarInformacoesModalParadaTemporaria(' . $objFolhaDeRosto->getCod() . ')">Ativar</a>
                                        <a class="badge badge-light" style="font-size: 11pt; margin:5px;" href="../../_functionsPHP/paradaTemporaria/remover.php?folha=' . $objFolhaDeRosto->getCod() . '">Desativar</a>

                                    </td>
                                </tr>';
                                            }
                                        } else {
                                            '<strong>Ainda não possui nenhuma folha por aqui!</strong>';
                                        }
                                    }
                                }
                                // var_dump(count($objFolhaDeRosto->consultar_todas()));
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer style="position: relative;bottom:0;width:100%;">
        <img class="card-img-bottom" style="width: 10% !important; float:right;" src="../../assets/img/logo.png" alt="Card image cap">
    </footer>
    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../../assets/datatable/js/buttons.flash.min.js"></script>
    <script src="../../assets/datatable/js/jszip.min.js"></script>
    <script src="../../assets/datatable/js/pdfmake.min.js"></script>
    <script src="../../assets/datatable/js/vfs_fonts.js"></script>
    <script src="../../assets/datatable/js/buttons.html5.min.js"></script>
    <script src="../../assets/datatable/js/buttons.print.min.js"></script>
    <script>
        function trocarInformacoesModalParadaTemporaria(codFolha) {
            $("#codFolha").val(codFolha);
        }

        $(document).ready(function() {
            $('#table').DataTable({
                order: [
                    [0, 'desc']
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>