<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../index.php");
}
$objUsuario = new Usuario();
$objFolhaDeRosto = new FolhaDeRosto();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

if (!isset($_GET['folha'])) {
    header("Location:../../dashboard.php");
} else {
    $objFolhaDeRosto->setCod($_GET['folha']);
    $objFolhaDeRosto->consultar_por_codigo();

    $lancamentoAlmoxarife = date('Y-m-d', strtotime(str_replace("/", "-", $objFolhaDeRosto->getLancamento_almoxarife())));
}
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
                            <input type="date" id="dataEntradaAlmoxarife" name="dataEntradaAlmoxarife" value=<?php echo $lancamentoAlmoxarife ?>>
                            <span> Tipo de Solicitação</span>
                            <select name="tipoSolicitacao">
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
                            <input type="text" name="nomeCliente" <?php echo 'value="' . $objFolhaDeRosto->getNome_cliente() . '"'; ?> style="width: 45%;">
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
                            if ($objFolhaDeRosto->getReincidencia() == "Não" || $objFolhaDeRosto->getReincidencia() == "NÃO" || $objFolhaDeRosto->getReincidencia() == "NAO") {
                                echo '<input type="radio" value="Sim" class="form-radio-input" name="reicidencia"><span> Sim</span>
                                    <input type="radio" value="Não" class="form-radio-input" name="reicidencia" checked="checked"><span> Não</span>';
                            } else {
                                echo '<input type="radio" value="Sim" class="form-radio-input" name="reicidencia"  checked="checked"><span> Sim</span>
                                        <input type="radio" value="Não" class="form-radio-input" name="reicidencia"><span> Não</span>';
                            }
                            ?>

                        </div>
                        <div class="form-group">
                            <span>Acompanha fonte:</span>
                            <?php
                            if ($objFolhaDeRosto->getAcompanha_fonte() == "Sim") {
                                echo '<input type="radio" value="Sim" class="form-radio-input" name="acompanhaFonte" checked="checked"><span> Sim</span>
                                    <input type="radio" value="Não" class="form-radio-input" name="acompanhaFonte"><span> Não</span>';
                            } else {
                                echo '<input type="radio" value="Sim" class="form-radio-input" name="acompanhaFonte"><span> Sim</span>
                                    <input type="radio" value="Não" class="form-radio-input" name="acompanhaFonte" checked="checked"><span> Não</span>';
                            }
                            ?>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>Descrição da Estética do Equipamento:</span>
                                    <br>
                                    <small class="text-muted">Atentar para a caixa amassada ou com furos</small>
                                    <br>
                                    <div class="ml-2 text-muted">
                                        <span>Equipamento em bom estado</span>
                                        <input type="checkbox" value="Equipamento em bom estado" name="descEstetica[]">
                                        <br>
                                        <span>Manchas Cover A</span>
                                        <input type="checkbox" value="Manchas Cover A" name="descEstetica[]">
                                        <br>
                                        <span>Manchas Cover D</span>
                                        <input type="checkbox" value="Manchas Cover D" name="descEstetica[]">
                                        <br>
                                        <span>Novo</span>
                                        <input type="checkbox" value="Novo" name="descEstetica[]">
                                        <br>
                                        <span>Riscos Cover A</span>
                                        <input type="checkbox" value="Riscos Cover A" name="descEstetica[]">
                                        <br>
                                        <span>Riscos Cover B</span>
                                        <input type="checkbox" value="Riscos Cover B" name="descEstetica[]">
                                        <br>
                                        <span>Riscos Cover C</span>
                                        <input type="checkbox" value="Riscos Cover C" name="descEstetica[]">
                                        <br>
                                        <span>Riscos Cover D</span>
                                        <input type="checkbox" value="Riscos Cover D" name="descEstetica[]">
                                        <br>
                                        <span>Riscos e Ranhuras por toda carcaça</span>
                                        <input type="checkbox" value="Riscos e Ranhuras por toda carcaça" name="descEstetica[]">
                                        <br>
                                        <span>Riscos leves Cover A</span>
                                        <input type="checkbox" value="Riscos leves Cover A" name="descEstetica[]">
                                        <br>
                                        <span>Saldo A</span>
                                        <input type="checkbox" value="Saldo A" name="descEstetica[]">
                                        <br>
                                        <span>Saldo B</span>
                                        <input type="checkbox" value="Saldo B" name="descEstetica[]">
                                        <br>
                                        <span>Sem pé no Cover D</span>
                                        <input type="checkbox" value="Sem pé no Cover D" name="descEstetica[]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>Descrição do defeito reclamado:</span>
                                    <br>
                                    <div class="ml-2 text-muted">
                                        <span>Bluetooth Não Conecta</span>
                                        <input type="checkbox" value="Bluetooth Não Conecta" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Falha de Áudio / Microfone</span>
                                        <input type="checkbox" value="Falha de Áudio / Microfone" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Falha de Teclado</span>
                                        <input type="checkbox" value="Falha de teclado" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Fonte / Carregador</span>
                                        <input type="checkbox" value="Fonte / Carregador" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Mouse / Touchpad</span>
                                        <input type="checkbox" value="Mouse / Touchpad" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Não Carrega o Windows</span>
                                        <input type="checkbox" value="Não Carrega o Windows" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Não Liga / Sem imagem</span>
                                        <input type="checkbox" value="Não Liga / Sem imagem" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Não Reconhece CD/DVD</span>
                                        <input type="checkbox" value="Não Reconhece CD/DVD" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Não Reconhece HD</span>
                                        <input type="checkbox" value="Não Reconhece HD" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Porta de REDE Não Funciona</span>
                                        <input type="checkbox" value="Porta de REDE Não Funciona" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Porta de SDCARD Não Funciona</span>
                                        <input type="checkbox" value="Porta de SDCARD Não Funciona" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Porta HDMI Não Funciona</span>
                                        <input type="checkbox" value="Porta HDMI Não Funciona" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Porta USB Não Funciona</span>
                                        <input type="checkbox" value="Porta USB Não Funciona" name="descDefeitoReclamado[]">
                                        <br>
                                        <span>Problemas na tela</span>
                                        <input type="checkbox" value="Problemas na tela" name="descDefeitoReclamado[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <textarea name="observacao" id="" cols="30" rows="4" style="resize: none;"><?= $objFolhaDeRosto->getObservacao(); ?></textarea>
                        <br>
                        <input type="submit" name="btnCriar" class="btn btn-danger btn-block btn-lg mb-5" value="Salvar" />
                    </form>
                </div>

            </div>
            <?php
            $codFolha = $_GET['folha'];
            if (isset($_GET['btnCriar'])) {
                $pecasTrocadas = NULL;
                $descEstetica = null;
                $descDefeitoReclamado = null;

                $objFolhaDeRosto = new FolhaDeRosto();
                $objFolhaDeRosto->setCod($codFolha);
                $objFolhaDeRosto->setLancamento_almoxarife(date("d/m/Y", strtotime($_GET['dataEntradaAlmoxarife'])));
                $objFolhaDeRosto->setTipo_solicitacao($_GET['tipoSolicitacao']);
                $objFolhaDeRosto->setNome_cliente($_GET['nomeCliente']);
                $objFolhaDeRosto->setModelo($_GET['modelo']);
                $objFolhaDeRosto->setPart_number($_GET['partNumber']);
                $objFolhaDeRosto->setNumero_serie($_GET['nSerie']);
                $objFolhaDeRosto->setReincidencia($_GET['reicidencia']);
                $objFolhaDeRosto->setAcompanha_fonte($_GET['acompanhaFonte']);
                $objFolhaDeRosto->setObservacao($_GET['observacao']);

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

                if ($objFolhaDeRosto->editar_administrativo()) {
                    echo '
                    <script>
                        $("#mensagem").toggle(30);
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                        setTimeout(function(){
                            $("#mensagem").toggle(300);
                            window.location.href = "./visualizarMaquinas.php";
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

        $("input[name='descEstetica[]']").each(
            function() {
                for (i = 0; i < (descEsteticaArray["length"] - 1); i++) {
                    if (descEsteticaArray[i] == $(this).val())
                        $(this).attr("checked", true);
                }
                // $(this).val()
            }
        );

        var descDefeitoReclamado = "<?php echo $objFolhaDeRosto->getDesc_defeito_reclamado() ?>";
        var descDefeitoReclamadoArray = descDefeitoReclamado.split(",");

        $("input[name='descDefeitoReclamado[]']").each(
            function() {
                for (i = 0; i < (descDefeitoReclamadoArray["length"] - 1); i++) {
                    if (descDefeitoReclamadoArray[i] == $(this).val())
                        $(this).attr("checked", true);
                }
                // $(this).val()
            }
        );

        var pecasTrocadas = "<?php echo $objFolhaDeRosto->getPecas_trocadas() ?>";
        var pecasTrocadasArray = pecasTrocadas.split(",");


        setTimeout(function() {
            $("input[name='pecasTrocadas[]']").each(
                function() {
                    for (i = 0; i < (pecasTrocadasArray["length"] - 1); i++) {
                        if (pecasTrocadasArray[i] == $(this).val())
                            $(this).attr("checked", true);
                    }
                    // $(this).val()
                }
            );
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

        //ocultando campo de mensagem
        $("#mensagem").toggle(1);
    </script>
</body>

</html>