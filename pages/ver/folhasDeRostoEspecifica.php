<?php
session_start();
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
require '../../_Class/Revisao.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}


$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();


if ($objUsuario->getNivel() < 2) {
    header("Location:../../dashboard.php");
}


$modelos = file_get_contents('../../assets/data/modelo.json');
$modelos = json_decode($modelos);

$partNumbers = file_get_contents('../../assets/data/partNumber.json');
$partNumbers = json_decode($partNumbers);


//
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
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Consultar de folha de rosto | SFC</title>
    <style>
        .style {
            margin-top: 1rem;
            width: 98vw;
            min-height: 450px;
        }

        .style .filtros {
            width: 15%;
            padding: 1rem;
            align-items: flex-start;
            justify-content: flex-start;
            display: flex;
            height: 750px;
        }

        .style .filtros form input {
            font-size: 8pt;
        }

        .style .filtros form select {
            font-size: 10pt;
        }

        .style .corpo {
            width: 85%;
        }

        .table {
            font-size: small;
        }
    </style>

</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>


    <div class="container d-flex justify-content-center">
        <div id="acoes">

            <div class="row style d-flex justify-content-start align-items-start text-center" id="cards">
                <div class="row p-2 w-100 d-flex justify-content-center align-item-center">
                    <div class="col d-flex justify-content-center">
                        <a href="minhasFolhas.php" class="btn btn-lg btn-danger">Ver Minhas Folhas de Rosto</a>
                    </div>
                </div>
                <div class="row">
                    <div class="filtros">
                        <form class="w-100 pb-3" autocomplete="off" id="filtro" onsubmit="event.preventDefault()">
                            <div class="form-group">
                                <small>Pesquisa chave:</small>
                                <input class="form-control" type="text" name="pesquisa" id="pesquisa" placeholder="Nome ou número de série">
                            </div>
                            <div class="form-group">
                                <small>Data de entrada:</small>
                                <input class="form-control" type="date" name="dataEntrada">
                            </div>
                            <div class="form-group">
                                <small>Data de saída:</small>
                                <input class="form-control" type="date" name="dataSaida">
                            </div>
                            <div class="form-group">
                                <small>Tipo solicitação:</small>
                                <select name="tipoSolicitacao">
                                    <option value="">Todos</option>
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
                                <small>Modelos:</small>
                                <select name="modelo">
                                    <option value="">Todos</option>
                                    <?php
                                    foreach ($modelos as $modelo => $partNumber) {
                                        echo '<option value="' . $modelo . '">' . $modelo . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <small>Part Number:</small>
                                <select name="partNumber">
                                    <option value="">Todos</option>
                                    <?php
                                    foreach ($partNumbers as $partNumber => $modelo) {
                                        echo '<option value="' . $partNumber . '">' . $partNumber . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <small>Reincidência:</small>
                                <select name="reincidencia">
                                    <option value="">Todos</option>
                                    <option value="Sim">Sim</option>
                                    <option value="Não">Não</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <small>Data de início de reparo:</small>
                                <input class="form-control" type="date" name="dataEntradaLaboratorio">
                            </div>
                            <div class="form-group">
                                <small>Criada por:</small>
                                <select name="usuario">
                                    <option value="">Todos</option>
                                    <option value="18">Edilene</option>
                                    <option value="1">João</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                            <label>Responsável:</label>
                            <br>
                            <input type="checkbox" name="responsavel[]" id="" value="Guilherme">
                            <small>Guilherme:</small>
                            <br>
                            <input type="checkbox" name="responsavel[]" id="" value="Guilherme">
                            <small>Guilherme:</small>

                        </div>
                        <div class="form-group">
                            <small>Status:</small>
                            <select name="status" id="">
                                <option value="Disponível para reparo">Disponível para reparo</option>
                            </select>
                        </div> -->
                            <button type="submit" onclick="getDadosForm()" class="btn btn-primary">Procurar</button>
                        </form>
                    </div>
                    <div class="corpo p-2">
                        <table class="table" id="tableSearch">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Tipo Solicitação</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Nº Série</th>
                                    <th scope="col">Reincidência</th>
                                    <th scope="col">Data inicio de reparo</th>
                                    <th scope="col">Criada por:</th>
                                    <th scope="col">Responsável</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">AGING dentro da logística</th>
                                </tr>
                            </thead>
                            <tbody id="tbodySearch">

                                <?php
                                $cargo = 'AT';
                                include '../../_functionsPHP/pesquisa/pesquisar.php';
                                ?>

                            </tbody>
                        </table>
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
        let dadosForm = null;
        $('#tableSearch').DataTable({
            order: [0, 'desc'],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });


        //funcao para pegar os dados do formulario
        function getDadosForm() {
            dadosForm = {
                dataEntrada: $('input[name="dataEntrada"]').val(),
                dataSaida: $('input[name="dataSaida"]').val(),
                tipo_solicitacao: $('select[name="tipoSolicitacao"]').val(),
                reincidencia: $('select[name="reincidencia"]').val(),
                dataEntradaLaboratorio: $('input[name="dataEntradaLaboratorio"]').val(),
                usuario: $('select[name="usuario"]').val(),
                modelo: $('select[name="modelo"]').val(),
                partNumber: $('select[name="partNumber"]').val(),
                pesquisa: $('input[name="pesquisa"]').val(),
                cargo: 'AT'
            }

            pesquisar(dadosForm);

        }

        function pesquisar(data) {
            $('#tableSearch').DataTable().clear().destroy();

            $.get("../../_functionsPHP/pesquisa/pesquisar.php", data, function(retorno) {
                console.log(data);
                $("#tbodySearch").html(retorno);
                $('#tableSearch').DataTable({
                    order: [0, 'desc'],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            })
        }

        // datatableLogs.clear();
        // datatableLogs.rows.add(retorno);
        // datatableLogs.draw();
    </script>
</body>

</html>