<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../index.php");
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
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Criar Folha de Rosto | SFC</title>



    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>

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
                            <h1 class=" text-muted">Assistencia Técnica | Folha de rosto</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- corpo para folha de rosto -->
            <div class="row mt-5">
                <div class="col-11">
                    <div class="alert alert-success" id="mensagem" role="alert">
                        Folha criada com sucesso!
                    </div>
                    <form autocomplete="off">
                        <div class="form-group">
                            <span>Entrada logística</span>
                            <input type="date" class="" id="dataEntradaAlmoxarife" name="dataEntradaAlmoxarife">

                            <span> Tipo de Solicitação</span>
                            <select name="tipoSolicitacao">
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
                            <input type="text" name="nomeCliente" style="width: 45%;text-transform: capitalize;" required>

                            <span>PartNumber</span>
                            <input type="text" name="partNumber" id="partNumber">

                            <span>Modelo: </span>
                            <select name="modelo" id="modelo" required>
                                <option value="Sem seleção">Sem seleção</option>
                                <optgroup label="NOTEBOOK">
                                    <option value="CQ-15">CQ-15</option>
                                    <option value="CQ-17">CQ-17</option>
                                    <option value="CQ-21">CQ-21</option>
                                    <option value="CQ-23">CQ-23</option>
                                    <option value="CQ-25">CQ-25</option>
                                    <option value="CQ-27">CQ-27</option>
                                    <option value="CQ-29">CQ-29</option>
                                    <option value="CQ-31">CQ-31</option>
                                    <option value="CQ-32">CQ-32</option>
                                    <option value="CQ-360">CQ-360</option>
                                </optgroup>
                                <optgroup label="DESKTOP">
                                    <option value="CQ-11">CQ-11</option>
                                    <option value="CQ-14">CQ-14</option>
                                </optgroup>
                                <optgroup label="ALL IN ONE">
                                    <option value="CQ-A1">CQ-A1</option>
                                </optgroup>
                            </select>
                            <br><br>
                            <span>Nº Série</span>
                            <input type="text" name="nSerie">
                        </div>
                        <div class="form-group">
                            <span>Reincidência:</span>
                            <div id="reincidencia">
                                <input type="radio" value="Sim" class="form-radio-input" name="reicidencia"><span> Sim</span>
                                <input type="radio" value="Não" class="form-radio-input" name="reicidencia" checked="checked"><span> Não</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <span>Acompanha fonte:</span>
                            <input type="radio" value="Sim" class="form-radio-input" name="acompanhaFonte" checked="checked"><span> Sim</span>
                            <input type="radio" value="Não" class="form-radio-input" name="acompanhaFonte"><span> Não</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>Descrição da Estética do Equipamento:</span>
                                    <br>
                                    <small class="text-muted">Atentar para a caixa amassada ou com furos</small>
                                    <br>
                                    <div class="ml-2 text-muted">
                                        <input type="checkbox" value="Equipamento em bom estado" name="descEstetica[]">
                                        <span>Equipamento em bom estado</span>
                                        <br>
                                        <input type="checkbox" value="Manchas Cover A" name="descEstetica[]">
                                        <span>Manchas Cover A</span>
                                        <br>
                                        <input type="checkbox" value="Manchas Cover D" name="descEstetica[]">
                                        <span>Manchas Cover D</span>
                                        <br>
                                        <input type="checkbox" value="Novo" name="descEstetica[]">
                                        <span>Novo</span>
                                        <br>
                                        <input type="checkbox" value="Riscos Cover A" name="descEstetica[]">
                                        <span>Riscos Cover A</span>
                                        <br>
                                        <input type="checkbox" value="Riscos Cover B" name="descEstetica[]">
                                        <span>Riscos Cover B</span>
                                        <br>
                                        <input type="checkbox" value="Riscos Cover C" name="descEstetica[]">
                                        <span>Riscos Cover C</span>
                                        <br>
                                        <input type="checkbox" value="Riscos Cover D" name="descEstetica[]">
                                        <span>Riscos Cover D</span>
                                        <br>
                                        <input type="checkbox" value="Riscos e Ranhuras por toda carcaça" name="descEstetica[]">
                                        <span>Riscos e Ranhuras por toda carcaça</span>
                                        <br>
                                        <input type="checkbox" value="Riscos leves Cover A" name="descEstetica[]">
                                        <span>Riscos leves Cover A</span>
                                        <br>
                                        <input type="checkbox" value="Saldo A" name="descEstetica[]">
                                        <span>Saldo A</span>
                                        <br>
                                        <input type="checkbox" value="Saldo B" name="descEstetica[]">
                                        <span>Saldo B</span>
                                        <br>
                                        <input type="checkbox" value="Sem pé no Cover D" name="descEstetica[]">
                                        <span>Sem pé no Cover D</span>
                                    </div>
                                    <textarea name="observacao" id="" cols="30" rows="4" style="resize: none;padding:1em;margin-top: 1em;" placeholder="Digite aqui a sua observação"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>Descrição do defeito reclamado:</span>
                                    <br>
                                    <div class="ml-2 text-muted">
                                        <input type="checkbox" value="Bluetooth Não Conecta" name="descDefeitoReclamado[]">
                                        <span>Bluetooth Não Conecta</span>
                                        <br>
                                        <input type="checkbox" value="Falha de Áudio / Microfone" name="descDefeitoReclamado[]">
                                        <span>Falha de Áudio / Microfone</span>
                                        <br>
                                        <input type="checkbox" value="Falha de teclado" name="descDefeitoReclamado[]">
                                        <span>Falha de Teclado</span>
                                        <br>
                                        <input type="checkbox" value="Fonte / Carregador" name="descDefeitoReclamado[]">
                                        <span>Fonte / Carregador</span>
                                        <br>
                                        <input type="checkbox" value="Mouse / Touchpad" name="descDefeitoReclamado[]">
                                        <span>Mouse / Touchpad</span>
                                        <br>
                                        <input type="checkbox" value="Não Carrega o Windows" name="descDefeitoReclamado[]">
                                        <span>Não Carrega o Windows</span>
                                        <br>
                                        <input type="checkbox" value="Não Liga / Sem imagem" name="descDefeitoReclamado[]">
                                        <span>Não Liga / Sem imagem</span>
                                        <br>
                                        <input type="checkbox" value="Não Reconhece CD/DVD" name="descDefeitoReclamado[]">
                                        <span>Não Reconhece CD/DVD</span>
                                        <br>
                                        <input type="checkbox" value="Não Reconhece HD" name="descDefeitoReclamado[]">
                                        <span>Não Reconhece HD</span>
                                        <br>
                                        <input type="checkbox" value="Porta de REDE Não Funciona" name="descDefeitoReclamado[]">
                                        <span>Porta de REDE Não Funciona</span>
                                        <br>
                                        <input type="checkbox" value="Porta de SDCARD Não Funciona" name="descDefeitoReclamado[]">
                                        <span>Porta de SDCARD Não Funciona</span>
                                        <br>
                                        <input type="checkbox" value="Porta HDMI Não Funciona" name="descDefeitoReclamado[]">
                                        <span>Porta HDMI Não Funciona</span>
                                        <br>
                                        <input type="checkbox" value="Porta USB Não Funciona" name="descDefeitoReclamado[]">
                                        <span>Porta USB Não Funciona</span>
                                        <br>
                                        <input type="checkbox" value="Problemas na tela" name="descDefeitoReclamado[]">
                                        <span>Problemas na tela</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="checkbox" id="terminado" required>
                        <label for="terminado">Finalização</label>
                        <br>
                        <input type="submit" name="btnCriar" class="btn btn-danger btn-block btn-lg mb-5" value="Salvar" />
                    </form>
                </div>

            </div>
            <?php
            if (isset($_GET['btnCriar'])) {
                $nome = $_GET['nomeCliente'];
                $nomeExplode = explode(" ", $nome);
                $descEstetica = NULL;
                $descDefeitoReclamado = NULL;

                $objFolhaDeRosto = new FolhaDeRosto();
                $objFolhaDeRosto->setUsuario($_SESSION['usuario']['cod']);
                $objFolhaDeRosto->setLancamento_almoxarife(date("d/m/Y", strtotime($_GET['dataEntradaAlmoxarife'])));
                $objFolhaDeRosto->setReincidencia($_GET['reicidencia']);
                $objFolhaDeRosto->setAcompanha_fonte($_GET['acompanhaFonte']);
                $objFolhaDeRosto->setTipo_solicitacao($_GET['tipoSolicitacao']);
                $objFolhaDeRosto->setModelo($_GET['modelo']);
                $objFolhaDeRosto->setNumero_serie($_GET['nSerie']);
                $objFolhaDeRosto->setPart_number($_GET['partNumber']);
                $objFolhaDeRosto->setObservacao($_GET['observacao']);

                $nome = "";
                for ($i = 0; $i < count($nomeExplode); $i++) {
                    $j = (strlen($nomeExplode[$i])) * -1;
                    $nome .= strtoupper(substr($nomeExplode[$i], $j, 1)) . substr($nomeExplode[$i], 1) . " ";
                }
                $nome = rtrim($nome, " ");
                
                $objFolhaDeRosto->setNome_cliente($nome);

                if (isset($_GET['descEstetica'])) {
                    foreach ($_GET['descEstetica'] as $val) {
                        $descEstetica .= $val . ",";
                    }
                    $objFolhaDeRosto->setDesc_estetica_equipamento($descEstetica);
                }

                if (isset($_GET['descDefeitoReclamado'])) {
                    foreach ($_GET['descDefeitoReclamado'] as $val) {
                        $descDefeitoReclamado .= $val . ",";
                    }
                    $objFolhaDeRosto->setDesc_defeito_reclamado($descDefeitoReclamado);
                }
                $objFolhaDeRostoAux = new FolhaDeRosto();
                $objFolhaDeRostoAux->setNumero_serie($objFolhaDeRosto->getNumero_serie());
                $folhaComSerial = $objFolhaDeRostoAux->consultar_por_serial();
                if ($folhaComSerial == false) {
                    if ($objFolhaDeRosto->criar()) {
                        echo '
                        <script>
                            $("#mensagem").toggle(30);
                            $("html, body").animate({
                                scrollTop: 0
                            }, "slow");
                            setTimeout(function(){
                                $("#mensagem").toggle(300);
                                window.location.href = "folhaDeRosto.php";
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
                } else {
                    if (!empty($objFolhaDeRostoAux->getLaudo_emitido()) || !empty($folhaComSerial['tec_responstavel_old'])) {
                        if ($objFolhaDeRosto->criar()) {
                            echo '
                            <script>
                                $("#mensagem").toggle(30);
                                $("html, body").animate({
                                    scrollTop: 0
                                }, "slow");
                                setTimeout(function(){
                                    $("#mensagem").toggle(300);
                                    window.location.href = "folhaDeRosto.php";
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
                    } else {
                        echo '
                            <script>
                                $("#mensagem").text("Algo esta errado... Folha de rosto ja em processo!");
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
            }
            ?>
        </div>
    </section>
    <script>
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
        })

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



        $("#mensagem").toggle(1);

        var dataEntradaAlmoxarife = document.getElementById("dataEntradaAlmoxarife");
        var dataEntradaLaboratório = document.getElementById("dataEntradaLaboratório");
        var today = new Date();

        dataEntradaAlmoxarife.value = today.toISOString().substr(0, 10);
        dataEntradaLaboratório.value = today.toISOString().substr(0, 10);
    </script>
</body>

</html>