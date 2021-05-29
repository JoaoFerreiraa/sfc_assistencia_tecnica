<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/Revisao.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../index.php");
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

    $lancamentoAlmoxarife = date('Y-m-d', strtotime(str_replace("/", "-", $objFolhaDeRosto->getLancamento_almoxarife())));
    $entradaLaboratório = date('Y-m-d', strtotime(str_replace("/", "-", $objFolhaDeRosto->getEntrada_laboratorio())));
}

$reincidencia = $objFolhaDeRosto->getReincidencia() == "Não" || $objFolhaDeRosto->getReincidencia() == "NÃO" || $objFolhaDeRosto->getReincidencia() == "NAO" || $objFolhaDeRosto->getReincidencia() == "Nao";
$casosReincidencia = (!$reincidencia) ? $objFolhaDeRosto->consultar_reincidencia() : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Continuando Folha de Rosto | SFC</title>



    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>

    <!-- form para a folha de rosto -->

    <section>

        <!-- Modal -->
        <div class="modal fade" id="modalReincidencia" tabindex="-1" role="dialog" aria-labelledby="modalReincidencia" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width:100%;margin:1.75rem">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Histórico de reincidencia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table" id="tableSearch">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Data de entrada</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Tipo Solicitação</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Nº Série</th>
                                    <th scope="col">Reincidência</th>
                                    <th scope="col">Data inicio de reparo</th>
                                    <th scope="col">Data Saída</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbodySearch">

                                <?php if (!$reincidencia) :
                                    foreach ($casosReincidencia as $folha) {
                                        if ($folha['cod'] != $objFolhaDeRosto->getCod()) {
                                            echo '<tr>
                                        <th scope="row">' . $folha['cod'] . '</th>
                                        <td>' . $folha['lancamento_almoxarife'] . '</td>
                                        <td>' . $folha['nome_cliente'] . '</td>
                                        <td>' . $folha['tipo_solicitacao'] . '</td>
                                        <td>' . $folha['modelo'] . '</td>
                                        <td>' . $folha['numero_serie'] . '</td>
                                        <td>' . $folha['reincidencia'] . '</td>
                                        <td>' . $folha['entrada_laboratorio'] . '</td>
                                        <td>' . $folha['laudo_emitido'] . '</td>
                                        <td><a class="badge badge-danger" href="../../PDF/folhaDeRosto.php?folha=' . $folha['cod'] . '" target="_blank">Folha de rosto</a></td>
                                      </tr>';
                                        }
                                    }
                                endif ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- titulo para folha de rosto -->
            <div class="row">
                <div class="col-12">
                    <div class="row mt-2">
                        <div class="col-3">
                            <img src="../../assets/img/logo.png" alt="" width="150px">
                        </div>
                        <div class="col-9">
                            <h1 class=" text-muted">Assistencia Técnica | Folha de rosto</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- corpo para folha de rosto -->
            <div class="row mt-5">
                <div class="col-11">
                    <div class="alert alert-success" id="mensagem" role="alert">
                        Folha editada com sucesso!
                    </div>
                    <form autocomplete="off">
                        <div class="form-group">
                            <input type="text" class="d-none" name="folha" value=<?php echo $_GET['folha'] ?>>
                            <span>Lançamento almoxarife</span>
                            <input type="date" disabled id="dataEntradaAlmoxarife" name="dataEntradaAlmoxarife" value=<?php echo $lancamentoAlmoxarife ?>>
                            <span> Entrada no Laboratório</span>
                            <input type="date" id="dataEntradaLaboratório" name="dataEntradaLaboratório" value=<?php echo $entradaLaboratório;
                                                                                                                if ($objUsuario->getNivel() < 2) echo ' readonly'; ?>>
                            <span> Tipo de Solicitação</span>
                            <select name="tipoSolicitacao" required>
                                <option value="<?php echo $objFolhaDeRosto->getTipo_solicitacao() ?>"><?php echo $objFolhaDeRosto->getTipo_solicitacao() ?></option>
                                <option value="Reparo em Garantia">Reparo em Garantia</option>
                                <option value="Analise de Troca">Analise de Troca</option>
                                <option value="Equipamento Loja">Equipamento Loja</option>
                                <option value="Orçamento Particular">Orçamento Particular</option>
                                <option value="Quebra de Garantia">Quebra de Garantia</option>
                                <option value="Reembolso">Reembolso</option>
                                <option value="Reparo em Lote">Reparo em Lote</option>
                                <option value="Reparo Particular">Reparo Particular</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span>Cliente: </span>
                            <input type="text" name="nomeCliente" disabled <?php echo 'value="' . $objFolhaDeRosto->getNome_cliente() . '"'; ?> style="width: 45%;">
                            <span>Modelo: </span>
                            <select name="modelo" id="modelo">
                                <option value=<?php echo $objFolhaDeRosto->getModelo() ?>><?php echo $objFolhaDeRosto->getModelo() ?></option>
                            </select>
                            <span>PartNumber</span>
                            <input type="text" name="partNumber" value=<?php echo $objFolhaDeRosto->getPart_number() ?>>
                            <br><br>
                            <span>Nº Série</span>
                            <input type="text" name="nSerie" value=<?php echo $objFolhaDeRosto->getNumero_serie() ?>>


                        </div>
                        <div class="form-group">
                            <span>Reincidência:</span>
                            <?php
                            if ($reincidencia) {
                                echo '<input type="radio" value="Sim" class="form-radio-input" name="reicidencia"><span> Sim</span>
                                    <input type="radio" value="Não" class="form-radio-input" name="reicidencia" checked="checked"><span> Não</span>
                                    ';
                            } else {
                                echo '<input type="radio" value="Sim" class="form-radio-input" name="reicidencia"  checked="checked"><span> Sim</span>
                                        <input type="radio" value="Não" class="form-radio-input" name="reicidencia"><span> Não</span>
                                        <br><br>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalReincidencia">Casos anteriores de reincidência</button>
                                        <br><br>
                            <span style="background-color: var(--primary);color:white; padding:5px;text-align:center;border-radius:7px;">Causa Reincidência</span><br>
                            <textarea name="causaReincidencia" id="" cols="30" rows="4" style="margin-top:10px;" required>' . $objFolhaDeRosto->getCausa_reincidencia() . '</textarea>';
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <span>Acompanha fonte:</span>
                            <?php
                            if ($objFolhaDeRosto->getAcompanha_fonte() == "Sim") {
                                echo '<input type="radio" value="Sim" class="form-radio-input" disabled name="acompanhaFonte" checked="checked"><span> Sim</span>
                                    <input type="radio" value="Não" class="form-radio-input" disabled name="acompanhaFonte"><span> Não</span>';
                            } else {
                                echo '<input type="radio" value="Sim" class="form-radio-input" disabled name="acompanhaFonte"><span> Sim</span>
                                    <input type="radio" value="Não" class="form-radio-input" disabled name="acompanhaFonte" checked="checked"><span> Não</span>';
                            }
                            ?>

                        </div>
                        <div class="form-group">
                            <span>Observação</span><br>
                            <textarea cols="30" rows="3" readonly style="resize: none;"><?= $objFolhaDeRosto->getObservacao() ?></textarea>

                        </div>
                        <?php
                        if ($objUsuario->getNivel() > 1) {
                            echo '<div class="form-group">
                            <span>Defeitos Apresentados</span>
                            <textarea class="form-control mt-2" style="resize: none;" name="defeitosApresentado" id="" cols="10" rows="5" required>' . $objFolhaDeRosto->getDefeito_apresentado() . '</textarea>
                        </div>

                        <div id="pecasTrocadas">

                        </div>
                        <div id="tagsPecasTrocadas">
                            
                        </div>
                        <div class="form-group">
                            <span>Serviços Executados:</span>
                            <textarea name="servicosExecutados" class="form-control" cols="30" rows="5">' . $objFolhaDeRosto->getServicos_executados() . '</textarea>
                        </div>
                        <div class="form-group">
                            <span>Burnin Test:</span>
                            <textarea name="burninTest" class="form-control" cols="30" rows="5">' . $objFolhaDeRosto->getBurnin_test() . '</textarea>
                        </div>
                        ';
                        }
                        ?>

                        <br>
                        <input type="submit" name="btnCriar" class="btn btn-danger btn-block btn-lg mb-5" value="Salvar" />
                    </form>
                </div>

            </div>
            <?php
            if (isset($_GET['btnCriar'])) {
                $pecasTrocadas = NULL;

                $objFolhaDeRosto = new FolhaDeRosto();

                $objFolhaDeRosto->setCod($_GET['folha']);
                $objFolhaDeRosto->setPart_number($_GET['partNumber']);
                $objFolhaDeRosto->setUsuario($_SESSION['usuario']['cod']);
                $objFolhaDeRosto->setEntrada_laboratorio(date("d/m/Y", strtotime($_GET['dataEntradaLaboratório'])));
                $objFolhaDeRosto->setReincidencia($_GET['reicidencia']);
                $objFolhaDeRosto->setTipo_solicitacao($_GET['tipoSolicitacao']);
                $objFolhaDeRosto->setModelo($_GET['modelo']);
                $objFolhaDeRosto->setNumero_serie($_GET['nSerie']);
                $objFolhaDeRosto->setDefeito_apresentado($_GET['defeitosApresentado']);
                $objFolhaDeRosto->setServicos_executados($_GET['servicosExecutados']);
                $objFolhaDeRosto->setBurnin_test($_GET['burninTest']);
                if (isset($_GET['causaReincidencia']))
                    $objFolhaDeRosto->setCausa_reincidencia($_GET['causaReincidencia']);

                if (isset($_GET['pecasTrocadas'])) {
                    foreach ($_GET['pecasTrocadas'] as $val) {
                        $pecasTrocadas .= $val . ",";
                    }
                    $objFolhaDeRosto->setPecas_trocadas($pecasTrocadas);
                }

                if ($objFolhaDeRosto->editar_por_cod_AT()) {
                    if (!empty($objFolhaDeRosto->getDefeito_apresentado()) && !empty($objFolhaDeRosto->getServicos_executados()) && !empty($objFolhaDeRosto->getPecas_trocadas())) {
                        $objRevisao = new Revisao();
                        $objRevisao->setCod_folha($objFolhaDeRosto->getCod());
                        $objRevisao->setStatus(0);
                        $objRevisao->setMotivo('');
                        $objRevisao->setRevisor($_SESSION['usuario']['cod']);
                        $objRevisao->criar();
                    }

                    echo '
                    <script>
                        $("#mensagem").toggle(30);
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                        setTimeout(function(){
                            $("#mensagem").toggle(300);
                            window.location.href = "../ver/minhasFolhas.php";
                        }, 3 * 1000);
                    </script>
                    ';
                } else {
                    echo '
                    <script>
                        $("#mensagem").text("Algo esta errado... Preencha todos os campos por favor.");
                        $("#mensagem").removeClass("alert-success");
                        $("#mensagem").addClass("alert-danger");
                        $("#mensagem").toggle(30);
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                        setTimeout(function(){
                            $("#mensagem").toggle(300);
                            $("#mensagem").removeClass("alert-danger");
                            $("#mensagem").addClass("alert-success");
                        }, 5 * 1000);
                    </script>
                    ';
                }
            }
            ?>
        </div>
    </section>
    <script>
        //script para marcar os checkboxes descEstetica
        var descEstetica = "<?php echo $objFolhaDeRosto->getDesc_estetica_equipamento() ?>";
        var descEsteticaArray = descEstetica.split(",");
        var i;

        var pecasTrocadas = "<?php echo $objFolhaDeRosto->getPecas_trocadas() ?>";
        var pecasTrocadasArray = pecasTrocadas.split(",");

        var descDefeitoReclamado = "<?php echo $objFolhaDeRosto->getDesc_defeito_reclamado() ?>";
        var descDefeitoReclamadoArray = descDefeitoReclamado.split(",");

        let qtdCheck = 0;


        function verificaQuantidadeChecked() {
            $("input[name='pecasTrocadas[]']").each(
                function() {
                    if ($(this).is(':checked')) {
                        qtdCheck += 1;
                    }
                }
            );

        }


        function pesquisarPecas(data) {
            $.get("../../_functionsPHP/folhaDeRosto/pesquisaPecas.php", data, function(retorno) {
                $("#pecasTrocadas").html(retorno);
            });
        }

        function inserirTags() {
            qtdCheck = 0;
            verificaQuantidadeChecked();
            console.log(qtdCheck);

            $("#tagsPecasTrocadas").html("");
            var tags = [];

            if (qtdCheck === 0) {
                $("input[value='Sem peças trocadas']").attr("checked", true);
            } else {
                $("input[value='Sem peças trocadas']").attr("checked", false);

            }

            $("input[name='pecasTrocadas[]']").each(
                function() {
                    if ($(this).is(':checked'))
                        tags.push($(this).val());
                    // $(this).val()
                }
            );
            tags.forEach(function(valor, chave) {
                $("#tagsPecasTrocadas").append('<span style="opacity:0.7" class="badge badge-dark mr-1 mb-1">' + valor + '</span>');
            })
        }


        $("input[name='descEstetica[]']").each(
            function() {
                for (i = 0; i < (descEsteticaArray["length"] - 1); i++) {
                    if (descEsteticaArray[i] == $(this).val())
                        $(this).attr("checked", true);
                }
                // $(this).val()
            }
        );


        $("input[name='descDefeitoReclamado[]']").each(
            function() {
                for (i = 0; i < (descDefeitoReclamadoArray["length"] - 1); i++) {
                    if (descDefeitoReclamadoArray[i] == $(this).val())
                        $(this).attr("checked", true);
                }
                // $(this).val()
            }
        );


        setTimeout(function() {

            if (pecasTrocadasArray.length === 1) {
                $("input[value='Sem peças trocadas']").attr("checked", true);
                inserirTags();
            }

            $("input[name='pecasTrocadas[]']").each(
                function() {
                    for (i = 0; i < (pecasTrocadasArray["length"] - 1); i++) {
                        if (pecasTrocadasArray[i] == $(this).val())
                            $(this).attr("checked", true);
                    }
                    // $(this).val()
                }
            );
            inserirTags();
        }, 200)

        //script para pesquisar as peças daquele devido partnumber
        $("input[name='partNumber']").val($("input[name='partNumber']").val().toUpperCase());
        var data = {
            partNumber: $("input[name='partNumber']").val()
        };
        $.get("../../_functionsPHP/folhaDeRosto/pesquisaPecas.php", data, function(retorno) {
            if (retorno.length < 7) {
                $("#pecasTrocadas").html(retorno);
            } else {
                $("#pecasTrocadas").html(retorno);
            }
        });
        pesquisarPecas(data);







        //pesquisando os modelos de acordo com o PARTNUMBER
        $("input[name='partNumber']").keyup(function(event) {
            $("input[name='partNumber']").val($("input[name='partNumber']").val().toUpperCase());
            var data = {
                partNumber: $("input[name='partNumber']").val()
            };
            $.get("../../_functionsPHP/folhaDeRosto/pesquisaPartNumber.php", data, function(retorno) {
                if (retorno.length < 7) {
                    $("#modelo").html("<option value=" + retorno + ">" + retorno + "</option>");
                } else {
                    $("#modelo").html(retorno);
                }
            });

            pesquisarPecas(data);
        })
        //CONSULTANDO SE JA EXISTE UMA FOLHA DE ROSTO
        $("input[name='nSerie']").keyup(function(event) {
            $("input[name='nSerie']").val($("input[name='nSerie']").val().toUpperCase());
            var data = {
                numero_serial: $("input[name='nSerie']").val()
            };
            var html;
            $.get("../../_functionsPHP/folhaDeRosto/pesquisaNumeroSerie.php", data, function(retorno) {
                if (retorno == 1) {
                    $("#reincidencia").addClass("bg-danger text-white p-1 disabled");
                    html = '<input type="radio" value="Sim" class="form-radio-input" name="reicidencia" checked="checked"><span> Sim </span>' +
                        '<input type="radio" value="Não" class="form-radio-input" name="reicidencia"><span> Não</span>';
                } else {
                    $("#reincidencia").removeClass("bg-danger text-white p-1 disabled");
                    html = '<input type="radio" value="Sim" class="form-radio-input" name="reicidencia"><span> Sim </span>' +
                        '<input type="radio" value="Não" class="form-radio-input" name="reicidencia" checked="checked"><span> Não</span>';
                }
                $("#reincidencia").html(html);
            });
        })

        //ocultando campo de mensagem
        $("#mensagem").toggle(1);
    </script>
</body>

</html>