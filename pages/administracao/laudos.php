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
    <title>Emitir laudos | SFC</title>
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
            font-size: 9pt;
        }
    </style>

</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>

   
    <div class="container d-flex justify-content-center">
        <div id="acoes">

            <div class="row style d-flex justify-content-start align-items-start text-center" id="cards">
                <div class="filtros">
                    <form class="w-100 pb-3" autocomplete="off" id="filtro" onsubmit="event.preventDefault()">
                        <div class="form-group">
                            <small>Pesquisa chave:</small>
                            <input class="form-control" type="text" name="pesquisa" id="pesquisa" placeholder="Nome ou n??mero de s??rie">
                        </div>
                        <div class="form-group">
                            <small>Data de entrada:</small>
                            <input class="form-control" type="date" name="dataEntrada">
                        </div>
                        <div class="form-group">
                            <small>Data de sa??da:</small>
                            <input class="form-control" type="date" name="dataSaida">
                        </div>
                        <div class="form-group">
                            <small>Tipo solicita????o:</small>
                            <select name="tipoSolicitacao">
                                <option value="">Todos</option>
                                <option value="Reparo em Garantia">Reparo em Garantia</option>
                                <option value="Analise de Troca">Analise de Troca</option>
                                <option value="Equipamento Loja">Equipamento Loja</option>
                                <option value="Or??amento Particular">Or??amento Particular</option>
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
                            <small>Reincid??ncia:</small>
                            <select name="reincidencia">
                                <option value="">Todos</option>
                                <option value="Sim">Sim</option>
                                <option value="N??o">N??o</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <small>Data de in??cio de reparo:</small>
                            <input class="form-control" type="date" name="dataEntradaLaboratorio">
                        </div>

                        <!-- <div class="form-group">
                            <small>Criada por:</small>
                            <select name="usuario">
                                <option value="">Todos</option>
                                <option value="18">Edilene</option>
                                <option value="1">Jo??o</option>
                            </select>
                        </div>
                            <div class="form-group">
                            <label>Respons??vel:</label>
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
                                <option value="Dispon??vel para reparo">Dispon??vel para reparo</option>
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
                                <th scope="col">Data entrada</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Tipo Solicita????o</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">N?? S??rie</th>
                                <th scope="col">Reincid??ncia</th>
                                <th scope="col">Data inicio de reparo</th>
                                <th scope="col">Criada por</th>
                                <th scope="col">Respons??vel</th>
                                <th scope="col">Data Saida</th>
                                <th scope="col">A????o</th>
                            </tr>
                        </thead>
                        <tbody id="tbodySearch">

                            <?php
                            $cargo = 'EmitirLaudo';
                            include '../../_functionsPHP/pesquisa/pesquisar.php';
                            ?>

                        </tbody>
                    </table>
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
                cargo: 'EmitirLaudo'
            }

            pesquisar(dadosForm);

        }

        function pesquisar(data) {
            $('#tableSearch').DataTable().clear().destroy();

            $.get("../../_functionsPHP/pesquisa/pesquisar.php", data, function(retorno) {
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