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
    <link rel="stylesheet" href="../../assets/css/app.min.css">
    <title>Dashboard | SFC</title>



    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="left-side-menu">


<div class="h-100" id="left-side-menu-container" data-simplebar>

    <!--- Sidemenu -->
    <ul class="metismenu side-nav">

        <li class="side-nav-title side-nav-item">SFC - Shop Floor Control</li>

        <li class="side-nav-item">
            <a href="../../dashboard.php" class="side-nav-link">
                <span> Painel de controle </span>
            </a>
            <ul class="side-nav-second-level" aria-expanded="false">
                <li>
                    <a href="folhaDeRosto.php">Criar folha de rosto</a>
                </li>
                <li>
                    <a href="../../manutencao.html">Relátorios</a>
                </li>
                <li>
                    <a href="../../manutencao.html">Administração</a>
                </li>
                <?php
                    if($objUsuario->getNivel() > 3){
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
                            <span>Lançamento almoxarife</span>
                            <input type="date" class="" id="dataEntradaAlmoxarife" name="dataEntradaAlmoxarife">
                            <span> Entrada no Laboratório</span>
                            <input type="date" class="" id="dataEntradaLaboratório" name="dataEntradaLaboratório">
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
                            <input type="text" name="nomeCliente" style="width: 45%;">
                            <span>Modelo: </span>
                            <select name="modelo">
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
                            <span>Nº Série</span>
                            <input type="text" name="nSerie">
                        </div>
                        <div class="form-group">
                            <span>Reincidência:</span>
                            <input type="radio" value="Sim" class="form-radio-input" name="reicidencia"><span> Sim</span>
                            <input type="radio" value="Não" class="form-radio-input" name="reicidencia"><span> Não</span>
                        </div>
                        <div class="form-group">
                            <span>Acompanha fonte:</span>
                            <input type="radio" value="Sim" class="form-radio-input" name="acompanhaFonte"><span> Sim</span>
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
                        <?php
                        if ($objUsuario->getNivel() > 2) {
                            echo '<div class="form-group">
                                <span>Defeitos Apresentados</span>
                                <textarea class="form-control mt-2" style="resize: none;" name="defeitosApresentado" id="" cols="10" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <span>Peças Trocadas:</span>
                                <br>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                    Abrir opções
                                </button>
    
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Opções de peças trocadas</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body" style="height: 600px;overflow: hidden; overflow-y: scroll;">
                                                <div class="form-group">
                                                    <div class="ml-2 text-muted">
                                                        <span>Ajuste Bat.Cmos</span>
                                                        <input type="checkbox" value="Ajuste Bat.Cmos" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Ajuste Bateria</span>
                                                        <input type="checkbox" value="Ajuste Bateria" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Ajuste Cooler</span>
                                                        <input type="checkbox" value="Ajuste Cooler" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Ajuste LCD</span>
                                                        <input type="checkbox" value="Ajuste LCD" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Ajuste M.2.</span>
                                                        <input type="checkbox" value="Ajuste M.2." name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Ajuste Mem</span>
                                                        <input type="checkbox" value="Ajuste Mem" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Ajuste Wifi</span>
                                                        <input type="checkbox" value="Ajuste Wifi" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Antena Wifi</span>
                                                        <input type="checkbox" value="Antena Wifi" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Atualização BIOS</span>
                                                        <input type="checkbox" value="Atualização BIOS" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Bateria</span>
                                                        <input type="checkbox" value="Bateria" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Bateria CMOS</span>
                                                        <input type="checkbox" value="Bateria CMOS" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Cooler</span>
                                                        <input type="checkbox" value="Cooler" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Cover A</span>
                                                        <input type="checkbox" value="Cover A" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Cover B</span>
                                                        <input type="checkbox" value="Cover B" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Cover C</span>
                                                        <input type="checkbox" value="Cover C" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Cover D</span>
                                                        <input type="checkbox" value="Cover D" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Extensão SATA</span>
                                                        <input type="checkbox" value="Extensão SATA" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Extensão USB</span>
                                                        <input type="checkbox" value="Extensão USB" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Fonte</span>
                                                        <input type="checkbox" value="Fonte" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>HD-1TB</span>
                                                        <input type="checkbox" value="HD-1TB" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>HD-500GB</span>
                                                        <input type="checkbox" value="HD-500GB" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>LCD</span>
                                                        <input type="checkbox" value="LCD" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Limpeza</span>
                                                        <input type="checkbox" value="Limpeza" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Memória RAM</span>
                                                        <input type="checkbox" value="Memória RAM" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Mousepad</span>
                                                        <input type="checkbox" value="Mousepad" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Nova carga de S.O.</span>
                                                        <input type="checkbox" value="Nova carga de S.O." name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Orçamento Recusado</span>
                                                        <input type="checkbox" value="Orçamento Recusado" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Placa Mãe</span>
                                                        <input type="checkbox" value="Placa Mãe" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Recolocação de Tecla(as)</span>
                                                        <input type="checkbox" value="Recolocação de Tecla(as)" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Reembolso</span>
                                                        <input type="checkbox" value="Reembolso" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>S/D</span>
                                                        <input type="checkbox" value="S/D" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>SD Card</span>
                                                        <input type="checkbox" value="SD Card" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Speaker</span>
                                                        <input type="checkbox" value="Speaker" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>SSD-120</span>
                                                        <input type="checkbox" value="SSD-120" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>SSD-240</span>
                                                        <input type="checkbox" value="SSD-240" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Teclado</span>
                                                        <input type="checkbox" value="Teclado" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Touchpad</span>
                                                        <input type="checkbox" value="Touchpad" name="pecasTrocadas[]">
                                                        <br>
                                                        <span>Webcam</span>
                                                        <input type="checkbox" value="Webcam" name="pecasTrocadas[]">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="button" class="btn btn-danger">Aplicar peças</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- peças trocadas -->
                            <div class="form-group">
                                <span>Serviços Executados:</span>
                                <textarea name="servicosExecutados" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            ';
                        }
                        ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 d-flex justify-content-between flex-column">
                                    <span>Saída Laboratório: </span>

                                    <span>Laudo Emitido: </span>

                                    <span>Saída Logística: </span>
                                </div>
                                <div class="col-1">
                                    <input type="date" name="saidaLab">
                                    <br>
                                    <input class="mt-2" type="date" name="LaudoEmitido">
                                    <br>
                                    <input class="mt-2" type="date" name="saidaLogistica">
                                    <br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="submit" name="btnCriar" class="btn btn-danger btn-block btn-lg mb-5" value="Salvar" />
                    </form>
                </div>

            </div>
            <?php
            if (isset($_GET['btnCriar'])) {
                $descEstetica = NULL;
                $descDefeitoReclamado = NULL;

                $objFolhaDeRosto = new FolhaDeRosto();
                $objFolhaDeRosto->setUsuario($_SESSION['usuario']['cod']);
                $objFolhaDeRosto->setLancamento_almoxarife(date("d/m/Y", strtotime($_GET['dataEntradaAlmoxarife'])));
                $objFolhaDeRosto->setEntrada_laboratorio(date("d/m/Y", strtotime($_GET['dataEntradaLaboratório'])));
                $objFolhaDeRosto->setReincidencia($_GET['reicidencia']);
                $objFolhaDeRosto->setAcompanha_fonte($_GET['acompanhaFonte']);
                $objFolhaDeRosto->setTipo_solicitacao($_GET['tipoSolicitacao']);
                $objFolhaDeRosto->setNome_cliente($_GET['nomeCliente']);
                $objFolhaDeRosto->setModelo($_GET['modelo']);
                $objFolhaDeRosto->setNumero_serie($_GET['nSerie']);

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


                if ($objFolhaDeRosto->criar()) {
                    echo '
                    <script>
                        $("#mensagem").toggle(30);
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                        setTimeout(function(){
                            $("#mensagem").toggle(300);
                            window.location.href = "teste.php";
                        }, 3 * 1000);
                    </script>
                    ';
                }else{
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
        $("#mensagem").toggle(1);

        var dataEntradaAlmoxarife = document.getElementById("dataEntradaAlmoxarife");
        var dataEntradaLaboratório = document.getElementById("dataEntradaLaboratório");
        var today = new Date();

        dataEntradaAlmoxarife.value = today.toISOString().substr(0, 10);
        dataEntradaLaboratório.value = today.toISOString().substr(0, 10);
    </script>
</body>

</html>