<?php
session_start();
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
require '../../_Class/LaudoEmitido.php';
require '../../_Class/Revisao.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}
$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style=" max-width:1200px !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Dados da Folha de rosto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="overflow-y:scroll; height: 500px;">
                        <div class="row">
                            <div class="col">
                                <h4><strong>Data entrada na assistência</strong></h4>
                                <p id="dataEntradaAssistencia">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Tipo Solicitação</strong></h4>
                                <p id="tipoSolicitacao">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Cliente</strong></h4>
                                <p id="cliente">1/1/1</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h4><strong>Reincidência</strong></h4>
                                <p id="reincidencia">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Número de Série</strong></h4>
                                <p id="numeroSerie">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Part Number</strong></h4>
                                <p id="partNumber">1/1/1</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h4><strong>Estética</strong></h4>
                                <p id="estetica">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Falha Relatada</strong></h4>
                                <p id="falhaRelatada">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Defeito Encontrado</strong></h4>
                                <p id="defeitoEncontrado">1/1/1</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h4><strong>Solução</strong></h4>
                                <p id="solucao">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Peças e Ajustes</strong></h4>
                                <p id="pecasAjustes">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Técnico Responsável</strong></h4>
                                <p id="tecnicoResponsavel">1/1/1</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h4><strong>Data saída na assistência</strong></h4>
                                <p id="dataSaidaAssistencia">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Burnin test Falha</strong></h4>
                                <p id="burninTest">1/1/1</p>
                            </div>
                            <div class="col">
                                <h4><strong>Causa Reincidência</strong></h4>
                                <p id="causaReincidencia">1/1/1</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="acoes">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="text-muted mt-5">
                        Revisão de máquinas
                    </h1>
                </div>
            </div>

            <div class="row" id="cards">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Data de entrada na logística</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Numero de serie</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Téc responsável</th>
                            <th scope="col">Status Revisão</th>
                            <th scope="col">Acões</th>
                            <th scope="col">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $objFolhaDeRosto = new FolhaDeRosto();
                        $objRevisao = new Revisao();
                        $objTecResponsavel = new TecnicoResponsavelFolha();
                        $objUsuarioAux = new Usuario();

                        $maquinasParaRevisao = $objRevisao->consultar_todos();
                        if ($maquinasParaRevisao != false) {
                            foreach ($maquinasParaRevisao as $maquina) {
                                $objFolhaDeRosto->setCod($maquina['cod_folha']);
                                $statusRevisao = NULL;
                                switch ($maquina['status']) {
                                    case '0':
                                        $statusRevisao = "Esperando revisão";
                                        $bgClass = "bg-success";
                                        break;
                                    case '1':
                                        $statusRevisao = "Tudo certo";
                                        $bgClass = "bg-info";
                                        break;
                                    case '2':
                                        $statusRevisao = "Voltar para técnico";
                                        $bgClass = "bg-danger";
                                        break;
                                    default:
                                        $statusRevisao = "s";
                                        break;
                                }

                                $objFolhaDeRosto->consultar_por_codigo();
                                if($maquina['status'] !== '1'){
                                    $objTecResponsavel->setCod_folha_de_rosto($maquina['cod_folha']);
                                    $tecnico = $objTecResponsavel->consultaResponsaveis()[0]['tec_responsavel'];
                                    $objUsuarioAux->setCod($tecnico);
                                    $objUsuarioAux->consulta_usuario_por_cod();
                                    echo '
                                    <tr class=" bg-info text-white">
                                
                                    <th scope="row"><a class="text-white" href="">' . $objFolhaDeRosto->getCod() . '</a></th>
                                    <td>' . $objFolhaDeRosto->getLancamento_almoxarife() . '</td>
                                    <td>' . $objFolhaDeRosto->getNome_cliente() . '</td>
                                    <td><a class="badge badge-light btn" data-toggle="modal" data-target="#exampleModal" onclick="alteraModal(' . $objFolhaDeRosto->getCod() . ')">' . $objFolhaDeRosto->getNumero_serie() . '</a></td>
                                    <td>' . $objFolhaDeRosto->getModelo() . '</td>
                                    <td>' . $objUsuarioAux->getNome() . '</td>
                                    <td class="' . $bgClass . '" >' . $statusRevisao . '</td>
                                    <td>
                                    <a class="btn btn-success" href="../../_functionsPHP/Revisao/revisao.php?status=1&revisao=' . $maquina['cod'] . '&codFolha='.$maquina['cod_folha'].'">OK</a>
                                    <a class="btn btn-danger ml-1" data-toggle="modal" data-target="#modalRevisao" onclick="setCodRevisao('.$maquina['cod'].');setCodFolha('.$maquina['cod_folha'].')">Voltar</a></td>
                                    <td>' . $maquina['motivo'] . '</td>
                                </tr>';
                                }
                            };
                        }

                        ?>

                    </tbody>
                </table>

                <!-- Modal -->
                <div class="modal fade" id="modalRevisao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Adicione o motivo de fazer a máquina voltar para o técnico</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <textarea name="" id="textMotivo" cols="30" rows="4" style="resize: none;width:100%" required name="motivo"></textarea>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="revisaoVoltar($('#textMotivo').val())">Enviar</button>
                                </form>
                            </div>
                        </div>
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
        var codRevisao = null;

        function setCodRevisao(_codRevisao){
            codRevisao = _codRevisao;
        };

        function setCodFolha(_codFolha){
            codFolha = _codFolha;
        };

        function revisaoVoltar(motivo) {
            var data = {
                revisao: codRevisao,
                motivo: motivo,
                codFolha : codFolha
            }

            $.get("../../_functionsPHP/Revisao/revisao_voltar", data, (retorno) => {
                if (retorno == 1) {
                    window.location.href = window.location.href;
                }
            });
        }

        function alteraModal(codFolha) {
            var data = {
                codFolha: codFolha
            };
            $.get("../../_functionsPHP/folhaDeRosto/consultarDadosPorSerial.php", data, function(retorno) {
                retorno = JSON.parse(retorno);
                console.log(retorno);
                $("#dataEntradaAssistencia").text(retorno['lancamento_almoxarife']);
                $("#tipoSolicitacao").text(retorno['tipo_solicitacao']);
                $("#cliente").text(retorno['nome_cliente']);
                $("#reincidencia").text(retorno['reincidencia']);
                $("#numeroSerie").text(retorno['numero_serie']);
                $("#partNumber").text(retorno['part_number']);
                $("#estetica").text(retorno['desc_estetica_equipamento']);
                $("#falhaRelatada").text(retorno['desc_defeito_reclamado']);
                $("#defeitoEncontrado").text(retorno['defeito_apresentado']);
                $("#solucao").text(retorno['servicos_executados']);
                $("#pecasAjustes").text(retorno['pecas_trocadas']);
                $("#dataSaidaAssistencia").text(retorno['laudo_emitido']);
                $("#burninTest").text(retorno['burnin_test']);
                $("#causaReincidencia").text(retorno['causa_reincidencia']);
                var data = {
                    codFolha: codFolha
                };
                $.get("../../_functionsPHP/tecnicoResponsavel/consultarTecnicoResponsavel.php", data, function(retorno) {
                    $("#tecnicoResponsavel").text(retorno);
                })
            })
        }

        $(document).ready(function() {

            $('#table').DataTable({
                order: [0, 'desc'],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>